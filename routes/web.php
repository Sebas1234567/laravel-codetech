<?php

use Illuminate\Support\Facades\Route;
use Code\Http\Controllers;
use Illuminate\Http\Request;
use Code\Http\Controllers\Routes\AdminRoutes;
use Code\Http\Controllers\Routes\AuthRoutes;
use Code\Http\Controllers\Routes\ClientRoutes;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

AdminRoutes::routes();

AuthRoutes::routes();

ClientRoutes::routes();

Route::get('/home', [Controllers\Extras\HomeController::class, 'index'])->name('home');

Route::get('/pdf-viewer', function(){
    return view('pdfviewer');
});

