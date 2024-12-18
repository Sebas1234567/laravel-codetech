<?php

namespace Code\Http\Controllers\Gmail;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Code\Mail\ReenvioMail;
use Code\Mail\RespuestaMail;
use Code\Mail\MessageMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;

class GmailController extends Controller
{
    public function index(Request $request){
        $client = Client::account('default');
        $client->connect();
        set_time_limit(360);
        $correos = GmailFunctions::ListAllMessages($client,'INBOX');
        $itemsPorPagina = 6;
        $totalElementos = count($correos['correos']);
        $paginaActual = LengthAwarePaginator::resolveCurrentPage();
        $itemsPaginados = array_slice($correos['correos'], ($paginaActual - 1) * $itemsPorPagina, $itemsPorPagina);
        $paginator = new LengthAwarePaginator($itemsPaginados, $totalElementos, $itemsPorPagina, $paginaActual);

        return view('admin.mail.index',['paginator'=>$paginator,'vistos'=>$correos['vistos'],'folder'=>'INBOX']);
    }

    public function sends(Request $request){
        $client = Client::account('default');
        $client->connect();
        set_time_limit(360);
        $correos = GmailFunctions::ListAllMessages($client,'Enviados');
        $itemsPorPagina = 6;
        $totalElementos = count($correos['correos']);
        $paginaActual = LengthAwarePaginator::resolveCurrentPage();
        $itemsPaginados = array_slice($correos['correos'], ($paginaActual - 1) * $itemsPorPagina, $itemsPorPagina);
        $paginator = new LengthAwarePaginator($itemsPaginados, $totalElementos, $itemsPorPagina, $paginaActual);

        return view('admin.mail.index',['paginator'=>$paginator,'vistos'=>$correos['vistos'],'folder'=>'Enviados']);
    }

    public function junks(Request $request){
        $client = Client::account('default');
        $client->connect();
        set_time_limit(360);
        $correos = GmailFunctions::ListAllMessages($client,'Spam');
        $itemsPorPagina = 6;
        $totalElementos = count($correos['correos']);
        $paginaActual = LengthAwarePaginator::resolveCurrentPage();
        $itemsPaginados = array_slice($correos['correos'], ($paginaActual - 1) * $itemsPorPagina, $itemsPorPagina);
        $paginator = new LengthAwarePaginator($itemsPaginados, $totalElementos, $itemsPorPagina, $paginaActual);

        return view('admin.mail.index',['paginator'=>$paginator,'vistos'=>$correos['vistos'],'folder'=>'Spam']);
    }

    public function trash(Request $request){
        $client = Client::account('default');
        $client->connect();
        set_time_limit(360);
        $correos = GmailFunctions::ListAllMessages($client,'Papelera');
        $itemsPorPagina = 6;
        $totalElementos = count($correos['correos']);
        $paginaActual = LengthAwarePaginator::resolveCurrentPage();
        $itemsPaginados = array_slice($correos['correos'], ($paginaActual - 1) * $itemsPorPagina, $itemsPorPagina);
        $paginator = new LengthAwarePaginator($itemsPaginados, $totalElementos, $itemsPorPagina, $paginaActual);

        return view('admin.mail.index',['paginator'=>$paginator,'vistos'=>$correos['vistos'],'folder'=>'Papelera']);
    }

    public function favorite(Request  $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        if ($folder == 'INBOX') {
            $folder = $client->getFolderByPath($folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $id);
        $flgs = [];
        foreach ($message->getFlags() as $flag){
            array_push($flgs,$flag);
        }
        if (in_array("Flagged", $flgs)) {
            $message->unsetFlag('Flagged');
        } else {
            $message->setFlag('Flagged');
        }
    }

    public function papelera(Request  $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        if ($folder == 'INBOX') {
            $folder = $client->getFolderByPath($folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $id);
        $message = $message->move($folder_path = "[Gmail]/Papelera");
    }

    public function eliminar(Request  $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        if ($folder == 'INBOX') {
            $folder = $client->getFolderByPath($folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $id);
        $message = $message->delete($expunge = true);
    }

    public function seen(Request  $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        if ($folder == 'INBOX') {
            $folder = $client->getFolderByPath($folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $id);
        $flgs = [];
        foreach ($message->getFlags() as $flag){
            array_push($flgs,$flag);
        }
        if (in_array("Seen", $flgs)) {
            $message->unsetFlag('Seen');
        } else {
            $message->setFlag('Seen');
        }
    }

    public function important(Request  $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        if ($folder == 'INBOX') {
            $folder = $client->getFolderByPath($folder);
        } else {
            $folder = $client->getFolderByPath('[Gmail]/'.$folder);
        }
        $query = $folder->query();
        $message = $query->getMessageByUid($uid = $id);
        $message = $message->copy($folder_path = "[Gmail]/Importantes");
    }

    public function detalle(Request $request, $folder, $id){
        $client = Client::account('default');
        $client->connect();
        $correo = GmailFunctions::GetMessage($client,$folder,$id);

        return view('admin.mail.detail',['correo'=>$correo,'folder'=>$folder]);
    }

    public function forward(Request $request, $folder){
        $adjuntos = explode(';',$request->get('adjuntos'));
        $mime = explode(';',$request->get('mime'));
        $attach = [];
        for ($i=0; $i < count($adjuntos); $i++) { 
            $attach[] = [
                'name' => $adjuntos[$i],
                'mime' => $mime[$i]
            ];
        }
        Mail::to($request->get('mail'))->send(new ReenvioMail($request->get('uid'),$request->get('asunto'),$request->get('mensajeFord'),$folder,$attach));

        return Redirect::to('admin/mail');
    }

    public function reply(Request $request, $folder){
        $adjuntos = explode(';',$request->get('adjuntos'));
        $mime = explode(';',$request->get('mime'));
        $attach = [];
        for ($i=0; $i < count($adjuntos); $i++) { 
            $attach[] = [
                'name' => $adjuntos[$i],
                'mime' => $mime[$i]
            ];
        }
        Mail::to($request->get('mail'))->send(new RespuestaMail($request->get('uid'),$request->get('asunto'),$request->get('mensajeReply'),$folder,$attach));

        return Redirect::to('admin/mail');
    }

    public function enviar(Request $request){
        $subject = $request->get("subject");
        $tot = explode(',', $request->get("to"));
        $cct = explode(',', $request->get("cc"));
        $bcct = explode(',', $request->get("bcc"));
        $to = array_filter(array_map('trim', $tot), function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        });
        $cc = array_filter(array_map('trim', $cct), function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        });
        $bcc = array_filter(array_map('trim', $bcct), function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        });
        $cuerpo = $request->get("mensaje");
        $adjuntos = explode(';',$request->get('adjuntos'));
        $mime = explode(';',$request->get('mime'));
        $attach = [];
        for ($i=0; $i < count($adjuntos); $i++) { 
            $attach[] = [
                'name' => $adjuntos[$i],
                'mime' => $mime[$i]
            ];
        }
        Mail::to($to)
        ->when($cc, function ($message) use ($cc) {
            return $message->cc($cc);
        })
        ->when($bcc, function ($message) use ($bcc) {
            return $message->bcc($bcc);
        })
        ->send(new MessageMail($subject,$cuerpo,$attach));

        return Redirect::to('admin/mail');
    }
}
