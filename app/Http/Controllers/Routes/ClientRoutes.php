<?php

namespace Code\Http\Controllers\Routes;

use Code\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Code\Http\Controllers\Controller;
use Code\Http\Controllers\Blog;
use Laravel\Socialite\Facades\Socialite;

class ClientRoutes extends Controller
{
    public static function routes()
    {
        Route::middleware(['web', 'auth', 'cliente:cliente'])->group(function () {
            Route::name('checkappro')->get('/checkout-approve/{id}', [Controllers\WebController::class, 'checkAprove']);
            Route::name('checkdown')->get('/checkout-confirmation/{id}', [Controllers\WebController::class, 'checkDownload']);
            Route::name('addValoracion')->post('/nueva-valoracion', [Controllers\WebController::class, 'addValoration']);
        });

        Route::name('index')->get('/', [Controllers\WebController::class, 'index']);
        Route::name('posts')->get('/category/{categoria}', [Controllers\WebController::class, 'posts']);
        Route::name('contact')->get('/contacto',[Controllers\WebController::class, 'contact']);
        Route::name('contact.mail')->post('/contacto/mail',[Controllers\WebController::class, 'sendContact']);
        Route::name('cursos')->get('/cursos',[Controllers\WebController::class, 'courses']);
        Route::name('productos')->get('/productos',[Controllers\WebController::class, 'products']);
        //Autentication Socialite
        Route::name('auth.google')->get('/oauth/google', function () {return Socialite::driver('google')->redirect();});
        Route::get('/oauth/google_callback', [Controllers\OauthController::class, 'callbackGoogle']);
        Route::name('auth.github')->get('/oauth/github', function () {return Socialite::driver('github')->redirect();});
        Route::get('/oauth/github_callback', [Controllers\OauthController::class, 'callbackGithub']);
        Route::name('auth.gitlab')->get('/oauth/gitlab', function () {return Socialite::driver('gitlab')->redirect();});
        Route::get('/oauth/gitlab_callback', [Controllers\OauthController::class, 'callbackGitlab']);
        Route::name('auth.facebook')->get('/oauth/facebook', function () {return Socialite::driver('facebook')->redirect();});
        Route::get('/oauth/facebook_callback', [Controllers\OauthController::class, 'callbackFacebook']);
        Route::get('/email-verification', [Controllers\WebController::class, 'verificateRender']);
        Route::name('verification')->post('/email-verificate', [Controllers\WebController::class, 'verificateUser']);
        //Other
        Route::name('paypal')->post('/paypal-transact', [Controllers\WebController::class, 'payPalRequest']);
        Route::name('terms')->get('/terminos-y-condiciones', function () {return view('web.terminos');});
        Route::name('priv')->get('/politica-de-privacidad', function () {return view('web.privacidad');});
        Route::name('cook')->get('/politica-de-cookies', function () {return view('web.cookies');});
        Route::name('shop.detail')->get('/product/{sku}', [Controllers\WebController::class, 'showproduct']);
        Route::name('posts.detail')->get('/{slug}', [Controllers\WebController::class, 'showpost']);
        Route::get('/ve/embed/{video}', [Blog\BlogVideoController::class, 'show']);
    }
}
