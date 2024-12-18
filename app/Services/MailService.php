<?php

namespace Code\Services;

use Webklex\IMAP\Facades\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;

class MailService
{
    public static function GetContsI(){
        $client = Client::account('default');
        $client->connect();
        $folder = $client->getFolderByPath('INBOX');
        $query = $folder->query();
        $query->setFetchOrder("desc");
        $messages = $query->all()->get();
        $INL = 0;
        foreach ($messages  as $message) {
            $flgs = [];
            foreach ($message->getFlags() as $flag){
                array_push($flgs,$flag);
            }
            if (in_array("Seen", $flgs)) {
                $INL = $INL;
            } else {
                $INL += 1;
            }
        }

        return $INL;
    }

    public static function GetContsS(){
        $client = Client::account('default');
        $client->connect();
        $folder = $client->getFolderByPath('[Gmail]/Spam');
        $query = $folder->query();
        $query->setFetchOrder("desc");
        $messages = $query->all()->get();
        $SNL = 0;
        foreach ($messages  as $message) {
            $flgs = [];
            foreach ($message->getFlags() as $flag){
                array_push($flgs,$flag);
            }
            if (in_array("Seen", $flgs)) {
                $SNL = $SNL;
            } else {
                $SNL += 1;
            }
        }

        return $SNL;
    }

    public static function ListNotiMessages() {
        $client = Client::account('default');
        $client->connect();
        $folder = $client->getFolderByPath('INBOX');
        $query = $folder->query();
        $query->setFetchOrder("desc");
        $messages = $query->all()->get();
        $correos = [];
        $vistos = 0;
        foreach ($messages  as $message) {
            //Fecha
            $date = $message->date[0];
            $date->timezone = 'America/Lima';
            $fecha = clone $date;
            $hoy = Carbon::now()->startOfDay();
            $hoy->timezone = 'America/Lima';
            $antes = clone $hoy;
            $antes->subMonth()->subDays(2);
            if ($date->isSameDay($hoy)) {
                $date = 'Hoy, ' . $date->format('g:i A');
            }
            else if ($date->gte($antes) && $date->lte($hoy)) {
                $date = $date->format('j M');
            }
            else {
                $date = $date->format('d/m/y');
            }

            //Asunto
            $asunto = $message->subject->toString();
            if (mb_check_encoding($asunto, 'ASCII') && mb_check_encoding($asunto, 'UTF-8')) {
                $asunto = mb_decode_mimeheader($asunto);
                $asunto = str_replace('_', ' ', $asunto);
            }
            $asunto = mb_substr($asunto, 0, 50);
            //Remitente
            $remitente = $message->from[0]->personal;
            //Cuerpo
            $cuerpo = '';
            if ($message->hasHTMLBody()) {
                $cuerpo = $message->getHTMLBody();
                $html = HtmlDomParser::str_get_html($cuerpo);
                $bodyContent = '';
                if ($html) {
                    foreach ($html->find('body') as $body) {
                        $bodyContent = $body->innertext;
                    }
                    if($bodyContent == ''){
                        $texto = strip_tags($html);
                        $texto = preg_replace('/\s+/', ' ', $texto);
                        $cuerpo = mb_substr($texto, 0, 90);
                    } else {
                        $bodyContent = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $bodyContent);
                        $position = mb_strpos(strip_tags($bodyContent), $asunto);
                        if ($position && $position === 0) {
                            $texto = mb_substr(strip_tags($bodyContent), $position+mb_strlen($asunto));
                            $texto = ltrim($texto);
                            $texto = preg_replace('/\s+/', ' ', $texto);
                            $cuerpo = mb_substr($texto, 0, 90);
                        } else {
                            $texto = ltrim(strip_tags($bodyContent));
                            $texto = preg_replace('/\s+/', ' ', $texto);
                            $cuerpo = mb_substr($texto, 0, 90);
                        }
                    }
                } else {
                    $texto = strip_tags($cuerpo);
                    $texto = preg_replace('/\s+/', ' ', $texto);
                    $cuerpo = mb_substr($texto, 0, 90);
                }
            } else if ($message->hasTextBody()){
                $cuerpo = $message->getTextBody();
                $texto = preg_replace('/\r\n/', ' ', $cuerpo);
                $cuerpo = mb_substr($texto, 0, 90);
            }

            $flgs = [];
            foreach ($message->getFlags() as $flag){
                array_push($flgs,$flag);
            }
            //Seen
            $visto = false;
            if (in_array("Seen", $flgs)) {
                $visto = true;
            } else {
                $vistos += 1;
            }

            //Uid
            $uid = $message->uid;

            if ($visto == false) {
                $correos[] = [
                    'asunto' => $asunto,
                    'remite' => $remitente,
                    'dia' => $date,
                    'fecha' => $fecha,
                    'cuerpo' => $cuerpo,
                    'uid' => $uid,
                ];
            }
        }

        usort($correos, function ($a, $b) {
            $fechaA = Carbon::parse($a['fecha']);
            $fechaB = Carbon::parse($b['fecha']);
            return $fechaB <=> $fechaA;
        });

        return ['correos' => $correos, 'vistos' => $vistos];
    }
}
