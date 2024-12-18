<?php

namespace Code\Http\Controllers\Cursos;

use Illuminate\Http\Request;
use Code\Models\Cursos\Cursos_Video;
use Code\Http\Requests\Cursos\CursosVideoRequest;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;

class CursosVideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $videos=Cursos_Video::select('id','nombre','calidad','videos','subtitulos','poster','estado')
            ->paginate(9);
            return view('admin.cursos.video.index',["videos"=>$videos]);
        }
    }

    public function create()
    {
        return view('admin.cursos.video.create');
    }

    public function store(CursosVideoRequest $request)
    {
        $video=new Cursos_Video;
        $video->calidad=implode(',',$request->get('multi-select-calidades'));
        $video->nombre=$request->get('nombre');
        $video->extension=$request->get('extension');
        $video->videos=$request->get('url');
        $video->estado='1';

        $files=explode(';',$request->get('files'));
        $subtitulos = [];
        $poster = '';
        for ($i=0; $i < count($files); $i++) {
            $extension=explode('/',$files[$i])[0];
            $archivo=explode('/',$files[$i])[1];
            if ($extension == 'vtt') {
                $subtitulos[]=$files[$i];
            } elseif ($extension == 'jpg' || $extension == 'png' || $extension == 'jpeg') {
                $poster = $files[$i];
            }
        }
        $video->subtitulos=implode(';',$subtitulos);
        $video->poster=$poster;
        $video->save();
        $thumb = thumb($video->id);
        Notificaciones::create([
            'titulo' => 'Video',
            'descripcion' => 'Nuevo video registrado.',
            'icono' => 'fa-duotone fa-video',
            'color' => 'text-success',
            'url' => 'admin/cursos/video',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/video');

    }

    public function show($id)
    {
        return view('admin.cursos.video.show',["video"=>Cursos_Video::findOrFail($id)]);
    }

    public function edit($id)
    {
        $video = Cursos_Video::findOrFail($id);
        return view('admin.cursos.video.edit',["video"=>$video]);
    }

    public function update(CursosVideoRequest $request,$id)
    {
        $video=Cursos_Video::findOrFail($id);
        $video->nombre=$request->get('nombre');
        $video->descripcion=$request->get('descripcion');
        $video->update();
        return Redirect::to('admin/cursos/video');
    }

    public function destroy($id)
    {
        $video=Cursos_Video::findOrFail($id);
        $video->estado=0;
        $video->update();
        Notificaciones::create([
            'titulo' => 'Video',
            'descripcion' => 'Video eliminado.',
            'icono' => 'fa-duotone fa-video',
            'color' => 'text-success',
            'url' => 'admin/cursos/video',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }

    public function thumb($id)
    {
        set_time_limit(600);
        $video = Cursos_Video::findOrFail($id);
        $arrayv = explode(';', $video->videos);
        $file = $arrayv[count($arrayv)-1];
        $framesPath = 'frames/'.$video->id;
        $client = new \GuzzleHttp\Client();
        $response = $client->get($file);
        $videoContent = $response->getBody()->getContents();
        $disk = 'memory';
        Storage::disk($disk)->put('video.mp4', $videoContent);
        $vid = FFMpeg::fromDisk($disk)->open('video.mp4');
        $vid->exportTile(function (TileFactory $factory) {
            $factory->interval(1)
                ->scale(178,100)
                ->grid(7, 7)
                ->generateVTT('thumbnails.vtt');
        })
        ->save('tile_%05d.jpg');
        $extension = 'jpg';
        $archivos = Storage::disk('memory')->files();
        $archivosConExtension = array_filter($archivos, function ($archivo) use ($extension) {
            return pathinfo($archivo, PATHINFO_EXTENSION) == $extension;
        });
        $numeroDeArchivos = count($archivosConExtension);
        $archivosConExtension = array_filter($archivos, function ($archivo) use ($extension) {
            return pathinfo($archivo, PATHINFO_EXTENSION) == $extension;
        });
        $numeroDeArchivos = count($archivosConExtension);
        for ($i=1; $i < $numeroDeArchivos+1; $i++) { 
            $diskOrigen = 'memory';
            $diskDestino = 'public';
            if ($i<10) {
                $rutaOrigen = 'tile_0000'.$i.'.jpg';
            } else {
                $rutaOrigen = 'tile_000'.$i.'.jpg';
            }
            $rutaDestino = $framesPath.'/'.$rutaOrigen;
            $contenidoArchivo = Storage::disk($diskOrigen)->get($rutaOrigen);
            Storage::disk($diskDestino)->put($rutaDestino, $contenidoArchivo);
            Storage::disk($diskOrigen)->delete($rutaOrigen);
        }
        $diskOrigen = 'memory';
        $diskDestino = 'public';
        $rutaOrigen = 'thumbnails.vtt';
        $rutaDestino = $framesPath.'/'.$rutaOrigen;
        $contenidoArchivo = Storage::disk($diskOrigen)->get($rutaOrigen);
        Storage::disk($diskDestino)->put($rutaDestino, $contenidoArchivo);
        Storage::disk($diskOrigen)->delete($rutaOrigen);
        return $rutaDestino;
    }
}
