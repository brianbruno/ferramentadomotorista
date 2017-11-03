<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('inicio');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::resource('clientes','ClienteController');

Route::resource('usuarios','UsuariosController');

Route::get('/usuarios/{user_id?}',function($user_id){
    $usuarios = \App\Cliente::find($user_id);
    return Response::json($usuarios);
});

