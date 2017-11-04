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

use App\Http\Controllers\UsuariosController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/inicio', function () {
    return view('inicio');
});

Route::resource('clientes','ClienteController');

/*Route::resource('usuarios','UsuariosController');

Route::get('/usuarios/',function(){
    // Run controller and method
    $app = app();
    $controller = $app->make('\App\Http\Controllers\UsuariosController');
    return $controller->index();
});*/

Route::get('/usuarios/{user_id}/{returnType?}',function($user_id, $returnType = 'view'){
    // Run controller and method
    $app = app();
    $controller = $app->make('\App\Http\Controllers\UsuariosController');
    return $controller->show($user_id, $returnType);
})->name('usuarios.show');

Route::get('/usuarios/{returnType?}',function($returnType = 'view'){
    // Run controller and method
    $app = app();
    $controller = $app->make('\App\Http\Controllers\UsuariosController');
    return $controller->index($returnType);
})->name('usuarios.index');

