<?php

namespace Code\Http\Controllers\Gmail;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Sunra\PhpSimple\HtmlDomParser;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use DOMDocument;
use Code\Http\Controllers\Controller;

class GmailFunctions extends Controller
{
    public static function ListAllMessages($client, $folderL) {
        if ($folderL == 'INBOX') {
            $folder = $client->getFolderByPath($folderL);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folderL);
        }
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
            //Remitente
            $remitente = $message->from->toString();
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
                        $cuerpo = mb_substr($texto, 0, 330);
                    } else {
                        $bodyContent = preg_replace('/<style[^>]*>.*?<\/style>/s', '', $bodyContent);
                        $position = mb_strpos(strip_tags($bodyContent), $asunto);
                        if ($position && $position === 0) {
                            $texto = mb_substr(strip_tags($bodyContent), $position+mb_strlen($asunto));
                            $texto = ltrim($texto);
                            $texto = preg_replace('/\s+/', ' ', $texto);
                            $cuerpo = mb_substr($texto, 0, 330);
                        } else {
                            $texto = ltrim(strip_tags($bodyContent));
                            $texto = preg_replace('/\s+/', ' ', $texto);
                            $cuerpo = mb_substr($texto, 0, 330);
                        }
                    }
                } else {
                    $texto = strip_tags($cuerpo);
                    $texto = preg_replace('/\s+/', ' ', $texto);
                    $cuerpo = mb_substr($texto, 0, 330);
                }
            } else if ($message->hasTextBody()){
                $cuerpo = $message->getTextBody();
                $texto = preg_replace('/\r\n/', ' ', $cuerpo);
                $cuerpo = mb_substr($texto, 0, 330);
            }

            // Attatchments
            $adjuntos = false;
            if($message->hasAttachments()){
                $adjuntos = true;
            }

            $htmlBody = $message->getHTMLBody();
            if (strpos($htmlBody, 'drive.google.com') !== false) {
                $adjuntos = true;
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

            //Favorite
            $favorito = false;
            if (in_array("Flagged", $flgs)) {
                $favorito = true;
            }

            //Uid
            $uid = $message->uid;

            $correos[] = [
                'asunto' => $asunto,
                'remite' => $remitente,
                'dia' => $date,
                'fecha' => $fecha,
                'cuerpo' => $cuerpo,
                'adjuntos' => $adjuntos,
                'visto' => $visto,
                'favorito' => $favorito,
                'uid' => $uid,
            ];
        }

        usort($correos, function ($a, $b) {
            $fechaA = Carbon::parse($a['fecha']);
            $fechaB = Carbon::parse($b['fecha']);
            return $fechaB <=> $fechaA;
        });

        return ['correos' => $correos, 'vistos' => $vistos];
    }

    public static function GetMessage($client, $folderL, $uid){
        if ($folderL == 'INBOX') {
            $folder = $client->getFolderByPath($folderL);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folderL);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $uid);
        $correo = [];
        //Fecha
        $date = $message->date[0];
        $date->timezone = 'America/Lima';
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
        //Remitente
        $remitenteM = $message->from[0]->mail;
        $remitenteN = $message->from[0]->personal;
        $reply = $remitenteM;
        if ($message->reply_to->toString()) {
            $reply = $message->reply_to->toString();
        }
        $cc = '';
        $bcc = '';
        if ($message->cc->toString()) {
            $cc = $message->cc->toString();
        }
        if ($message->bcc->toString()) {
            $bcc = $message->bcc->toString();
        }
        $to = $message->to->toString();
        //Cuerpo
        $cuerpo = '';
        if ($message->hasHTMLBody()) {
            $cuerpo = $message->getHTMLBody();
        } else if ($message->hasTextBody()){
            $cuerpo = $message->getTextBody();
        }

        // Attatchments
        $adjuntos = false;
        $files = [];
        $iconos = [
            'pdf' => 'fa-duotone fa-file-pdf',
            'doc' => 'fa-duotone fa-file-word',
            'docx' => 'fa-duotone fa-file-word',
            'xls' => 'fa-duotone fa-file-excel',
            'csv' => 'fa-duotone fa-file-excel',
            'ppt' => 'fa-duotone fa-file-powerpoint',
            'pptx' => 'fa-duotone fa-file-powerpoint',
            'xlsx' => 'fa-duotone fa-file-excel',
            'xlsm' => 'fa-duotone fa-file-excel',
            'zip' => 'fa-duotone fa-file-zipper',
            'rar' => 'fa-duotone fa-file-zipper',
            'txt' => 'fa-duotone fa-file-lines',
            'default' => 'fa-duotone fa-file',
            'css' => 'fa-duotone fa-file-code',
            'html' => 'fa-duotone fa-file-code',
            'php' => 'fa-duotone fa-file-code',
            'js' => 'fa-duotone fa-file-code',
            'cs' => 'fa-duotone fa-file-code',
            'py' => 'fa-duotone fa-file-code',
            'sql' => 'fa-duotone fa-file-code',
            'mwb' => 'fa-duotone fa-file-code',
            'png' => 'fa-duotone fa-file-image',
            'jpg' => 'fa-duotone fa-file-image',
            'jpeg' => 'fa-duotone fa-file-image',
            'webp' => 'fa-duotone fa-file-image',
            'gif' => 'fa-duotone fa-file-image',
            'mp4' => 'fa-duotone fa-file-video',
            'mov' => 'fa-duotone fa-file-video',
            'mkv' => 'fa-duotone fa-file-video',
            'avi' => 'fa-duotone fa-file-video',
            'mpeg' => 'fa-duotone fa-file-video',
            'mp3' => 'fa-duotone fa-file-audio',
            'wav' => 'fa-duotone fa-file-audio',
        ];
        $colores = [
            'pdf' => '#AC1208',
            'doc' => '#184597',
            'docx' => '#184597',
            'xls' => '#1F613D',
            'csv' => '#1F613D',
            'xlsm' => '#1F613D',
            'ppt' => '#D65837',
            'pptx' => '#D65837',
            'xlsx' => '#1F613D',
            'zip' => '#93172B',
            'rar' => '#93172B',
            'txt' => '#282828',
            'default' => '#707070',
            'css' => '#0899DD',
            'html' => '#F16A30',
            'php' => '#6A3FE5',
            'js' => '#FFD940',
            'cs' => '#6C287E',
            'py' => '#366D9A',
            'sql' => '#81BC08',
            'mwb' => '#81BC08',
            'png' => '#16C79E',
            'jpg' => '#16C79E',
            'jpeg' => '#16C79E',
            'webp' => '#16C79E',
            'gif' => '#16C79E',
            'mp4' => '#88C5CC',
            'mov' => '#88C5CC',
            'mkv' => '#88C5CC',
            'avi' => '#88C5CC',
            'mpeg' => '#88C5CC',
            'mp3' => '#7B489C',
            'wav' => '#7B489C',
        ];
        if($message->hasAttachments()){
            $adjuntos = true;
            $attachments = $message->getAttachments();
            foreach ($attachments as $attch){
                $filename = $attch->getName();
                $extension = explode('.',$filename)[1];
                $storagePath = Storage::path('/public/mail_files'. '/' . $extension);
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                $attch->save($path = $storagePath);
                if (array_key_exists($extension, $iconos)) {
                    $icono = $iconos[$extension];
                } else {
                    $icono = $iconos['default'];
                }

                if (array_key_exists($extension, $colores)) {
                    $color = $colores[$extension];
                } else {
                    $color = $colores['default'];
                }

                $fileSize = filesize($storagePath . '/' . $filename);
                $tamaño = $fileSize / 1000;
                $unidad = 'KB';

                if ($tamaño >= 1024) {
                    $tamaño /= 1024;
                    $unidad = 'MB';
                }

                if ($tamaño >= 1024) {
                    $tamaño /= 1024;
                    $unidad = 'GB';
                }

                $fileSize = number_format($tamaño, 2) . ' ' . $unidad;
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $storagePath . '/' . $filename);
                finfo_close($finfo);
                
                $file = [
                    'name' => $filename,
                    'url' => '/storage/mail_files/' .$extension. '/' . $filename,
                    'ubi' => '/mail_files'.'/'.$extension. '/' . $filename,
                    'icon' => $icono,
                    'color' => $color,
                    'size' => $fileSize,
                    'mime' => $mime,
                ];
                array_push($files, $file);
            }
        }

        $htmlBody = $message->getHTMLBody();
        if (strpos($htmlBody, 'drive.google.com') !== false) {
            $adjuntos = true;
            $doc = new DOMDocument();
            $doc->loadHTML($htmlBody);
            $enlacesDrive = [];
            $enlaces = $doc->getElementsByTagName('a');
            foreach ($enlaces as $enlace) {
                $url = $enlace->getAttribute('href');
                if (strpos($url, 'drive.google.com') !== false) {
                    $enlacesDrive[] = $url;
                }
            }

            foreach ($enlacesDrive as $link) {
                $viewPosition = strpos($link, '/view');
                $fileDPosition = strpos($link, 'file/d/');
                $idF = substr($link, $fileDPosition + strlen('file/d/'), $viewPosition - ($fileDPosition + strlen('file/d/')));
                $response = Http::get($link);
                $html = $response->body();
                $dom = HtmlDomParser::str_get_html($html);
                $metaTag = $dom->find('meta[property="og:title"]');
                if ($metaTag) {
                    $filename = $metaTag[0]->content;
                }
                $extension = explode('.', $filename, 2)[1];
                ini_set('memory_limit', '1024M');
                set_time_limit(240);
                $fileContent = file_get_contents('https://drive.usercontent.google.com/download?id='.$idF.'&export=download&authuser=0&confirm=t&uuid=261d88a4-a998-4f7d-aeb9-9d4a168521a9&at=APZUnTXSwzqLvYg2B65G4Xi6viy2%3A1707506608600');
                $storagePath = Storage::path('/public/mail_files'. '/' . $extension);
                if (!file_exists($storagePath)) {
                    mkdir($storagePath, 0755, true);
                }
                if ($fileContent !== false) {
                    file_put_contents($storagePath . '/' . $filename, $fileContent);
                }
                
                if (array_key_exists($extension, $iconos)) {
                    $icono = $iconos[$extension];
                } else {
                    $icono = $iconos['default'];
                }

                if (array_key_exists($extension, $colores)) {
                    $color = $colores[$extension];
                } else {
                    $color = $colores['default'];
                }
                $fileSize = filesize($storagePath . '/' . $filename);
                $tamaño = $fileSize / 1000;
                $unidad = 'KB';

                if ($tamaño >= 1024) {
                    $tamaño /= 1024;
                    $unidad = 'MB';
                }

                if ($tamaño >= 1024) {
                    $tamaño /= 1024;
                    $unidad = 'GB';
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $storagePath . '/' . $filename);
                finfo_close($finfo);

                $fileSize = number_format($tamaño, 2) . ' ' . $unidad;
                $file = [
                    'name' => $filename,
                    'url' => 'https://drive.google.com/uc?id='. $idF .'&export=download',
                    'ubi' => '/mail_files'.'/'.$extension. '/' . $filename,
                    'icon' => $icono,
                    'color' => $color,
                    'size' => $fileSize,
                    'mime' => $mime,
                ];
                array_push($files, $file);
            }
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
            $message->setFlag('Seen');
            $visto = true;
        }

        //Favorite
        $favorito = false;
        if (in_array("Flagged", $flgs)) {
            $favorito = true;
        }

        //Uid
        $uid = $message->uid;

        $correo = [
            'asunto' => $asunto,
            'remiteN' => $remitenteN,
            'remiteM' => $remitenteM,
            'to' => $to,
            'cc' => $cc,
            'bcc' => $bcc,
            'dia' => $date,
            'cuerpo' => $cuerpo,
            'adjuntos' => $adjuntos,
            'visto' => $visto,
            'favorito' => $favorito,
            'uid' => $uid,
            'files' => $files,
            'reply' => $reply
        ];

        return $correo;
    }
}
