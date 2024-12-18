<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;

class ConfigController extends Controller
{
    public function index(){
        $configs = [
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'GOOGLE_CLIENT_ID' => env('GOOGLE_CLIENT_ID'),
            'GOOGLE_CLIENT_SECRET' => env('GOOGLE_CLIENT_SECRET'),
            'IMAP_HOST' => env('IMAP_HOST'),
            'IMAP_PORT' => env('IMAP_PORT'),
            'IMAP_USERNAME' => env('IMAP_USERNAME'),
            'IMAP_PASSWORD' => env('IMAP_PASSWORD'),
            'APP_TIMEZONE' => env('APP_TIMEZONE'),
            'APP_LOCALE' => env('APP_LOCALE'),
        ];
        return view('admin.config',['configs'=>$configs]);
    }

    public function update(Request $request){
        if (!$this->validateKey('APP_TIMEZONE',$request->get('zona'))) {
            $this->actualizarEnv('APP_TIMEZONE', $request->get('zona'));
        }
        if (!$this->validateKey('APP_LOCALE',$request->get('locale'))) {
            $this->actualizarEnv('APP_LOCALE', $request->get('locale'));
        }
        if (!$this->validateKey('MAIL_HOST',$request->get('mhost'))) {
            $this->actualizarEnv('MAIL_HOST', $request->get('mhost'));
        }
        if (!$this->validateKey('MAIL_PORT',$request->get('mport'))) {
            $this->actualizarEnv('MAIL_PORT', $request->get('mport'));
        }
        if (!$this->validateKey('MAIL_USERNAME',$request->get('musername'))) {
            $this->actualizarEnv('MAIL_USERNAME', $request->get('musername'));
            $this->actualizarEnv('MAIL_FROM_ADDRESS', '"'.$request->get('musername').'"');
        }
        if (!$this->validateKey('MAIL_PASSWORD',$request->get('mpassword'))) {
            $this->actualizarEnv('MAIL_PASSWORD', $request->get('mpassword'));
        }
        if (!$this->validateKey('GOOGLE_CLIENT_ID',$request->get('clientID'))) {
            $this->actualizarEnv('GOOGLE_CLIENT_ID', $request->get('clientID'));
        }
        if (!$this->validateKey('GOOGLE_CLIENT_SECRET',$request->get('secret'))) {
            $this->actualizarEnv('GOOGLE_CLIENT_SECRET', $request->get('secret'));
        }
        if (!$this->validateKey('IMAP_HOST',$request->get('ihost'))) {
            $this->actualizarEnv('IMAP_HOST', $request->get('ihost'));
        }
        if (!$this->validateKey('IMAP_PORT',$request->get('iport'))) {
            $this->actualizarEnv('IMAP_PORT', $request->get('iport'));
        }
        if (!$this->validateKey('IMAP_USERNAME',$request->get('iusername'))) {
            $this->actualizarEnv('IMAP_USERNAME', $request->get('iusername'));
        }
        if (!$this->validateKey('IMAP_PASSWORD',$request->get('ipassword'))) {
            $this->actualizarEnv('IMAP_PASSWORD', $request->get('ipassword'));
        }
        Artisan::call('config:clear');
        return Redirect::to('admin/configuration');
    }

    private function validateKey($clave,$valor)
    {
        if ($valor == env($clave)) {
            return true;
        }
        return false;
    }

    private function actualizarEnv($clave, $valor)
    {
        $archivoEnv = base_path('.env');
        if (File::exists($archivoEnv)) {
            $contenido = File::get($archivoEnv);
            if (str_contains($contenido, $clave)) {
                $contenido = preg_replace("/{$clave}=.*/", "{$clave}={$valor}", $contenido);
            } else {
                $contenido .= "\n{$clave}={$valor}";
            }
            File::put($archivoEnv, $contenido);
        }
    }
}
