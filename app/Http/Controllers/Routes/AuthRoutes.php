<?php

namespace Code\Http\Controllers\Routes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Code\Http\Controllers\Controller;
use Code\Http\Controllers\Auth;

class AuthRoutes extends Controller
{
    public static function routes()
    {
        Route::get('/admin/login/', function () {
            return view('admin.auth.login');
        })->name('admin.login');

        Route::get('/admin/password/reset/', function () {
            return view('admin.auth.passwords.email');
        });

        Route::get('/admin/password/reset/{token}', function (Request $request) {
            $token = $request->route()->parameter('token');

            return view('admin.auth.passwords.reset')->with(
                ['token' => $token, 'email' => $request->email]
            );
        })->name('admin.password.reset');

        Route::get('/password/reset/{token}', [Auth\ResetPasswordController::class, 'showResetForm'])
            ->name('web.password.reset');

        Route::get('/admin/lock', [Auth\LockController::class, 'showLockForm'])->name('lock.form');
        Route::post('/admin/unlock', [Auth\LockController::class, 'unlockSession'])->name('unlock.session');
    }
}
