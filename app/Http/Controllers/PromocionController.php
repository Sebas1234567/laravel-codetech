<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Code\Models\Promociones;
use Code\Models\Notificaciones;
use Code\Http\Requests\PromocionRequest;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;

class PromocionController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $promociones=Promociones::select('id','titulo','descripcion','fecha_fin','porcentaje','estado')
            ->get();
            return view('admin.promotion.index',["promociones"=>$promociones]);
        }
    }

    public function create()
    {
        return view('admin.promotion.create');
    }

    public function store(PromocionRequest $request)
    {
        $promocion=new Promociones;
        $promocion->titulo=$request->get('titulo');
        $promocion->descripcion=$request->get('descripcion');
        $promocion->fecha_inicio=Carbon::createFromFormat('d/m/Y', $request->get('fechaInicio'))->format('Y-m-d');
        $promocion->fecha_fin=Carbon::createFromFormat('d/m/Y', $request->get('fechaFin'))->format('Y-m-d');
        $promocion->porcentaje=$request->get('porcentaje');

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $promocion->imagen = $nombre;

        $promocion->estado='1';
        $promocion->save();
        Notificaciones::create([
            'titulo' => 'Promoción',
            'descripcion' => 'Nueva promoción registrada.',
            'icono' => 'fa-duotone fa-badge-percent',
            'color' => 'text-success',
            'url' => 'admin/promociones',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/promociones');

    }

    public function show($id)
    {
        return view('admin.promotion.show',["promocion"=>Promociones::findOrFail($id)]);
    }

    public function edit($id)
    {   
        $promocion = Promociones::findOrFail($id);
        return view('admin.promotion.edit',["promocion"=>$promocion]);
    }

    public function update(PromocionRequest $request,$id)
    {
        $promocion=Promociones::findOrFail($id);
        $promocion->titulo=$request->get('titulo');
        $promocion->descripcion=$request->get('descripcion');
        $promocion->fecha_inicio=Carbon::createFromFormat('d/m/Y', $request->get('fechaInicio'))->format('Y-m-d');
        $promocion->fecha_fin=Carbon::createFromFormat('d/m/Y', $request->get('fechaFin'))->format('Y-m-d');
        $promocion->porcentaje=$request->get('porcentaje');
        
        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $promocion->imagen = $nombre;

        $promocion->estado=$promocion->estado;
        $promocion->update();
        Notificaciones::create([
            'titulo' => 'Promoción',
            'descripcion' => 'Promoción editada.',
            'icono' => 'fa-duotone fa-badge-percent',
            'color' => 'text-info',
            'url' => 'admin/promociones',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/promociones');
    }

    public function destroy($id)
    {
        $promocion=Promociones::findOrFail($id);
        $promocion->estado=0;
        $promocion->update();
        Notificaciones::create([
            'titulo' => 'Promoción',
            'descripcion' => 'Promoción eliminada.',
            'icono' => 'fa-duotone fa-badge-percent',
            'color' => 'text-danger',
            'url' => 'admin/promociones',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
