<?php

namespace Code\Http\Controllers\Tienda;

use Illuminate\Http\Request;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Code\Http\Requests\Tienda\TiendaDescuentoRequest;
use Code\Models\Tienda\Tienda_Descuento;
use Code\Models\Tienda\Tienda_Producto;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class TiendaDescuentoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $descuentos=DB::table('tienda_descuento as desc')
            ->select('desc.id', 'desc.codigo', 'desc.cantidad', 'desc.tipo_cant', 'desc.tipo', 'desc.fechaInicio', 'desc.fechaFin', 'desc.estado', 'desc.activo', DB::raw('COUNT(prod.id) as total'), DB::raw('GROUP_CONCAT(prod.titulo ORDER BY prod.titulo) as productos'))
            ->leftJoin('tienda_descuento_producto as tdp', 'tdp.tienda_descuento_id', '=', 'desc.id')
            ->leftJoin('tienda_producto as prod', 'prod.id', '=', 'tdp.tienda_producto_id')
            ->groupBy('desc.id', 'desc.codigo', 'desc.cantidad', 'desc.tipo_cant', 'desc.tipo', 'desc.fechaInicio', 'desc.fechaFin', 'desc.estado', 'desc.activo')
            ->get();
            return view('admin.tienda.descuento.index',["descuentos"=>$descuentos]);
        }
    }

    public function create()
    {
        $productos = Tienda_Producto::where('estado', 1)->pluck("titulo","id");
        return view('admin.tienda.descuento.create',["productos"=>$productos]);
    }

    public function store(TiendaDescuentoRequest $request)
    {
        $descuento=new Tienda_Descuento;
        $descuento->codigo=$request->get('codigo');
        $descuento->cantidad=$request->get('cantidad');
        if ($request->get('tipo_cant')==null) {
            $descuento->tipo_cant='porcentaje';
        } else {
            $descuento->tipo_cant='precio';
        }
        $descuento->tipo=$request->get('tipo');
        $descuento->fechaInicio=Carbon::createFromFormat('d/m/Y', $request->get('fechaInicio'));
        $descuento->fechaFin=Carbon::createFromFormat('d/m/Y', $request->get('fechaFin'));
        $descuento->activo=1;
        $descuento->estado=1;
        $descuento->save();

        if ($request->get('productos')) {
            $descuento->productos()->attach($request->get('productos'));
        }
        Notificaciones::create([
            'titulo' => 'Descuentos',
            'descripcion' => 'Nuevo descuento registrado.',
            'icono' => 'fa-duotone fa-badge-dollar',
            'color' => 'text-success',
            'url' => 'admin/tienda/descuento',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/descuento');
    }

    public function show($id)
    {
        return view('admin.tienda.descuento.show',["descuento"=> Tienda_Descuento::findOrFail($id)]);
    }

    public function edit($id)
    {
        $productos = Tienda_Producto::where('estado', 1)->pluck("titulo","id");
        $descuento = DB::table('tienda_descuento as desc')
        ->select('desc.id', 'desc.codigo', 'desc.cantidad', 'desc.tipo_cant', 'desc.tipo', 'desc.fechaInicio', 'desc.fechaFin', 'desc.estado', 'desc.activo', DB::raw('GROUP_CONCAT(prod.id ORDER BY prod.id) as productos'))
        ->leftJoin('tienda_descuento_producto as tdp', 'tdp.tienda_descuento_id', '=', 'desc.id')
        ->leftJoin('tienda_producto as prod', 'prod.id', '=', 'tdp.tienda_producto_id')
        ->where('desc.id', $id)
        ->groupBy('desc.id', 'desc.codigo', 'desc.cantidad', 'desc.tipo_cant', 'desc.tipo', 'desc.fechaInicio', 'desc.fechaFin', 'desc.estado', 'desc.activo')
        ->first();
        return view('admin.tienda.descuento.edit',["descuento"=>$descuento,"productos"=>$productos]);
    }

    public function update(TiendaDescuentoRequest $request,$id)
    {
        $descuento=Tienda_Descuento::findOrFail($id);
        $descuento->codigo=$request->get('codigo');
        $descuento->cantidad=$request->get('cantidad');
        if ($request->get('tipo_cant')==null) {
            $descuento->tipo_cant='porcentaje';
        } else {
            $descuento->tipo_cant='precio';
        }
        $descuento->tipo=$request->get('tipo');
        $descuento->fechaInicio=Carbon::createFromFormat('d/m/Y', $request->get('fechaInicio'));
        $descuento->fechaFin=Carbon::createFromFormat('d/m/Y', $request->get('fechaFin'));
        $descuento->update();

        $descuento->productos()->sync($request->get('productos'));
        Notificaciones::create([
            'titulo' => 'Descuentos',
            'descripcion' => 'Descuento editado.',
            'icono' => 'fa-duotone fa-badge-dollar',
            'color' => 'text-info',
            'url' => 'admin/tienda/descuento',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/tienda/descuento');
    }

    public function destroy($id)
    {
        $producto=Tienda_Descuento::findOrFail($id);
        $producto->activo=0;
        $producto->estado=0;
        $producto->update();
        Notificaciones::create([
            'titulo' => 'Descuentos',
            'descripcion' => 'Descuento eliminado.',
            'icono' => 'fa-duotone fa-badge-dollar',
            'color' => 'text-danger',
            'url' => 'admin/tienda/descuento',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
