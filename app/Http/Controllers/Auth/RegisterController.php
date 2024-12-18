<?php

namespace Code\Http\Controllers\Auth;

use Code\Http\Controllers\Controller;
use Code\Models\User;
use Code\Models\Notificaciones;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use Code\Notifications\RegisterToken;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \Code\Models\User
     */
    protected function create(array $data)
    {
        $codigo = rand(100000, 999999);
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role'=>'cliente',
            'imagen' => 'png/avatar.png',
            'verification_code' => $codigo,
            'estado' => 0,
        ]);
        Notificaciones::create([
            'titulo' => 'Usuario',
            'descripcion' => 'Nuevo usuario registrado.',
            'icono' => 'fa-duotone fa-user-plus',
            'color' => 'text-success',
            'url' => 'admin/usuarios',
            'visto' => 0,
            'toast' => 0,
        ]);
        Notification::route('mail', $data['email'])->notify(new RegisterToken($codigo));
        return $user;
    }

    protected function redirectTo()
    {
        if (auth()->user()->esCliente()) {
            $user = User::latest()->first();
            return '/email-verification';
        } elseif (auth()->user()->esTrabajador()) {
            return '/admin/dashboard';
        }
    }
}
