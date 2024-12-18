<?php

namespace Code\Http\Controllers\Tienda;

use Illuminate\Http\Request;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Code\Http\Requests\Tienda\TiendaProductoRequest;
use Code\Models\Tienda\Tienda_Producto;
use Code\Models\Tienda\Tienda_Categoria;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class TiendaProductoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $productos=DB::table('tienda_producto as prod')
            ->select('prod.id', 'prod.titulo', 'prod.imagen', 'prod.fecha_publicacion', 'prod.precio', 'prod.archivo', 'prod.sku', 'prod.galeria_imagenes', 'prod.publicado', 'prod.estado', DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'))
            ->join('tienda_producto_categoria as tpc', 'tpc.tienda_producto_id', '=', 'prod.id')
            ->join('tienda_categoria as cat', 'cat.id', '=', 'tpc.tienda_categoria_id')
            ->groupBy('prod.id','prod.titulo','prod.imagen','prod.fecha_publicacion','prod.precio','prod.archivo','prod.sku','prod.galeria_imagenes','prod.publicado','prod.estado')
            ->paginate(6);
            return view('admin.tienda.productos.index',["productos"=>$productos]);
        }
    }

    public function create()
    {
        $categorias = Tienda_Categoria::whereNotNull('padre_id')->pluck("nombre","id");
        return view('admin.tienda.productos.create',["categorias"=>$categorias]);
    }

    public function store(TiendaProductoRequest $request)
    {
        $producto=new Tienda_Producto;
        $producto->sku=$request->get('sku');
        $producto->titulo=$request->get('titulo');
        $producto->descripcion=$request->get('descripcion');
        $producto->contenido=$request->get('contenido');
        $producto->fecha_publicacion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion'));
        $producto->precio=$request->get('precio');
        $producto->galeria_imagenes = $request->get('galeria');
        $producto->demo = $request->get('demo');
        $producto->estado='1';

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $producto->imagen = $nombre;

        $archivo = $request->file('archivo');
        $carpeta = 'files/'.$archivo->getClientOriginalExtension().'/';
        $archivo->storeAs($carpeta, $archivo->getClientOriginalName(), 'public');
        $nombre = $archivo->getClientOriginalExtension().'/'.$archivo->getClientOriginalName();
        $producto->archivo = $nombre;

        $fechaActual = Carbon::now();
        if ($producto->fecha_publicacion->isToday()) {
            $producto->publicado = '1';
        } else {
            $producto->publicado = '0';
        }

        $producto->save();
        $producto->categorias()->attach($request->get('categoria'));
        Notificaciones::create([
            'titulo' => 'Producto',
            'descripcion' => 'Nuevo producto registrado.',
            'icono' => 'fa-duotone fa-basket-shopping',
            'color' => 'text-success',
            'url' => 'admin/tienda/productos',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/productos');
    }

    public function show($id)
    {
        return view('admin.tienda.productos.show',["producto"=> Tienda_Producto::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categorias = Tienda_Categoria::whereNotNull('padre_id')->pluck("nombre","id");
        $producto = DB::table('tienda_producto as prod')
        ->select('prod.id', 'prod.titulo', 'prod.fecha_publicacion', 'prod.precio', 'prod.sku', 'prod.demo', 'prod.descripcion', 'prod.contenido', 'prod.publicado', 'prod.estado', DB::raw('GROUP_CONCAT(cat.id ORDER BY cat.id) as categorias'))
        ->join('tienda_producto_categoria as tpc', 'tpc.tienda_producto_id', '=', 'prod.id')
        ->join('tienda_categoria as cat', 'cat.id', '=', 'tpc.tienda_categoria_id')
        ->where('prod.id', $id)
        ->groupBy('prod.id','prod.titulo','prod.fecha_publicacion','prod.precio','prod.sku','prod.demo','prod.descripcion','prod.contenido','prod.publicado','prod.estado')
        ->first();
        return view('admin.tienda.productos.edit',["producto"=>$producto,"categorias"=>$categorias]);
    }

    public function update(TiendaProductoRequest $request,$id)
    {
        $producto=Tienda_Producto::findOrFail($id);
        $producto->sku=$request->get('sku');
        $producto->titulo=$request->get('titulo');
        $producto->descripcion=$request->get('descripcion');
        $producto->contenido=$request->get('contenido');
        $producto->fecha_publicacion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion'));
        $producto->precio=$request->get('precio');
        $producto->galeria_imagenes = $request->get('galeria');
        $producto->demo = $request->get('demo');

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $producto->imagen = $nombre;

        $archivo = $request->file('archivo');
        $carpeta = 'files/'.$archivo->getClientOriginalExtension().'/';
        $archivo->storeAs($carpeta, $archivo->getClientOriginalName(), 'public');
        $nombre = $archivo->getClientOriginalExtension().'/'.$archivo->getClientOriginalName();
        $producto->archivo = $nombre;

        $fechaActual = Carbon::now();
        if ($producto->fecha_publicacion->isToday()) {
            $producto->publicado = '1';
        } else {
            $producto->publicado = '0';
        }

        $producto->update();
        $producto->categorias()->sync($request->get('categoria'));
        Notificaciones::create([
            'titulo' => 'Producto',
            'descripcion' => 'Producto editado.',
            'icono' => 'fa-duotone fa-basket-shopping',
            'color' => 'text-info',
            'url' => 'admin/tienda/productos',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/productos');
    }

    public function destroy($id)
    {
        $producto=Tienda_Producto::findOrFail($id);
        $producto->estado=0;
        $producto->update();
        Notificaciones::create([
            'titulo' => 'Producto',
            'descripcion' => 'Producto eliminado.',
            'icono' => 'fa-duotone fa-basket-shopping',
            'color' => 'text-danger',
            'url' => 'admin/tienda/productos',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
