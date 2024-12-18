<?php

namespace Code\Http\Controllers\Blog;

use Illuminate\Http\Request;
use Code\Http\Requests\Blog\BlogEntradasRequest;
use Code\Models\Blog\Blog_Entradas;
use Code\Models\Blog\Blog_Categoria;
use Code\Models\Blog\Blog_Autor;
use Code\Models\Blog\Blog_Video;
use Code\Models\Notificaciones;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Code\Http\Controllers\Controller;

class BlogEntradasController extends Controller
{
    public function index(Request $request)
    {
        if ($request)
        {
            $entradas=DB::table('blog_entradas as ent')
            ->select('ent.id', 'ent.titulo', 'ent.imagen', 'ent.descripcion', 'ent.fecha_publicacion', 'ent.publicado', 'ent.estado', 'aut.nombre as autor', DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'), 'vid.id as video')
            ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
            ->join('blog_video as vid', 'vid.id', '=', 'ent.idvideo')
            ->join('blog_entradas_categorias as etc', 'etc.blog_entradas_id', '=', 'ent.id')
            ->join('blog_categoria as cat', 'cat.id', '=', 'etc.blog_categoria_id')
            ->groupBy('ent.id','ent.titulo','ent.imagen','ent.descripcion','ent.fecha_publicacion','ent.publicado','ent.estado','aut.nombre','vid.id')
            ->paginate(6);
            return view('admin.blog.entradas.index',["entradas"=>$entradas]);
        }
    }

    public function create()
    {
        $categorias = Blog_Categoria::whereNotNull('padre_id')->pluck("nombre","id");
        $videos = Blog_Video::all()->pluck("nombre","id");
        $autores = Blog_Autor::all()->pluck("nombre","id");
        return view('admin.blog.entradas.create',["categorias"=>$categorias,"videos"=>$videos,"autores"=>$autores]);
    }

    public function store(BlogEntradasRequest $request)
    {
        $entrada=new Blog_Entradas;
        $entrada->slug=$request->get('slug');
        $entrada->titulo=$request->get('titulo');
        $entrada->descripcion=$request->get('descripcion');
        $entrada->contenido=$request->get('contenido');
        $entrada->fecha_publicacion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion'));
        $entrada->idvideo=$request->get('idvideo');
        $entrada->idautor=$request->get('idautor');
        $entrada->estado='1';

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $entrada->imagen = $nombre;

        $fechaActual = Carbon::now();
        if ($entrada->fecha_publicacion->isToday()) {
            $entrada->publicado = '1';
        } else {
            $entrada->publicado = '0';
        }

        $entrada->save();
        $entrada->categorias()->attach($request->get('idcategoria'));
        Notificaciones::create([
            'titulo' => 'Entradas',
            'descripcion' => 'Nueva entrada registrada.',
            'icono' => 'fa-duotone fa-browsers',
            'color' => 'text-success',
            'url' => 'admin/blog/entradas',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/entradas');
    }

    public function show($id)
    {
        return view('admin.blog.entradas.show',["entrada"=> Blog_Entradas::findOrFail($id)]);
    }

    public function edit($id)
    {
        $categorias = Blog_Categoria::whereNotNull('padre_id')->pluck("nombre","id");
        $videos = Blog_Video::all()->pluck("nombre","id");
        $autores = Blog_Autor::all()->pluck("nombre","id");
        $entrada = DB::table('blog_entradas as ent')
        ->select('ent.id', 'ent.titulo', 'ent.imagen', 'ent.descripcion', 'ent.fecha_publicacion', 'ent.publicado', 'ent.estado', 'ent.idautor', 'ent.idvideo', 'ent.contenido', 'ent.slug', DB::raw('GROUP_CONCAT(cat.id ORDER BY cat.id) as categorias'))
        ->join('blog_entradas_categorias as etc', 'etc.blog_entradas_id', '=', 'ent.id')
        ->join('blog_categoria as cat', 'cat.id', '=', 'etc.blog_categoria_id')
        ->where('ent.id', $id)
        ->groupBy('ent.id','ent.titulo','ent.imagen','ent.descripcion','ent.fecha_publicacion','ent.estado','ent.idautor','ent.idvideo','ent.contenido','ent.slug','ent.publicado')
        ->first();
        return view('admin.blog.entradas.edit',["entrada"=>$entrada,"categorias"=>$categorias,"videos"=>$videos,"autores"=>$autores]);
    }

    public function update(BlogEntradasRequest $request,$id)
    {
        $entrada=Blog_Entradas::findOrFail($id);
        $entrada->slug=$request->get('slug');
        $entrada->titulo=$request->get('titulo');
        $entrada->descripcion=$request->get('descripcion');
        $entrada->contenido=$request->get('contenido');
        $entrada->fecha_publicacion=Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion'));
        $entrada->idvideo=$request->get('idvideo');
        $entrada->idautor=$request->get('idautor');
        $entrada->estado='1';

        $imagen = $request->file('imagen');
        $carpeta = 'files/'.$imagen->getClientOriginalExtension().'/';
        $imagen->storeAs($carpeta, $imagen->getClientOriginalName(), 'public');
        $nombre = $imagen->getClientOriginalExtension().'/'.$imagen->getClientOriginalName();
        $entrada->imagen = $nombre;

        $fechaActual = Carbon::now();
        if ($entrada->fecha_publicacion->isToday()) {
            $entrada->publicado = '1';
        } else {
            $entrada->publicado = '0';
        }

        $entrada->update();
        $entrada->categorias()->sync($request->get('idcategoria'));
        Notificaciones::create([
            'titulo' => 'Entradas',
            'descripcion' => 'Entrada editada.',
            'icono' => 'fa-duotone fa-browsers',
            'color' => 'text-info',
            'url' => 'admin/blog/entradas',
            'visto' => 0,
            'toast' => 1,
        ]);
        return Redirect::to('admin/blog/entradas');
    }

    public function destroy($id)
    {
        $entrada=Blog_Entradas::findOrFail($id);
        $entrada->estado=0;
        $entrada->update();
        Notificaciones::create([
            'titulo' => 'Entradas',
            'descripcion' => 'Entrada eliminada.',
            'icono' => 'fa-duotone fa-browsers',
            'color' => 'text-danger',
            'url' => 'admin/blog/entradas',
            'visto' => 0,
            'toast' => 1,
        ]);
        return response()->json(['success' => true]);
    }
}
