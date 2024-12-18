<?php

namespace Code\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Code\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Code\Http\Controllers\Controller;

class LockController extends Controller
{
    public function showLockForm(Request $request)
    {
        $ruta = $request->get('url');
        return view('admin.auth.lock',['url'=>$ruta]);
    }

    public function unlockSession(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
            'url'=>'string'
        ]);
        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            return redirect()->intended($request->url);
        }
        return redirect()->route('lock.form')->with('error', 'Invalid password. Please try again.');
    }
}
