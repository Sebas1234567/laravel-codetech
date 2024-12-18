<?php

namespace Code\Http\Controllers\Cursos;

use Illuminate\Http\Request;
use Code\Http\Requests\Cursos\CursosCursoRequest;
use Code\Models\Cursos\Cursos_Categoria;
use Code\Models\Cursos\Cursos_Curso;
use Code\Models\Cursos\Cursos_Leccion;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Code\Http\Controllers\Controller;
use Code\Models\Notificaciones;

class CursosCursoController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $cursos=DB::table('cursos_curso as cur')
            ->select('cur.id', 'cur.titulo', 'cur.imagen', 'cur.descripcion', 'cur.duracion', 'cur.cantidad_clases', 'cur.cantidad_recursos', 'cur.certificado', 'cur.precio', 'cur.fecha_publicacion', 'cur.estado', 'cat.nombre as categoria')
            ->join('cursos_categoria as cat', 'cat.id', '=', 'cur.idcategoria')
            ->paginate(6);
            return view('admin.cursos.curso.index',["cursos"=>$cursos]);
        }
    }

    public function create()
    {
        $categorias = Cursos_Categoria::where('estado', 1)->pluck("nombre","id");
        return view('admin.cursos.curso.create',["categorias"=>$categorias]);
    }

    public function store(CursosCursoRequest $request)
    {
        $curso=new Cursos_Curso;
        $curso->slug=$request->get('slug');
        $curso->titulo=$request->get('titulo');
        $curso->descripcion=$request->get('descripcion');
        $curso->contenido=$request->get('contenido');
        $curso->duracion=0;
        $curso->cantidad_clases=0;
        $curso->cantidad_recursos=0;
        $curso->certificado=$request->get('certificado');
        $curso->precio=$request->get('precio');
        $curso->idcategoria=$request->get('idcategoria');
        $curso->fecha_publicacion=$request->get('fecha_publicacion');
        $curso->estado='1';

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $curso->imagen = $nombre;

        $curso->save();
        Notificaciones::create([
            'titulo' => 'Curso',
            'descripcion' => 'Nuevo curso registrado.',
            'icono' => 'fa-duotone fa-graduation-cap',
            'color' => 'text-success',
            'url' => 'admin/cursos/curso',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/curso');
    }

    public function show($id)
    {
        $lecciones = Cursos_Leccion::where('curso', $id)->get();
        $curso = Cursos_Curso::findOrFail($id);
        return view('admin.cursos.curso.show',["curso"=> $curso,"lecciones"=> $lecciones]);
    }

    public function edit($id)
    {
        $categorias = Cursos_Categoria::where('estado', 1)->pluck("nombre","id");
        $curso = Cursos_Curso::findOrFail($id);
        return view('admin.cursos.curso.edit',["curso"=>$curso,"categorias"=>$categorias]);
    }

    public function update(CursosCursoRequest $request,$id)
    {
        $curso=Cursos_Curso::findOrFail($id);
        $curso->slug=$request->get('slug');
        $curso->titulo=$request->get('titulo');
        $curso->descripcion=$request->get('descripcion');
        $curso->contenido=$request->get('contenido');
        $curso->duracion=$curso->duracion;
        $curso->cantidad_clases=$curso->cantidad_clases;
        $curso->cantidad_recursos=$curso->cantidad_recursos;
        $curso->certificado=$request->get('certificado');
        $curso->precio=$request->get('precio');
        $curso->idcategoria=$request->get('idcategoria');
        $curso->fecha_publicacion=$request->get('fecha_publicacion');
        $curso->estado=$curso->estado;

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $curso->imagen = $nombre;

        $curso->update();
        Notificaciones::create([
            'titulo' => 'Curso',
            'descripcion' => 'Curso editado.',
            'icono' => 'fa-duotone fa-graduation-cap',
            'color' => 'text-info',
            'url' => 'admin/cursos/curso',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/cursos/curso');
    }

    public function destroy($id)
    {
        $curso=Cursos_Curso::findOrFail($id);
        $curso->estado=0;
        $curso->update();
        Notificaciones::create([
            'titulo' => 'Curso',
            'descripcion' => 'Curso eliminado.',
            'icono' => 'fa-duotone fa-graduation-cap',
            'color' => 'text-danger',
            'url' => 'admin/cursos/curso',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
