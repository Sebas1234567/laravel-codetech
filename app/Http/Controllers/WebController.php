<?php

namespace Code\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Code\Models\Blog\Blog_Categoria;
use Code\Models\Cursos\Cursos_Categoria;
use Code\Models\Compras;
use Code\Models\Cursos\Cursos_Curso;
use Code\Models\Detalle_Compras;
use Code\Models\Tienda\Tienda_Producto;
use Code\Models\Tienda\Tienda_Producto_Valoracion;
use Code\Models\User;
use Code\Http\Requests\Tienda\TiendaProductoValoracionRequest;
use Code\Notifications\ContactTanks;
use Code\Notifications\ContactResponse;
use Code\Services\WebService;
use DB;
use Carbon\Carbon;

class WebController extends Controller
{
    private function navigation(){
        $webService = new WebService();
        $cates = $webService->showCategories();
        $items = [];
        $icons = ['ti-code', 'ti-database', 'ti-layout-grid'];
        $i = 0;
        foreach ($cates as $cate) {
            foreach ($cate as $c){
                $items[] = [
                    "nombre" => $c->nombre,
                    "url" => '/category'.'/'.$c->nombre,
                    "icono" => $icons[$i],
                ];
                $i++;
            }
        }
        $utilityItems = [
            ["nombre" => "Iconos", "url" => "", "icono" => "ti-icons"],
            ["nombre" => "Documentacion", "url" => "", "icono" => "ti-file-text"],
            ["nombre" => "Programas", "url" => "", "icono" => "ti-device-laptop"]
        ];
        $sections = [];
        $sections[] = [
            "nombre" => "Tutoriales",
            "items" => $items,
            "icono" => "ti-apps"
        ];
        $sections[] = [
            "nombre" => "Utilidades",
            "items" => $utilityItems,
            "icono" => "ti-report-search"
        ];
        $sections[] = ["nombre" => "Cursos", "url" => "/cursos", "icono" => "ti-certificate"];
        $sections[] = ["nombre" => "Contacto", "url" => "/contacto", "icono" => "ti-address-book"];
        $sections[] = ["nombre" => "Tienda", "url" => "/productos", "icono" => "ti-building-store"];

        return $sections;
    }

