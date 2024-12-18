<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Code\Models\Cursos\Cursos_Curso;
use Code\Models\Tienda\Tienda_Producto;
use Code\Models\Compras;
use Code\Models\Detalle_Compras;
use Illuminate\Support\Facades\DB;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\ValidationException;
use Code\Http\Controllers\Extras\Reportes;

class ComprasController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $compras=DB::table('compras as c')
            ->select('c.id','c.n_pedido','c.fecha_compra','c.metodo_pago','c.total','u.name')
            ->join('users as u', 'u.id', '=', 'c.usuario')
            ->get();
            return view('admin.compras.index',["compras"=>$compras]);
        }
    }

    public function show($id){
        $compra = DB::table('compras as c')
        ->select('c.id','c.n_pedido','c.fecha_compra','c.metodo_pago','c.total','u.name')
        ->join('users as u', 'u.id', '=', 'c.usuario')
        ->where('c.id', $id)
        ->first();
        $detalle_compra = DB::table('detalle_compra as dc')
        ->select('dc.curso as idc','dc.producto as idp','p.titulo as producto','cu.titulo as curso','dc.cantidad','p.precio as precio_p','cu.precio as precio_c','dc.descuento','dc.subtotal')
        ->leftjoin('tienda_producto as p', 'dc.producto', '=', 'p.id')
        ->leftjoin('cursos_curso as cu', 'dc.curso', '=', 'cu.id')
        ->where('dc.compra', $id)
        ->get();
        $descuento = 0.00;
        $list = '';
        foreach($detalle_compra as $detalle)
        {
            $descuento +=  $detalle->descuento;
            if ($detalle->idp) {
                $list .= $detalle->cantidad.'|'.'P'.$detalle->idp.'|';
            } else {
                $list .= $detalle->cantidad.'|'.'C'.$detalle->idc.'|';
            }
            
        }
        if (str_contains($descuento,'.')) {
            $puntoPosicion = strpos($descuento, '.');
            $caracteresDespuesDelPunto = strlen(substr($descuento, $puntoPosicion + 1));
            $descuento = ($caracteresDespuesDelPunto == 1) ? $descuento.'0' : $descuento ;
        } else {
            $descuento .= '.00';
        }
        
        $textqr = $compra->n_pedido.'|'.$descuento.'|'.$compra->total.'|'.$compra->fecha_compra.'|'.$list;
        $this->generateQr($textqr, $compra->id);
        return view('admin.compras.show',['compra'=>$compra,'detalle'=>$detalle_compra]);
    }

    public function generateQr($text,$id)
    {   
        if (!file_exists(public_path('qrs/'.$id))) {
            mkdir(public_path('qrs/'.$id), 0777);
        } 
        $writer = new PngWriter();
        $qrCode = QrCode::create($text)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(ErrorCorrectionLevel::Low)
            ->setSize(300)
            ->setMargin(10)
            ->setRoundBlockSizeMode(RoundBlockSizeMode::Margin)
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));
        $result = $writer->write($qrCode);
        $result->saveToFile(public_path('qrs/'.$id.'/qrcode.png'));
    }

    public function generatePDF($id)
    {
        $rep = new Reportes();
        $rep->loadReport($id);
    }
}
