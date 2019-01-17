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




Route::get('/{nombre_obra?}', 'IndexController@show');
Route::post('recarga_calendario', 'IndexController@recargaCalendario');
Route::post('carga_sesiones', 'IndexController@cargaSesiones');
Route::post('carga_salon', 'IndexController@cargaSalon');
Route::post('bloquear', 'IndexController@bloquear');
