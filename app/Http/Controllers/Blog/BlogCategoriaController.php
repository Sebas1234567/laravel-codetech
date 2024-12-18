<?php

namespace Code\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Code\Http\Requests\Blog\BlogCategoriaRequest;
use Code\Models\Blog\Blog_Categoria;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;

class BlogCategoriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $categorias=Blog_Categoria::select('blog_categoria.id','blog_categoria.nombre','blog_categoria.descripcion','blog_categoria.estado','bg2.nombre as padre')
            ->leftjoin('blog_categoria as bg2','blog_categoria.padre_id','=','bg2.id')
            ->get();
            return view('admin.blog.categoria.index',["categorias"=>$categorias]);
        }
    }

    public function create()
    {
        $categoriasPadre = Blog_Categoria::whereNull('padre_id')->get();
        return view('admin.blog.categoria.create',["categoriasPadre"=>$categoriasPadre]);
    }

    public function store(BlogCategoriaRequest $request)
    {
        $categoria=new Blog_Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        if ($request->get('padre_id')) {
            $categoria->padre_id=$request->get('padre_id');
        }
        $categoria->estado='1';
        $categoria->save();
        Notificaciones::create([
            'titulo' => 'Categoria',
            'descripcion' => 'Nueva categoria registrada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-success',
            'url' => 'admin/blog/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/categoria');

    }

    public function show($id)
    {
        return view('admin.blog.categoria.show',["categoria"=>Blog_Categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categoriasPadre = Blog_Categoria::whereNull('padre_id')->get();
        $categoria = Blog_Categoria::findOrFail($id);
        return view('admin.blog.categoria.edit',["categoria"=>$categoria,"categoriasPadre"=>$categoriasPadre]);
    }

    public function update(BlogCategoriaRequest $request,$id)
    {
        $categoria=Blog_Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        if ($request->get('padre_id') != 0) {
            $categoria->padre_id=$request->get('padre_id');
        }
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoria',
            'descripcion' => 'Categoria actualizada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-info',
            'url' => 'admin/blog/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/categoria');
    }

    public function destroy($id)
    {
        $categoria=Blog_Categoria::findOrFail($id);
        $categoria->estado=0;
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoria',
            'descripcion' => 'Categoria eliminada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-danger',
            'url' => 'admin/blog/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
