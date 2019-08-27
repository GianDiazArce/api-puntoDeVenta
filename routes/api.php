<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware('auth:api')->get('/user', 'UserController@AuthRouteAPI');
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::resource('tipo', 'TipoController');
Route::resource('marca', 'MarcaController');
Route::get('marca/tipo/{id}', 'MarcaController@getMarcasByTipo');

Route::resource('talla', 'TallaController');

Route::resource('modelo', 'ModeloController');
Route::get('modelo/marca/{id}','ModeloController@getModeloByMarca');

Route::resource('venta', 'VentaController');
Route::get('venta/mes/{mes}', 'VentaController@getSaleByMonth');
Route::get('venta/year/{year}', 'VentaController@getSaleByYear');
Route::get('venta/{month}/{year}', 'VentaController@getSaleByYearAndMonth');


Route::post('login', 'UserController@login');
Route::post('register', 'UserController@register');
Route::post('user/update', 'UserController@update');
Route::get('user/{id}', 'UserController@getUser');

Route::resource('detalle-venta', 'DetalleVentaController');
Route::get('detalle-venta/venta/{id}', 'DetalleVentaController@detalleVenta');