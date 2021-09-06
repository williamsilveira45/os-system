<?php

namespace App\Actions\Auth;


use App\Http\Traits\Actions\ActionBase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

/**
 * Class Login
 *
 * Return pending payments
 *
 * @package App\Actions\Payment
 */
class Login
{
    use ActionBase;

    protected function setParameters(array $data): void
    {
        $this->data = [
            'email' => $data['email'] ?? '',
            'password' => $data['password'] ?? '',
        ];
    }

    protected function main()
    {
        $this->validation();

        $this->authenticate();

        request()->session()->regenerate();

        return redirect(RouteServiceProvider::HOME);
    }

    private function validation()
    {
        Validator::make($this->data, [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ])->validate();
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $attempt = Auth::attempt([
            'email' => $this->data['email'],
            'password' => $this->data['password']
        ]);

        if (!$attempt) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower($this->data['email']).'|'.request()->ip();
    }
}
