<?php

namespace Code\Http\Controllers\Auth;

use Code\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    protected function redirectTo()
    {
        if (auth()->user()->esCliente()) {
            return '/';
        } elseif (auth()->user()->esTrabajador()) {
            return '/admin/dashboard';
        }
    }
}
