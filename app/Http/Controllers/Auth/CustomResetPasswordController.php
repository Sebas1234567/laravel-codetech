<?php

namespace Code\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Code\Models\User;
use Code\Http\Controllers\Controller;

class CustomResetPasswordController extends Controller
{
    public function redirectPass(Request $request, $token)
    {
        $email = $request->query('email');
        $user = User::where('email', $email)->first();
        $redirectUrl = $user && $user->role === 'trabajador'
            ? route('admin.password.reset', ['token' => $token, 'email' => $email])
            : route('web.password.reset', ['token' => $token, 'email' => $email]);
        return redirect($redirectUrl);
    }
}