    private function footer(){
        $posts=DB::table('blog_entradas as ent')
            ->select('ent.id', 'ent.titulo', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre as autor')
            ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
            ->where('ent.publicado','=','1')
            ->where('ent.estado','=','1')
            ->orderBy('ent.fecha_publicacion','desc')
            ->limit(3)
            ->get();
        $curs=DB::table('cursos_curso as cur')
            ->select('cur.id', 'cur.titulo', 'cur.slug')
            ->where('cur.estado','=','1')
            ->orderBy('cur.fecha_publicacion','desc')
            ->limit(4)
            ->get();
        
        return ['posts'=>$posts,'curs'=>$curs];
    }

    public function index(Request $request) {
        if ($request->get('s')) {
            $entradas=DB::table('blog_entradas as ent')
                ->select('ent.id', 'ent.titulo', 'ent.descripcion', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre as autor')
                ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
                ->where('ent.publicado','=','1')
                ->where('ent.estado','=','1')
                ->where('ent.titulo','like', '%'.$request->get('s').'%')
                ->where('ent.descripcion','like', '%'.$request->get('s').'%')
                ->orderBy('ent.fecha_publicacion','desc')
                ->paginate(6);
            return view('web.search',['entradas'=>$entradas,'search'=>$request->get('s')]);
        } else {
            $hoy = Carbon::now()->toDateString();
            $entradas=DB::table('blog_entradas as ent')
                ->select('ent.id', 'ent.titulo', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre as autor',DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'))
                ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
                ->join('blog_entradas_categorias as bec', 'bec.blog_entradas_id', '=', 'ent.id')
                ->join('blog_categoria as cat', 'cat.id', '=', 'bec.blog_categoria_id')
                ->where('ent.publicado','=','1')
                ->where('ent.estado','=','1')
                ->groupBy('ent.id','ent.titulo','ent.imagen','ent.slug','ent.fecha_publicacion','aut.nombre')
                ->orderBy('ent.fecha_publicacion','desc')
                ->limit(6)
                ->get();
            $productos=DB::table('tienda_producto as prod')
                ->select('prod.id', 'prod.titulo', 'prod.imagen', 'prod.precio', 'prod.sku',DB::raw('AVG(puntuacion) as puntuacion'))
                ->join('tienda_producto_valoracion as val', 'val.producto', '=', 'prod.id')
                ->where('prod.publicado','=','1')
                ->where('prod.estado','=','1')
                ->groupBy('prod.id', 'prod.titulo', 'prod.imagen', 'prod.precio', 'prod.sku')
                ->orderBy('prod.fecha_publicacion','desc')
                ->limit(8)
                ->get();
            $cursos=DB::table('cursos_curso as cur')
                ->select('cur.id', 'cur.titulo', 'cur.imagen', 'cur.precio', 'cur.slug','cur.descripcion','cur.duracion')
                ->where('cur.estado','=','1')
                ->orderBy('cur.fecha_publicacion','desc')
                ->limit(6)
                ->get();
            $promocion=DB::table('promocion as prom')
                ->select('prom.id', 'prom.titulo', 'prom.imagen', 'prom.descripcion', 'prom.fecha_fin','prom.porcentaje')
                ->whereDate('prom.fecha_inicio', '<=', $hoy)
                ->whereDate('prom.fecha_fin', '>=', $hoy)
                ->where('prom.estado','=','1')
                ->orderBy('prom.fecha_inicio','desc')
                ->limit(1)
                ->get();
            $nav = $this->navigation();
            $foot = $this->footer();
            return view('web.index',['entradas'=>$entradas, 'productos'=>$productos, 'cursos'=>$cursos, 'promocion'=>$promocion, 'nav'=>$nav, 'secondNav'=>false, 'footer'=>$foot]);
        }
    }

    public function posts($categoria) {
        $webService = new WebService();
        $cates = $webService->showCategories();
        $items = [];
        $icons = [
            '0' => ['ti-code', 'ti-database', 'ti-layout-grid'],
            '1' => ['ti-app-window', 'ti-brand-c-sharp', 'ti-brand-python', 'ti-brand-php', 'ti-brand-react-native', 'ti-app-window'],
            '2' => ['ti-brand-mysql', 'ti-sql']
        ];
        $i = 0;
        foreach ($cates as $cate) {
            foreach ($cate as $c){
                $hijos = DB::table('blog_categoria as cat')
                ->select('cat.id', 'cat.nombre')
                ->where('cat.estado','=','1')
                ->where('cat.padre_id','=',$c->id)
                ->get();
                $hijoss = [];
                $ih = 0;
                foreach ($hijos as $hijo){
                    $hijoss[] = [
                        "nombre" => $hijo->nombre,
                        "url" => '/category'.'/'.$hijo->nombre,
                        "icono" => $icons[$c->id][$ih],
                    ];
                    $ih++;
                }
                if (empty($hijoss)) {
                    $items[] = [
                        "nombre" => $c->nombre,
                        "url" => '/category'.'/'.$c->nombre,
                        "icono" => $icons[0][$i],
                    ];
                } else {
                    $items[] = [
                        "nombre" => $c->nombre,
                        "icono" => $icons[0][$i],
                        "items" => $hijoss,
                    ];
                }
                $i++;
            }
        }
        $entradas=DB::table('blog_entradas as ent')
            ->select('ent.id', 'ent.titulo', 'ent.descripcion', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre as autor',DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'))
            ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
            ->join('blog_entradas_categorias as etc', 'etc.blog_entradas_id', '=', 'ent.id')
            ->join('blog_categoria as cat', 'cat.id', '=', 'etc.blog_categoria_id')
            ->where('ent.publicado','=','1')
            ->where('ent.estado','=','1')
            ->where(function ($query) use ($categoria) {
                if ($categoria) {
                    $query->whereExists(function ($subquery) use ($categoria) {
                        $subquery->select(DB::raw(1))
                                ->from('blog_entradas_categorias as etc')
                                ->join('blog_categoria as cat', 'cat.id', '=', 'etc.blog_categoria_id')
                                ->whereRaw('etc.blog_entradas_id = ent.id')
                                ->where('cat.nombre', '=', $categoria);
                    });
                }
            })
            ->groupBy('ent.id', 'ent.titulo', 'ent.descripcion', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre')
            ->orderBy('ent.fecha_publicacion','desc')
            ->paginate(6);
        $nav = $this->navigation();
        return view('web.posts',['entradas'=>$entradas,'categoria'=>$categoria,'nav'=>$nav, 'secondNav'=>true,'nav2'=>$items]);
    }

    public function showpost($slug){
        $entrada=DB::table('blog_entradas as ent')
            ->select('ent.id', 'ent.titulo', 'ent.descripcion', 'ent.contenido', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'ent.idvideo', 'aut.nombre as autor',DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'))
            ->join('blog_autor as aut', 'aut.id', '=', 'ent.idautor')
            ->join('blog_entradas_categorias as etc', 'etc.blog_entradas_id', '=', 'ent.id')
            ->join('blog_categoria as cat', 'cat.id', '=', 'etc.blog_categoria_id')
            ->where('ent.publicado','=','1')
            ->where('ent.estado','=','1')
            ->where('ent.slug','=',$slug)
            ->groupBy('ent.id', 'ent.titulo', 'ent.descripcion', 'ent.contenido', 'ent.imagen', 'ent.slug', 'ent.fecha_publicacion', 'aut.nombre', 'ent.idvideo')
            ->first();
        $ultimos=DB::table('blog_entradas as ent')
            ->select('ent.id', 'ent.titulo', 'ent.slug')
            ->where('ent.publicado','=','1')
            ->where('ent.estado','=','1')
            ->orderBy('ent.fecha_publicacion','desc')
            ->limit(5)
            ->get();
        $categoriasPadre = Blog_Categoria::whereNull('padre_id')->get();
        return view('web.postsd',['entrada'=>$entrada,'ultimos'=>$ultimos,'categorias'=>$categoriasPadre]);
    }

    public function contact(){
        return view('web.contacto');
    }

    public function sendContact(Request $request){
        $nombre = $request->get('nombre').' '.$request->get('apellidos');
        $email = $request->get('email');
        $asunto = $request->get('asunto');
        $mensaje = $request->get('mensaje');

        Notification::route('mail', $email)->notify(new ContactTanks($nombre));
        Notification::route('mail', 'code.tech.evolution@gmail.com')->notify(new ContactResponse($nombre,$email,$asunto,$mensaje));

        return response()->json(['success' => true]);
    }

    public function courses(){
        $categorias = Cursos_Categoria::where('estado','=',1)->get();
        $cursos = DB::table('cursos_curso as cur')
        ->select('cur.id','cur.slug','cur.titulo','cur.duracion','cur.cantidad_clases','cur.certificado','cur.precio','cur.imagen','cat.nombre')
        ->join('cursos_categoria as cat','cur.idcategoria','=','cat.id')
        ->where('cur.estado','=',1)
        ->paginate(9);
        return view('web.course',['categorias'=>$categorias,'cursos'=>$cursos]);
    }

    public function products(Request $request){
        if ($request->get('orderby') == null or  $request->get('orderby')=='date'){
            $productos = DB::table('tienda_producto as pro')
            ->select('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen',DB::raw('ROUND(AVG(tv.puntuacion),0) as puntuacion'))
            ->leftJoin('tienda_producto_valoracion as tv', 'tv.producto', '=', 'pro.id')
            ->where('pro.estado','=',1)
            ->where('pro.publicado','=',1)
            ->groupBy('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen')
            ->orderBy('pro.fecha_publicacion','desc')
            ->paginate(9);
        } else if ($request->get('orderby')=='price'){
            $productos = DB::table('tienda_producto as pro')
            ->select('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen',DB::raw('ROUND(AVG(tv.puntuacion),0) as puntuacion'))
            ->leftJoin('tienda_producto_valoracion as tv', 'tv.producto', '=', 'pro.id')
            ->where('pro.estado','=',1)
            ->where('pro.publicado','=',1)
            ->groupBy('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen')
            ->orderBy('pro.precio','asc')
            ->paginate(9);
        } else if ($request->get('orderby')=='price-desc'){
            $productos = DB::table('tienda_producto as pro')
            ->select('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen',DB::raw('ROUND(AVG(tv.puntuacion),0) as puntuacion'))
            ->leftJoin('tienda_producto_valoracion as tv', 'tv.producto', '=', 'pro.id')
            ->where('pro.estado','=',1)
            ->where('pro.publicado','=',1)
            ->groupBy('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen')
            ->orderBy('pro.precio','desc')
            ->paginate(9);
        } else if ($request->get('orderby')=='rating'){
            $productos = DB::table('tienda_producto as pro')
            ->select('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen',DB::raw('ROUND(AVG(tv.puntuacion),0) as puntuacion'))
            ->leftJoin('tienda_producto_valoracion as tv', 'tv.producto', '=', 'pro.id')
            ->where('pro.estado','=',1)
            ->where('pro.publicado','=',1)
            ->groupBy('pro.id','pro.sku','pro.titulo', 'pro.precio','pro.imagen')
            ->orderBy('puntuacion','desc')
            ->paginate(9);
        }
        return view('web.shop',['productos'=>$productos]);
    }

    public function showproduct($sku){
        $producto=DB::table('tienda_producto as prod')
            ->select('prod.id', 'prod.sku', 'prod.titulo', 'prod.descripcion', 'prod.contenido', 'prod.precio', 'prod.imagen', 'prod.galeria_imagenes', 'prod.descripcion_imagenes', 'prod.demo', 'prod.publicado', 'prod.estado', DB::raw('GROUP_CONCAT(cat.nombre ORDER BY cat.nombre) as categorias'), DB::raw('ROUND(AVG(tv.puntuacion),0) as puntuacion'))
            ->join('tienda_producto_categoria as tpc', 'tpc.tienda_producto_id', '=', 'prod.id')
            ->join('tienda_categoria as cat', 'cat.id', '=', 'tpc.tienda_categoria_id')
            ->leftJoin('tienda_producto_valoracion as tv', 'tv.producto', '=', 'prod.id')
            ->where('prod.publicado','=','1')
            ->where('prod.estado','=','1')
            ->where('prod.sku','=',$sku)
            ->groupBy('prod.id', 'prod.sku', 'prod.titulo', 'prod.descripcion', 'prod.contenido', 'prod.precio', 'prod.imagen', 'prod.galeria_imagenes', 'prod.descripcion_imagenes', 'prod.demo', 'prod.publicado', 'prod.estado')
            ->first();
        $categoria=DB::table('tienda_categoria as cat')
            ->select('cat.id', 'cat.nombre')
            ->join('tienda_producto_categoria as tpc', 'tpc.tienda_categoria_id', '=', 'cat.id')
            ->where('tpc.tienda_producto_id','=',$producto->id)
            ->orderBy('cat.id')
            ->first();
        $relacionados=DB::table('tienda_producto as prod')
            ->select('prod.id', 'prod.sku', 'prod.titulo', 'prod.precio', 'prod.imagen')
            ->join('tienda_producto_categoria as tpc', 'tpc.tienda_producto_id', '=', 'prod.id')
            ->where('prod.publicado','=','1')
            ->where('prod.estado','=','1')
            ->where('tpc.tienda_categoria_id','=',$categoria->id)
            ->where('prod.id', '!=', $producto->id)
            ->limit(4)
            ->get();
        $valoraciones=DB::table('tienda_producto_valoracion as tv')
            ->select('tv.id','tv.fecha_publicacion','us.name','tv.puntuacion','tv.comentario')
            ->join('users as us', 'tv.usuario', '=', 'us.id')
            ->where('tv.estado','=','1')
            ->where('tv.producto','=',$producto->id)
            ->get();
        $valoracionT=DB::table('tienda_producto_valoracion as tv')
            ->select(DB::raw('COUNT(*) as total'))
            ->where('tv.estado','=','1')
            ->where('tv.producto','=',$producto->id)
            ->first();
        return view('web.productd',['producto'=>$producto,'categoria'=>$categoria,'relacionados'=>$relacionados,'valoraciones'=>$valoraciones,'valoracionT'=>$valoracionT]);
    }

    public function verificateRender(){
        return view('auth.verify');
    }

    public function verificateUser(Request $request){
        $codigo = '';
        for ($i=1; $i < 7; $i++) { 
            $codigo .= $request->get('code'.$i);
        }
        $user = User::where('email','=',$request->get('email'))->first();
        if($user->verification_code == $codigo) {
            $user->estado = 1;
            $user->update();
            return redirect()->to('/');
        }
        else {
            Session::flash('error', 'El código de verificación ingresado es incorrecto.');
            return redirect()->back();
        }
    }

    public function payPalRequest(Request $request){
        $bodyPay = $request->json()->all();
        $compra = new Compras();
        $compra->n_pedido = $bodyPay['id'];
        $compra->fecha_compra = Carbon::now();
        $reference = base64_decode($bodyPay['purchase_units'][0]['reference_id']);
        $vals = explode('|',$reference);
        $compra->metodo_pago = $vals[1];
        $compra->total = (float)$bodyPay['purchase_units'][0]['amount']['value'];
        $compra->estado = 'Realizado';
        $usuarioB = User::where('email', $bodyPay['payer']['email_address'])->exists();
        if($usuarioB) {
            $usuario = User::where('email', $bodyPay['payer']['email_address'])->first();
            $compra->usuario = $usuario->id;
            $compra->save();
            Auth::login($usuario);
        } else {
            $usuario=new User;
            $usuario->name=$bodyPay['payer']['name']['given_name'].' '.$bodyPay['payer']['name']['surname'];
            $usuario->email=$bodyPay['payer']['email_address'];
            $usuario->role='clienteP';
            $usuario->imagen='png/avatar.png';
            $usuario->estado='1';
            $usuario->save();

            $compra->usuario = $usuario->id;
            $compra->save();
            Auth::login($usuario);
        }

        for ($i=0; $i < count($bodyPay['purchase_units'][0]['items']); $i++) { 
            $detalles = new Detalle_Compras();
            $detalles->compra = $compra->id;
            $productoP = Tienda_Producto::where('titulo',$bodyPay['purchase_units'][0]['items'][$i]['name'])->exists();
            if($productoP) {
                $producto = Tienda_Producto::where('titulo',$bodyPay['purchase_units'][0]['items'][$i]['name'])->first();
                $detalles->producto = $producto->id;
            } else {
                $curso = Cursos_Curso::where('titulo',$bodyPay['purchase_units'][0]['items'][$i]['name'])->first();
                $detalles->curso = $curso->id;
            }
            $detalles->cantidad = (int)$bodyPay['purchase_units'][0]['items'][$i]['quantity'];
            $detalles->precio_unitario = (float)$bodyPay['purchase_units'][0]['items'][$i]['unit_amount']['value'];
            $detalles->descuento = 0.00;
            $detalles->subtotal = (int)$bodyPay['purchase_units'][0]['items'][$i]['quantity']*(float)$bodyPay['purchase_units'][0]['items'][$i]['unit_amount']['value'];
            $detalles->save();
        }

        return response()->json(['success' => true,'compra'=>$compra->id]);
    }

    public function checkAprove($id){
        $compra = Compras::find($id);
        $detalles = Detalle_Compras::where('compra',$compra->id)->get();
        $usuario = User::where('id',$compra->usuario)->first();
        $productos = Tienda_Producto::all();
        $cursos = Cursos_Curso::all();
        return view('web.checkaprove',['compra'=>$compra,'detalles'=>$detalles,'usuario'=>$usuario,'productos'=>$productos,'cursos'=>$cursos]);
    }

    public function checkDownload($id){
        $compra = Compras::find($id);
        $compra->estado = 'Confirmado';
        $compra->save();
        $detallesP = Detalle_Compras::where('compra',$compra->id)->whereNotNull('producto')->get();
        $detallesC = Detalle_Compras::where('compra',$compra->id)->whereNotNull('curso')->get();
        $usuario = User::where('id',$compra->usuario)->first();
        $productos = Tienda_Producto::all();
        $cursos = Cursos_Curso::all();
        return view('web.checkdown',['compra'=>$compra,'detallesP'=>$detallesP,'detallesC'=>$detallesC,'usuario'=>$usuario,'productos'=>$productos,'cursos'=>$cursos]);
    }

    public function addValoration(TiendaProductoValoracionRequest $request){
        $valoracion = new Tienda_Producto_Valoracion();
        $valoracion->usuario = $request->get('usuario');
        $valoracion->producto = $request->get('producto');
        $valoracion->puntuacion = $request->get('puntuacion');
        $valoracion->comentario = $request->get('comentario');
        $valoracion->fecha_publicacion = Carbon::createFromFormat('d/m/Y', $request->get('fecha_publicacion'));
        $valoracion->estado = 1;
        $valoracion->save();

        $producto = Tienda_Producto::where('id','=',$request->get('id'))->first();

        return redirect('/product'.'/'.$producto->sku);
    }
}
