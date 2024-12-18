<?php

namespace Code\Http\Controllers\Extras;

use Illuminate\Support\Facades\DB;
use FPDF;

class Reportes
{
    private function numeroATexto($numero) {
        $unidades = array('cero', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
        $dec = array('','once','doce','trece','catorce','quince');
        $decenas = array('', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
        $centenas = array('', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');
        $milesimas = array('', 'mil', 'dosmil', 'tresmil', 'cuatromil', 'cincomil', 'seismil', 'sietemil', 'ochomil', 'nuevemil');
    
        if ($numero < 10) {
            return $unidades[$numero];
        } elseif ($numero > 10 and $numero < 16) {
            return $dec[$numero - 10];
        } elseif ($numero < 20 and $numero > 15) {
            return 'dieci' . $unidades[$numero - 10];
        } elseif ($numero < 100) {
            return $decenas[floor($numero / 10)] . (($numero % 10 !== 0) ? ' y ' . $unidades[$numero % 10] : '');
        } elseif ($numero < 1000) {
            return $centenas[floor($numero / 100)] . (($numero % 100 !== 0) ? ' ' . $this->numeroATexto($numero % 100) : '');
        } elseif ($numero < 10000) {
            return $milesimas[floor($numero / 1000)] . (($numero % 1000 !== 0) ? ' ' . $this->numeroATexto($numero % 1000) : '');
        } else {
            return 'Número fuera de rango';
        }
    }

    public function loadReport($id)
    {
        //Consultas
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
        //PDF
        $pdf = new FPDF();
        $pdf->AliasNbPages();
        $pdf->AddFont('Poppins_Regular','','Poppins.php');
        $pdf->AddFont('Poppins_Thin','','Poppins-Thin.php');
        $pdf->AddFont('Poppins_SemiBold','','Poppins-SemiBold.php');
        $pdf->AddFont('Poppins_Medium','','Poppins-Medium.php');
        $pdf->AddFont('Poppins_Light','','Poppins-Light.php');
        $pdf->AddFont('Poppins_ExtraLight','','Poppins-ExtraLight.php');
        $pdf->AddFont('Poppins_ExtraBold','','Poppins-ExtraBold.php');
        $pdf->AddFont('Poppins_Bold','','Poppins-Bold.php');
        $pdf->AddFont('Poppins_Black','','Poppins-Black.php');
        $pdf->AddPage();
        $pdf->Image(public_path('admin/assets/img/logo-ai.png'),10,11.25,95,37.5,'PNG');
        $pdf->SetDrawColor(168,168,168);
        $pdf->SetLineWidth(0.75);
        $pdf->SetFillColor(222,222,222);
        $pdf->RoundedRect(110,10,90,40,3,'DF');
        $pdf->SetXY(110,15);
        $pdf->SetFont('Poppins_Bold','',16);
        $pdf->MultiCell(90,10,'BOLETA DE VENTA ELECTRONICA',0,'C');
        $pdf->SetXY(110,35);
        $pdf->SetFont('Poppins_Bold','',15);
        $pdf->MultiCell(90,10,$compra->n_pedido,0,'C');
        $pdf->SetXY(10,63);
        $pdf->SetFont('Poppins_Bold','',14);
        $pdf->Cell(95,10,'CodeTechEvolution',0);
        $pdf->SetXY(10,70);
        $pdf->SetFont('Poppins_Regular','',11);
        $pdf->Cell(95,10,'Correo: code.tech.evolution@gmail.com',0);
        $pdf->RoundedRect(110,55,90,30,3,'D');
        $pdf->SetXY(113,62);
        $pdf->SetFont('Poppins_Bold','',12);
        $pdf->Cell(90,10,'Fecha emision   :',0);
        $pdf->SetXY(153,62);
        $pdf->SetFont('Poppins_Regular','',11);
        $pdf->Cell(90,10,$compra->fecha_compra,0);
        $pdf->SetXY(113,69);
        $pdf->SetFont('Poppins_Bold','',12);
        $pdf->Cell(90,10,'Cliente                     :',0);
        $pdf->SetXY(153,69);
        $pdf->SetFont('Poppins_Regular','',11);
        $pdf->Cell(90,10,$compra->name,0);

        $pdf->SetXY(10,94);
        $pdf->SetFont('Poppins_Bold','',11);
        $pdf->Cell(8,8,'#','B',0,'C');
        $pdf->SetXY(18,94);
        $pdf->Cell(92,8,'Descripcion','B',0,'C');
        $pdf->SetXY(110,94);
        $pdf->Cell(30,8,'Cantidad','B',0,'C');
        $pdf->SetXY(140,94);
        $pdf->Cell(30,8,'Descuento','B',0,'C');
        $pdf->SetXY(170,94);
        $pdf->Cell(30,8,'Total','B',0,'C');
        $pdf->SetFont('Poppins_Regular','',11);
        $medida1 = 0;
        $medida2 = 0;
        $descuento = 0;
        $subtotal = 0;
        $count = 0;
        foreach ($detalle_compra as $key => $value) {
            $count++;
            $medida1 = 102 + 10*$key;
            $medida2 = 102.5 + 10*$key;
            $descuento += $value->descuento;
            if ($key % 2 == 0){
                $pdf->Rect(10.5,$medida2,189,9.5,'F');
            }
            $pdf->SetXY(10,$medida1);
            $pdf->Cell(8,10,$key+1,'B',0,'C');
            $pdf->SetXY(18,$medida1);
            if ($value->producto) {
                if (strlen($value->producto)>44) {
                    $pdf->MultiCell(92,5,$value->producto,'B','L');
                } else {
                    $pdf->MultiCell(92,10,$value->producto,'B','L');
                }
                $subtotal += $value->precio_p;
            } else {
                if (strlen($value->curso)>44) {
                    $pdf->MultiCell(92,5,$value->curso,'B','L');
                } else {
                    $pdf->MultiCell(92,10,$value->curso,'B','L');
                }
                $subtotal += $value->precio_c;
            }
            $pdf->SetXY(110,$medida1);
            $pdf->Cell(30,10,$value->cantidad.'.00','B',0,'C');
            $pdf->SetXY(140,$medida1);
            $pdf->Cell(30,10,$value->descuento,'B',0,'C');
            $pdf->SetXY(170,$medida1);
            $pdf->Cell(30,10,$value->subtotal,'B',0,'C');
        }

        if (str_contains($descuento,'.')) {
            $puntoPosicion = strpos($descuento, '.');
            $caracteresDespuesDelPunto = strlen(substr($descuento, $puntoPosicion + 1));
            $descuento = ($caracteresDespuesDelPunto == 1) ? $descuento.'0' : $descuento ;
        } else {
            $descuento .= '.00';
        }
        if (str_contains($subtotal,'.')) {
            $puntoPosicion = strpos($subtotal, '.');
            $caracteresDespuesDelPunto = strlen(substr($subtotal, $puntoPosicion + 1));
            $subtotal = ($caracteresDespuesDelPunto == 1) ? $subtotal.'0' : $subtotal ;
        } else {
            $subtotal .= '.00';
        }

        $pdf->SetFont('Poppins_Regular','',12);
        $pdf->SetXY(125,$medida1+12);
        $pdf->Cell(40,10,'SUB TOTAL',0,0,'R');
        $pdf->SetXY(125,$medida1+20);
        $pdf->Cell(40,10,'DESCUENTO',0,0,'R');
        $pdf->SetXY(125,$medida1+28);
        $pdf->SetFont('Poppins_Bold','',12);
        $pdf->Cell(40,10,'TOTAL',0,0,'R');
        $pdf->SetXY(165,$medida1+12);
        $pdf->SetFont('Poppins_Regular','',12);
        $pdf->Cell(10,10,'S/.',0,0,'C');
        $pdf->SetXY(165,$medida1+20);
        $pdf->Cell(10,10,'S/.',0,0,'C');
        $pdf->SetXY(165,$medida1+28);
        $pdf->SetFont('Poppins_Bold','',12);
        $pdf->Cell(10,10,'S/.',0,0,'C');
        $pdf->SetXY(180,$medida1+12);
        $pdf->SetFont('Poppins_Regular','',12);
        $pdf->Cell(18,10,$subtotal,0,0,'R');
        $pdf->SetXY(180,$medida1+20);
        $pdf->Cell(18,10,$descuento,0,0,'R');
        $pdf->SetXY(180,$medida1+28);
        $pdf->SetFont('Poppins_Bold','',12);
        $pdf->Cell(18,10,$compra->total,0,0,'R');
        $pdf->RoundedRect(10,93,190,$count*10+38,3,'D');

        $pdf->RoundedRect(10,98+($count*10+38),190,40,3,'D');
        $pdf->SetXY(12,99+($count*10+38));
        $pdf->SetFont('Poppins_Bold','',10);
        $pdf->Cell(20,10,'IMPORTE EN LETRAS:',0,0,'L');
        $pdf->SetXY(50,99+($count*10+38));
        $pdf->SetFont('Poppins_Regular','',10);
        $numero = explode('.',$compra->total);
        $pdf->Cell(20,10,strtoupper($this->numeroATexto($numero[0])).' CON '.$numero[1].'/100 SOLES',0,0,'L');
        $pdf->Image(public_path('qrs/'.$id.'/qrcode.png'),160,99+($count*10+38),38,38,'PNG');

        $pdf->RoundedRect(10,143+($count*10+38),190,20,3,'D');
        $pdf->SetXY(12,144+($count*10+38));
        $pdf->SetFont('Poppins_Bold','',10);
        $pdf->Cell(20,10,'OBSERVACIONES:',0,0,'L');
        $pdf->SetXY(45,146+($count*10+38));
        $pdf->SetFont('Poppins_Regular','',10);
        $pdf->MultiCell(150,6,'Cualquier duda y/o consulta sobre alguno de los productos, contactame a code.tech.evolution@gmail.com',0,'L');

        $pdf->SetAutoPageBreak(true,0.5);
        $pdf->SetXY(10,285);
        $pdf->SetFont('Poppins_Regular','',10);
        $pdf->Write(10, 'https://codetech.000.com', 'https://codetech.000.com');
        $pdf->SetXY(200,285);
        $pdf->Cell(10, 10, $pdf->PageNo().'/{nb}', 0, 0, 'R');

        $pdf->Output('D','Boleta-'.$compra->n_pedido.'.pdf',true);
    }
}
?>