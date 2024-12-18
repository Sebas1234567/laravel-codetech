<?php

namespace Code\Http\Controllers\Cursos;

use Illuminate\Http\Request;
use Code\Http\Requests\Cursos\CursosCategoriaRequest;
use Code\Models\Cursos\Cursos_Categoria;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class CursosCategoriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $categorias=Cursos_Categoria::select('cursos_categoria.id','cursos_categoria.nombre','cursos_categoria.descripcion','cursos_categoria.estado')
            ->get();
            return view('admin.cursos.categoria.index',["categorias"=>$categorias]);
        }
    }

    public function create()
    {
        return view('admin.cursos.categoria.create');
    }

    public function store(CursosCategoriaRequest $request)
    {
        $categoria=new Cursos_Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->estado='1';
        $categoria->save();
        Notificaciones::create([
            'titulo' => 'Categoría',
            'descripcion' => 'Nueva categoria registrada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-success',
            'url' => 'admin/cursos/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/categoria');

    }

    public function show($id)
    {
        return view('admin.cursos.categoria.show',["categoria"=>Cursos_Categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categoria = Cursos_Categoria::findOrFail($id);
        return view('admin.cursos.categoria.edit',["categoria"=>$categoria]);
    }

    public function update(CursosCategoriaRequest $request,$id)
    {
        $categoria=Cursos_Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoría',
            'descripcion' => 'Categoria editada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-info',
            'url' => 'admin/cursos/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/categoria');
    }

    public function destroy($id)
    {
        $categoria=Cursos_Categoria::findOrFail($id);
        $categoria->estado=0;
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoría',
            'descripcion' => 'Categoria eliminada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-danger',
            'url' => 'admin/cursos/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
