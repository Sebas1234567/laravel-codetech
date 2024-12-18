<?php

namespace Code\Http\Controllers\Routes;

use Illuminate\Http\Request;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\Route;
use Code\Http\Controllers\Controller;
use Code\Http\Controllers\Blog;
use Code\Http\Controllers\Tienda;
use Code\Http\Controllers\Cursos;
use Code\Http\Controllers\Gmail;
use Code\Http\Controllers\Extras;
use Code\Http\Controllers;

class AdminRoutes extends Controller
{
    public static function routes()
    {
        Route::middleware(['web', 'auth', 'trabajador:trabajador'])->group(function () {
            Route::name('admin.')->prefix('admin')->group(function () {
                Route::name('blog')->resource('blog/categoria', Blog\BlogCategoriaController::class);
                Route::name('blog')->resource('blog/autor', Blog\BlogAutorController::class);
                Route::name('blog')->resource('blog/video', Blog\BlogVideoController::class);
                Route::name('blog')->resource('blog/entradas', Blog\BlogEntradasController::class);
                Route::name('tienda')->resource('tienda/categoria', Tienda\TiendaCategoriaController::class);
                Route::name('tienda')->resource('tienda/productos', Tienda\TiendaProductoController::class);
                Route::name('tienda')->resource('tienda/descuento', Tienda\TiendaDescuentoController::class);
                Route::name('tienda')->resource('tienda/giftcard', Tienda\TiendaGiftcardController::class);
                Route::name('cursos')->resource('cursos/categoria', Cursos\CursosCategoriaController::class);
                Route::name('cursos')->resource('cursos/video', Cursos\CursosVideoController::class);
                Route::name('cursos')->resource('cursos/curso', Cursos\CursosCursoController::class);
                Route::name('cursos')->resource('cursos/leccion', Cursos\CursosLeccionController::class);
                Route::name('promocion')->resource('/promociones', Controllers\PromocionController::class);
                Route::name('cursos')->get('/cursos/leccion/create/{idcurso}', [Cursos\CursosLeccionController::class, 'create']);
                Route::name('dashboard')->get('/dashboard', [Controllers\DashboardController::class, 'index']);
                Route::name('usuarios')->resource('usuarios', Controllers\UserController::class);
                Route::name('compras')->resource('compras', Controllers\ComprasController::class);
                Route::name('mail.index')->get('/mail', [Gmail\GmailController::class, 'index']);
                Route::name('mail.sends')->get('/mail/sends', [Gmail\GmailController::class, 'sends']);
                Route::name('mail.junks')->get('/mail/junks', [Gmail\GmailController::class, 'junks']);
                Route::name('mail.trash')->get('/mail/trash', [Gmail\GmailController::class, 'trash']);
                Route::name('mail.detail')->get('/mail/detail/{folder}/{id}', [Gmail\GmailController::class, 'detalle']);
                Route::name('mail.create')->get('/mail/create', function(){
                    return view('admin.mail.message');
                });
                Route::name('mail.send')->post('/mail/create', [Gmail\GmailController::class, 'enviar']);
                Route::name('config')->get('/configuration', [Controllers\ConfigController::class, 'index']);
                Route::name('config.update')->post('/configuration', [Controllers\ConfigController::class, 'update']);
            });
        
            Route::post('/cargar/file', [Extras\Extras::class, 'saveFiles']);
            Route::get('/vv/e/{video}', [Blog\BlogVideoController::class, 'show']);
            Route::get('/vv/c/{video}', [Cursos\CursosVideoController::class, 'show']);
            Route::name('compras.report')->get('/report/{compra}', [Controllers\ComprasController::class, 'generatePDF']);
            Route::post('/filetiny', [Extras\Extras::class, 'saveFilesTiny']);
            Route::put('/mail/favorite/{folder}/{id}', [Gmail\GmailController::class, 'favorite']);
            Route::put('/mail/trash/{folder}/{id}', [Gmail\GmailController::class, 'papelera']);
            Route::put('/mail/delete/{folder}/{id}', [Gmail\GmailController::class, 'eliminar']);
            Route::put('/mail/seen/{folder}/{id}', [Gmail\GmailController::class, 'seen']);
            Route::put('/mail/important/{folder}/{id}', [Gmail\GmailController::class, 'important']);
            Route::post('/mail/fordward/{folder}', [Gmail\GmailController::class, 'forward']);
            Route::post('/mail/reply/{folder}',  [Gmail\GmailController::class, 'reply']);
            Route::name('admin.notis.seen')->get('/admin/noti/seen', [Controllers\NotiController::class, 'seenNoti']);
            Route::name('admin.notis.seent')->post('/admin/noti/seent', [Controllers\NotiController::class, 'seenToast']);
            Route::name('admin.notis.index')->get('/admin/notifications', [Controllers\NotiController::class, 'index']);
        });
    }
}
