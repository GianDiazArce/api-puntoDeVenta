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
    return view('welcome');
});
/*
Route::resource('api/tipo', 'TipoController');
Route::resource('api/marca', 'MarcaController');
Route::get('api/marca/tipo/{id}', 'MarcaController@getMarcasByTipo');

Route::resource('api/talla', 'TallaController');

Route::resource('api/modelo', 'ModeloController');
Route::get('api/modelo/marca/{id}','ModeloController@getModeloByMarca');

Route::resource('api/venta', 'VentaController');
Route::post('api/login', 'UserController@login');
Route::post('api/register', 'UserController@register');
Route::post('api/user/update', 'UserController@update');

Route::resource('api/detalle-venta', 'DetalleVentaController');
Route::get('api/detalle-venta/venta/{id}', 'DetalleVentaController@detalleVenta');*/