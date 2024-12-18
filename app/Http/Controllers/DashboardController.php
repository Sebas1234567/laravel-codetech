<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Code\Models\Blog\Blog_Entradas;
use Code\Models\Cursos\Cursos_Curso;
use Code\Models\Tienda\Tienda_Producto;
use Code\Models\Compras;
use Code\Models\Detalle_Compras;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            //Entradas
            $porcentajeDiferenciaEnt = DB::table('blog_entradas')
            ->select(DB::raw('COALESCE(((SELECT COUNT(*) FROM blog_entradas WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE)) -
                (SELECT COUNT(*) FROM blog_entradas WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH))) * 100.0 /
                NULLIF((SELECT COUNT(*) FROM blog_entradas WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH)), 0),
            100) AS porcentaje_diferencia'))
            ->first();
            $registrosPorMesEnt = DB::table('blog_entradas')
            ->select(DB::raw('EXTRACT(YEAR FROM fecha_publicacion) AS año, EXTRACT(MONTH FROM fecha_publicacion) AS mes, COUNT(*) AS total_registros'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM fecha_publicacion), EXTRACT(MONTH FROM fecha_publicacion)'))
            ->orderBy('año')
            ->orderBy('mes')
            ->get();
            $totalRegistrosEnt = DB::table('blog_entradas')->count();

            //Productos
            $porcentajeDiferenciaProd = DB::table('tienda_producto')
            ->select(DB::raw('COALESCE(((SELECT COUNT(*) FROM tienda_producto WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE)) -
                (SELECT COUNT(*) FROM tienda_producto WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH))) * 100.0 /
                NULLIF((SELECT COUNT(*) FROM tienda_producto WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH)), 0),
            100) AS porcentaje_diferencia'))
            ->first();
            $registrosPorMesProd = DB::table('tienda_producto')
            ->select(DB::raw('EXTRACT(YEAR FROM fecha_publicacion) AS año, EXTRACT(MONTH FROM fecha_publicacion) AS mes, COUNT(*) AS total_registros'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM fecha_publicacion), EXTRACT(MONTH FROM fecha_publicacion)'))
            ->orderBy('año')
            ->orderBy('mes')
            ->get();
            $totalRegistrosProd = DB::table('tienda_producto')->count();

            //Cursos
            $porcentajeDiferenciaCur = DB::table('cursos_curso')
            ->select(DB::raw('COALESCE(((SELECT COUNT(*) FROM cursos_curso WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE)) -
                (SELECT COUNT(*) FROM cursos_curso WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH))) * 100.0 /
                NULLIF((SELECT COUNT(*) FROM cursos_curso WHERE EXTRACT(MONTH FROM fecha_publicacion) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH)), 0),
            100) AS porcentaje_diferencia'))
            ->first();
            $registrosPorMesCur = DB::table('cursos_curso')
            ->select(DB::raw('EXTRACT(YEAR FROM fecha_publicacion) AS año, EXTRACT(MONTH FROM fecha_publicacion) AS mes, COUNT(*) AS total_registros'))
            ->groupBy(DB::raw('EXTRACT(YEAR FROM fecha_publicacion), EXTRACT(MONTH FROM fecha_publicacion)'))
            ->orderBy('año')
            ->orderBy('mes')
            ->get();
            $totalRegistrosCur = DB::table('cursos_curso')->count();

            //Usuarios
            $porcentajeDiferenciaUsu = DB::table('users')
            ->select(DB::raw('COALESCE(((SELECT COUNT(*) FROM users WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE) and role="cliente") -
                (SELECT COUNT(*) FROM users WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH) and role="cliente")) * 100.0 /
                NULLIF((SELECT COUNT(*) FROM users WHERE EXTRACT(MONTH FROM created_at) = EXTRACT(MONTH FROM CURRENT_DATE - INTERVAL \'1\' MONTH) and role="cliente"), 0),
            100) AS porcentaje_diferencia'))
            ->first();
            $registrosPorMesUsu = DB::table('users')
            ->select(DB::raw('EXTRACT(YEAR FROM created_at) AS año, EXTRACT(MONTH FROM created_at) AS mes, COUNT(*) AS total_registros'))
            ->where('role','=','cliente')
            ->groupBy(DB::raw('EXTRACT(YEAR FROM created_at), EXTRACT(MONTH FROM created_at)'))
            ->orderBy('año')
            ->orderBy('mes')
            ->get();
            $totalRegistrosUsu = DB::table('users')
            ->where('role', '=', 'cliente')
            ->count();

            //Compras día-producto
            $totalComprasDíaProd = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m-%d') AS dia, SUM(dc.subtotal) AS total"))
                ->whereBetween('compras.fecha_compra', [now()->subDays(15), now()->subDays(1)])
                ->whereNotNull('dc.producto')
                ->groupBy(DB::raw('DATE(compras.fecha_compra)'),'compras.fecha_compra')
                ->orderBy('dia')
                ->get();

            //Compras día-curso
            $totalComprasDíaCur = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m-%d') AS dia, SUM(dc.subtotal) AS total"))
                ->whereBetween('compras.fecha_compra', [now()->subDays(15), now()->subDays(1)])
                ->whereNotNull('dc.curso')
                ->groupBy(DB::raw('DATE(compras.fecha_compra)'),'compras.fecha_compra')
                ->orderBy('dia')
                ->get();

            //Compras mes-producto
            $totalComprasMesProd = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m') AS mes, SUM(dc.subtotal) AS total"))
                ->whereBetween('compras.fecha_compra', [now()->subMonths(8), now()->subMonths(1)])
                ->whereNotNull('dc.producto')
                ->groupBy(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m')"),'compras.fecha_compra')
                ->orderBy('mes')
                ->get();

            //Compras mes-curso
            $totalComprasMesCur = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m') AS mes, SUM(dc.subtotal) AS total"))
                ->whereBetween('compras.fecha_compra', [now()->subMonths(8), now()->subMonths(1)])
                ->whereNotNull('dc.curso')
                ->groupBy(DB::raw("DATE_FORMAT(compras.fecha_compra, '%Y-%m')"),'compras.fecha_compra')
                ->orderBy('mes')
                ->get();

            //Compras año-producto
            $totalComprasAñoProd = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw('YEAR(compras.fecha_compra) AS año, SUM(dc.subtotal) AS total'))
                ->whereBetween(DB::raw('YEAR(compras.fecha_compra)'), [now()->year - 6, now()->year - 1])
                ->whereNotNull('dc.producto')
                ->groupBy(DB::raw('YEAR(compras.fecha_compra)'))
                ->orderBy('año')
                ->get();

            //Compras año-curso
            $totalComprasAñoCur = Compras::join('detalle_compra as dc', 'compras.id', '=', 'dc.compra')
                ->select(DB::raw('YEAR(compras.fecha_compra) AS año, SUM(dc.subtotal) AS total'))
                ->whereBetween(DB::raw('YEAR(compras.fecha_compra)'), [now()->year - 6, now()->year - 1])
                ->whereNotNull('dc.curso')
                ->groupBy(DB::raw('YEAR(compras.fecha_compra)'))
                ->orderBy('año')
                ->get();

            //Productos top
            $ProductosTop = Detalle_Compras::join('tienda_producto as p', 'detalle_compra.producto', '=', 'p.id')
                ->select('p.titulo as producto', DB::raw('SUM(detalle_compra.cantidad) as total'))
                ->groupBy('detalle_compra.producto', 'p.titulo')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            //Cursos top
            $CursosTop = Detalle_Compras::join('cursos_curso as c', 'detalle_compra.curso', '=', 'c.id')
                ->select('c.titulo as curso', DB::raw('SUM(detalle_compra.cantidad) as total'))
                ->groupBy('detalle_compra.curso', 'c.titulo')
                ->orderByDesc('total')
                ->limit(10)
                ->get();

            return view('admin.index',[
                'porcentajeDiferenciaEnt'=>$porcentajeDiferenciaEnt,'registrosPorMesEnt'=>$registrosPorMesEnt,
                'totalRegistrosEnt'=>$totalRegistrosEnt,'porcentajeDiferenciaProd'=>$porcentajeDiferenciaProd,'registrosPorMesProd'=>$registrosPorMesProd,
                'totalRegistrosProd'=>$totalRegistrosProd,'porcentajeDiferenciaCur'=>$porcentajeDiferenciaCur,'registrosPorMesCur'=>$registrosPorMesCur,
                'totalRegistrosCur'=>$totalRegistrosCur,
                'porcentajeDiferenciaUsu'=>$porcentajeDiferenciaUsu,'registrosPorMesUsu'=>$registrosPorMesUsu,
                'totalRegistrosUsu'=>$totalRegistrosUsu,
                'totalComprasDíaProd'=>$totalComprasDíaProd,
                'totalComprasDíaCur'=>$totalComprasDíaCur,
                'totalComprasMesProd'=>$totalComprasMesProd,
                'totalComprasMesCur'=>$totalComprasMesCur,
                'totalComprasAñoProd'=>$totalComprasAñoProd,
                'totalComprasAñoCur'=>$totalComprasAñoCur,
                'ProductosTop' => $ProductosTop,
                'CursosTop' => $CursosTop
            ]);
        }
    }
}
