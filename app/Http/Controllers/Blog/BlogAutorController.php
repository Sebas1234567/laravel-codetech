<?php

namespace Code\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Code\Http\Requests\Blog\BlogAutorRequest;
use Code\Models\Blog\Blog_Autor;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;

class BlogAutorController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $autores=Blog_Autor::select('id','nombre','descripcion','estado')
            ->get();
            return view('admin.blog.autor.index',["autores"=>$autores]);
        }
    }

    public function create()
    {
        return view('admin.blog.autor.create');
    }

    public function store(BlogAutorRequest $request)
    {
        $autor=new Blog_Autor;
        $autor->nombre=$request->get('nombre');
        $autor->descripcion=$request->get('descripcion');
        $autor->estado='1';
        $autor->save();
        Notificaciones::create([
            'titulo' => 'Autor',
            'descripcion' => 'Nuevo autor registrado.',
            'icono' => 'fa-duotone fa-user-graduate',
            'color' => 'text-success',
            'url' => 'admin/blog/autor',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/autor');

    }

    public function show($id)
    {
        return view('admin.blog.autor.show',["autor"=>Blog_Autor::findOrFail($id)]);
    }

    public function edit($id)
    {
        $autor = Blog_Autor::findOrFail($id);
        return view('admin.blog.autor.edit',["autor"=>$autor]);
    }

    public function update(BlogAutorRequest $request,$id)
    {
        $autor=Blog_Autor::findOrFail($id);
        $autor->nombre=$request->get('nombre');
        $autor->descripcion=$request->get('descripcion');
        $autor->update();
        Notificaciones::create([
            'titulo' => 'Autor',
            'descripcion' => 'Autor editado.',
            'icono' => 'fa-duotone fa-user-graduate',
            'color' => 'text-info',
            'url' => 'admin/blog/autor',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/autor');
    }

    public function destroy($id)
    {
        $autor=Blog_Autor::findOrFail($id);
        $autor->estado=0;
        $autor->update();
        Notificaciones::create([
            'titulo' => 'Autor',
            'descripcion' => 'Autor eliminado.',
            'icono' => 'fa-duotone fa-user-graduate',
            'color' => 'text-danger',
            'url' => 'admin/blog/autor',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
