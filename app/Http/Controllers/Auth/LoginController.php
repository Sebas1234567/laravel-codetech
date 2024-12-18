<?php

namespace Code\Http\Controllers\Auth;

use Code\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function redirectTo()
    {
        if (auth()->user()->esCliente()) {
            return '/';
        } elseif (auth()->user()->esTrabajador()) {
            return '/admin/dashboard';
        }
    }

    public function logout()
    {
        $userRole = Auth::user()->role;

        Auth::logout();

        return $userRole === 'cliente' ? redirect()->to('/login') : redirect()->to('/admin/login');
    }
}
