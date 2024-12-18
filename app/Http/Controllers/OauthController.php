<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Code\Models\User;

class OauthController extends Controller
{
    public function callbackGoogle(){
        $user = Socialite::driver('google')->user();
        $userExist = User::where('external_id',$user->id)->where('external_auth','google')->first();
        if ($userExist) {
            Auth::login($userExist);
        } else {
            $userNew = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'imagen' => $user->avatar,
                'role' => 'cliente',
                'estado' => 1,
                'external_id' => $user->id,
                'external_auth' => 'google'
            ]);
            Auth::login($userNew);
        }
        return redirect()->route('index');
    }

    public function callbackGithub(){
        $user = Socialite::driver('github')->user();
        $userExist = User::where('external_id',$user->id)->where('external_auth','github')->first();
        if ($userExist) {
            Auth::login($userExist);
        } else {
            $userNew = User::create([
                'name' => $user->name ? $user->name : $user->nickname,
                'email' => $user->email,
                'imagen' => $user->avatar,
                'role' => 'cliente',
                'estado' => 1,
                'external_id' => $user->id,
                'external_auth' => 'github'
            ]);
            Auth::login($userNew);
        }
        return redirect()->route('index');
    }

    public function callbackGitlab(){
        $user = Socialite::driver('gitlab')->user();
        $userExist = User::where('external_id',$user->id)->where('external_auth','gitlab')->first();
        if ($userExist) {
            Auth::login($userExist);
        } else {
            $userNew = User::create([
                'name' => $user->name ? $user->name : $user->nickname,
                'email' => $user->email,
                'imagen' => $user->avatar,
                'role' => 'cliente',
                'estado' => 1,
                'external_id' => $user->id,
                'external_auth' => 'gitlab'
            ]);
            Auth::login($userNew);
        }
        return redirect()->route('index');
    }

    public function callbackFacebook(){
        $user = Socialite::driver('facebook')->user();
        dd($user);
    }
}
