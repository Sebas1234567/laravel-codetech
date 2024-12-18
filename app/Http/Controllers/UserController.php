<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Code\Models\User;
use Code\Models\Notificaciones;
use Code\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $usuarios=User::select('id','name','email','imagen','estado')
            ->where('role','=','cliente')
            ->get();
            return view('admin.user.index',["usuarios"=>$usuarios]);
        }
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(UserRequest $request)
    {
        $usuario=new User;
        $usuario->name=$request->get('nombre');
        $usuario->email=$request->get('email');
        $usuario->password=Hash::make($request->get('password'));
        $usuario->role='cliente';
        $usuario->imagen='png/avatar.png';
        $usuario->estado='1';
        $usuario->save();
        Notificaciones::create([
            'titulo' => 'Usuario',
            'descripcion' => 'Nuevo usuario registrado.',
            'icono' => 'fa-duotone fa-user-plus',
            'color' => 'text-success',
            'url' => 'admin/usuarios',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/usuarios');

    }

    public function show($id)
    {
        return view('admin.user.show',["usuario"=>User::findOrFail($id)]);
    }

    public function edit($id)
    {   
        $usuario = User::findOrFail($id);
        return view('admin.user.edit',["usuario"=>$usuario]);
    }

    public function update(UserRequest $request,$id)
    {
        $usuario=User::findOrFail($id);
        $usuario->name=$request->get('nombre');
        $usuario->email=$request->get('email');
        $usuario->password=Hash::make($request->get('password'));
        $usuario->role='cliente';
        if ($usuario->imagen){
            $usuario->imagen = $usuario->imagen;
        } else {
            $usuario->imagen='png/avatar.png';
        }
        $usuario->estado=$usuario->estado;
        $usuario->update();
        Notificaciones::create([
            'titulo' => 'Usuario',
            'descripcion' => 'Usuario editado.',
            'icono' => 'fa-duotone fa-user-pen',
            'color' => 'text-info',
            'url' => 'admin/usuarios',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/usuarios');
    }

    public function destroy($id)
    {
        $usuario=User::findOrFail($id);
        $usuario->estado=0;
        $usuario->update();
        Notificaciones::create([
            'titulo' => 'Usuario',
            'descripcion' => 'Usuario eliminado.',
            'icono' => 'fa-duotone fa-user-xmark',
            'color' => 'text-danger',
            'url' => 'admin/usuarios',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
