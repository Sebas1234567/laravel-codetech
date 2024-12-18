<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Redirect;

class NotiController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $notis=Notificaciones::select('id','titulo','descripcion','icono','color','visto','toast')
            ->get();
            return view('admin.notis.index',["notis"=>$notis]);
        }
    }

    public function seenNoti(Request $request)
    {
        $ruta = $request->get('url');
        $noti = $request->get('id');
        $notificacion = Notificaciones::findOrFail($noti);
        $notificacion->visto=1;
        $notificacion->update();
        return Redirect::to($ruta);
    }

    public function seenToast(Request $request)
    {
        $noti = $request->get('id');
        $notificacion = Notificaciones::findOrFail($noti);
        $notificacion->toast=0;
        $notificacion->update();
        return response()->json(['success' => true]);
    }
}
