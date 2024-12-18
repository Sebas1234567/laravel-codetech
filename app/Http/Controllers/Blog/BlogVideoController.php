<?php

namespace Code\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Code\Models\Blog\Blog_Video;
use Code\Models\Notificaciones;
use Code\Http\Requests\Blog\BlogVideoRequest;
use Illuminate\Support\Facades\Redirect;
use Code\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use ProtoneMedia\LaravelFFMpeg\Filters\TileFactory;

class BlogVideoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $videos=Blog_Video::select('id','nombre','calidad','videos','subtitulos','poster','estado')
            ->paginate(9);
            return view('admin.blog.video.index',["videos"=>$videos]);
        }
    }

    public function create()
    {
        return view('admin.blog.video.create');
    }

    public function store(BlogVideoRequest $request)
    {
        $video=new Blog_Video;
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
            'titulo' => 'Videos',
            'descripcion' => 'Nuevo video registrada.',
            'icono' => 'fa-duotone fa-video',
            'color' => 'text-success',
            'url' => 'admin/blog/video',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/video');

    }

    public function show($id)
    {
        return view('admin.blog.video.show',["video"=>Blog_Video::findOrFail($id)]);
    }

    public function edit($id)
    {
        $video = Blog_Video::findOrFail($id);
        return view('admin.blog.video.edit',["video"=>$video]);
    }

    public function update(BlogVideoRequest $request,$id)
    {
        $autor=Blog_Video::findOrFail($id);
        $autor->nombre=$request->get('nombre');
        $autor->descripcion=$request->get('descripcion');
        $autor->update();
        return Redirect::to('admin/blog/video');
    }

    public function destroy($id)
    {
        $video=Blog_Video::findOrFail($id);
        $video->estado=0;
        $video->update();
        Notificaciones::create([
            'titulo' => 'Videos',
            'descripcion' => 'Video eliminado.',
            'icono' => 'fa-duotone fa-video',
            'color' => 'text-danger',
            'url' => 'admin/blog/video',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }

    public function thumb($id)
    {
        set_time_limit(600);
        $video = Blog_Video::findOrFail($id);
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
