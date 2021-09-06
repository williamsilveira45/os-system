<?php

namespace App\Http\Traits\Actions;

use App\Exceptions\GracefulDetailedException;
use App\Helpers\SlackMessages;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

trait ApiResponseMessage
{
    public function handleException(Exception $exception, $errorCode = null): JsonResponse
    {
        $data = [];
        $message = null;

        if ($exception instanceof \PDOException) {
            $errorCode = 500;
            $message = config('app.env') === 'production' ? __('error.general_error') : $exception->getMessage();
        }

        if ($exception instanceof GracefulDetailedException) {
            $data += [
                'details' => $exception->details
            ];
            $errorCode = 200;
        }

        if ($exception instanceof ValidationException) {
            $data += [
                'errors' => $exception->errors(),
            ];
            $message = __('validation.invalid_data');
            $errorCode = 200;
        }

        if (config('app.env') !== 'production') {
            $data += [
                'file' => $exception->getFile() . ':' . $exception->getLine(),
                'trace' => $exception->getTraceAsString()
            ];
        }

        $code = (empty($errorCode) && empty($exception->getCode())) ? 200 : $errorCode ?? $exception->getCode();
        $message = $message ?? $exception->getMessage();

        if (App::environment(['production']) && substr($errorCode, 0, 1) === '5') {
            //slack message
            $userMessage = Auth::check() ? "User: " . Auth::user()->name . " (" . Auth::user()->id .")" : '';
            $slackMessage = "{$userMessage}\n" .
                "Message: {$message}\n" .
                "Exception {$exception->getMessage()}\n" .
                "File: {$exception->getFile()}:{$exception->getLine()}";

            SlackMessages::sendToNotifications("```{$slackMessage}```");
        }

        return $this->responseMessage(false, $message, $data, $code);
    }

    protected function responseMessage(bool $success, string $message, array $data = [], $headerCode = 200): JsonResponse
    {
        $dataResponse = [
            'success' => $success,
            'message' => $message,
        ];

        if (!empty($data)) {
            $dataResponse += $data;
        }

        return response()->json($dataResponse, $headerCode);
    }
}
