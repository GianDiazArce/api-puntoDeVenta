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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tipo', 'TipoController');
Route::resource('marca', 'MarcaController');
Route::get('modelo/tipo/{id}', 'MarcaController@getModelosByTipoWithMarca');


Route::resource('talla', 'TallaController');

Route::resource('modelo', 'ModeloController');
Route::get('talla/modelo/{id}', 'ModeloController@getTallasByModelo');
Route::get('modelo/{tipo_id}/{marca_id}', 'ModeloController@getModeloByTipoAndMarca');

Route::resource('venta', 'VentaController');


Route::resource('detalle-venta', 'DetalleVentaController');
Route::get('detalle-venta/venta/{id}','DetalleVentaController@detalleVenta');