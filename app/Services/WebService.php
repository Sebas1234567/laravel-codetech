<?php

namespace Code\Services;

use Code\Models\Blog\Blog_Categoria;
use DB;
use Carbon\Carbon;

class WebService
{
    public static function showCategories(){
        $cate=Blog_Categoria::where('padre_id','=',null)->get();
        return ['cate' => $cate];
    }

    public static function showPromotions(){
        $hoy = Carbon::now()->toDateString();
        $promocion=DB::table('promocion as prom')
            ->select('prom.titulo', 'prom.fecha_fin')
            ->whereDate('prom.fecha_inicio', '<=', $hoy)
            ->where('prom.estado','=','1')
            ->orderBy('prom.fecha_inicio','desc')
            ->limit(1)
            ->get();
        return ['promo' => $promocion];
    }
}