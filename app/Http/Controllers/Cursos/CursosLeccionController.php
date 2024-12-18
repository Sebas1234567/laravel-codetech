<?php

namespace Code\Http\Controllers\Cursos;

use Illuminate\Http\Request;
use Code\Http\Requests\Cursos\CursosLeccionRequest;
use Code\Models\Cursos\Cursos_Leccion;
use Code\Models\Cursos\Cursos_Video;
use Code\Models\Cursos\Cursos_Curso;
use Illuminate\Support\Facades\Redirect;
use ProtoneMedia\LaravelFFMpeg\Support\FFMpeg;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Storage;

class CursosLeccionController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $lecciones=Cursos_Leccion::select('cursos_leccion.id','cursos_leccion.titulo','cursos_leccion.descripcion','cursos_leccion.duracion')
            ->get();
            return view('admin.cursos.leccion.index',["lecciones"=>$lecciones]);
        }
    }

    public function create($idcurso)
    {
        $videos = Cursos_Video::where('estado', 1)->pluck("nombre","id");
        $curso = $idcurso;
        return view('admin.cursos.leccion.create',["videos"=>$videos,"curso"=>$curso]);
    }

    public function store(CursosLeccionRequest $request)
    {
        $leccion=new Cursos_Leccion;
        $leccion->titulo=$request->get('titulo');
        $leccion->descripcion=$request->get('descripcion');
        $leccion->categoria=$request->get('categoria');
        $leccion->video=$request->get('video');
        $leccion->curso=$request->get('curso');
        $tot_recur = 0;
        if($request->get('recursos')){
            $leccion->recursos=$request->get('recursos');
            $recursos = explode(';',$request->get('recursos'));
            $tot_recur = count($recursos);
        }

        set_time_limit(360);
        $videos = Cursos_Video::findOrFail($request->get('video'));
        $video=explode(';',$videos->videos);
        $client = new \GuzzleHttp\Client();
        $response = $client->get($video[0]);
        $videoContent = $response->getBody()->getContents();
        $disk = 'memory';
        Storage::disk($disk)->put('video.mp4', $videoContent);
        $vid = FFMpeg::fromDisk($disk)->open('video.mp4');
        $duracion = $vid->getDurationInSeconds();
        $leccion->duracion = $duracion;
        $leccion->estado = 1;
        $leccion->save();

        $curso = Cursos_Curso::findOrFail($request->get('curso'));
        $curso->duracion+=$duracion;
        $curso->cantidad_clases+=1;
        $curso->cantidad_recursos+=$tot_recur;
        $curso->update();
        Notificaciones::create([
            'titulo' => 'Leccion',
            'descripcion' => 'Nueva leccion registrada.',
            'icono' => 'fa-duotone fa-book',
            'color' => 'text-success',
            'url' => 'admin/cursos/curso/'.$request->get('curso'),
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/curso/'.$request->get('curso'));

    }

    public function show($id)
    {
        return view('admin.cursos.leccion.show',["lecciones"=>Cursos_Leccion::findOrFail($id)]);
    }

    public function edit($id)
    {
        $leccion = Cursos_Leccion::findOrFail($id);
        return view('admin.cursos.leccion.edit',["leccion"=>$leccion]);
    }

    public function update(CursosLeccionRequest $request,$id)
    {
        $leccion=Cursos_Leccion::findOrFail($id);
        $leccion->nombre=$request->get('nombre');
        $leccion->descripcion=$request->get('descripcion');
        $leccion->update();
        return Redirect::to('admin/cursos/leccion');
    }

    public function destroy($id)
    {
        $leccion=Cursos_Leccion::findOrFail($id);
        $leccion->estado=0;
        $leccion->update();
        Notificaciones::create([
            'titulo' => 'Leccion',
            'descripcion' => 'Leccion eliminada.',
            'icono' => 'fa-duotone fa-book',
            'color' => 'text-danger',
            'url' => 'admin/cursos/curso/'.$request->get('curso'),
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
