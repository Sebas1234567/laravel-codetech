<?php

namespace Code\Services;

use Code\Models\Notificaciones;

class NotiService
{
    public static function showNotis(){
        $notis=Notificaciones::where('visto','=',0)->get();
        $totalNotis = Notificaciones::where('visto', '=', 0)->count();
        $toast=Notificaciones::where('toast','=',1)->get();
        return ['notis' => $notis, 'totalNotis' => $totalNotis,'toast'=>$toast];
    }
}
