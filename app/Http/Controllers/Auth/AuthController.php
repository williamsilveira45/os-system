<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\Login;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Auth/Login', [
            'appName' => config('app.name')
        ]);
    }

    /**
     * @param Request $request
     * @return \Inertia\Response
     * @throws \Exception
     */
    public function login(Request $request)
    {
        return (new Login())->execute($request->all([
            'email',
            'password'
        ]));
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect(RouteServiceProvider::LOGOUT);
    }
}
