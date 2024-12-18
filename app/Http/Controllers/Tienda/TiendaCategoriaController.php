<?php

namespace Code\Http\Controllers\Tienda;

use Illuminate\Http\Request;
use Code\Http\Requests\Tienda\TiendaCategoriaRequest;
use Code\Models\Tienda\Tienda_Categoria;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class TiendaCategoriaController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $categorias=Tienda_Categoria::select('tienda_categoria.id','tienda_categoria.nombre','tienda_categoria.descripcion','tienda_categoria.estado','tg2.nombre as padre')
            ->leftjoin('tienda_categoria as tg2','tienda_categoria.padre_id','=','tg2.id')
            ->get();
            return view('admin.tienda.categoria.index',["categorias"=>$categorias]);
        }
    }

    public function create()
    {
        $categoriasPadre = Tienda_Categoria::whereNull('padre_id')->get();
        return view('admin.tienda.categoria.create',["categoriasPadre"=>$categoriasPadre]);
    }

    public function store(TiendaCategoriaRequest $request)
    {
        $categoria=new Tienda_Categoria;
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
            'url' => 'admin/tienda/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/categoria');

    }

    public function show($id)
    {
        return view('admin.tienda.categoria.show',["categoria"=>Tienda_Categoria::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categoriasPadre = Tienda_Categoria::whereNull('padre_id')->get();
        $categoria = Tienda_Categoria::findOrFail($id);
        return view('admin.tienda.categoria.edit',["categoria"=>$categoria,"categoriasPadre"=>$categoriasPadre]);
    }

    public function update(TiendaCategoriaRequest $request,$id)
    {
        $categoria=Tienda_Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        if ($request->get('padre_id') != 0) {
            $categoria->padre_id=$request->get('padre_id');
        }
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoria',
            'descripcion' => 'Categoria editada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-info',
            'url' => 'admin/tienda/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/categoria');
    }

    public function destroy($id)
    {
        $categoria=Tienda_Categoria::findOrFail($id);
        $categoria->estado=0;
        $categoria->update();
        Notificaciones::create([
            'titulo' => 'Categoria',
            'descripcion' => 'Categoria eliminada.',
            'icono' => 'fa-duotone fa-tags',
            'color' => 'text-danger',
            'url' => 'admin/tienda/categoria',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
