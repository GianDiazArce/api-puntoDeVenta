<?php

namespace App\Http\Controllers;

use App\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DetalleVentaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $detalleVentas = DetalleVenta::all();

        $data = [
            'code' => 200,
            'status' => 'success',
            'detalleVentas' => $detalleVentas
        ];

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $json = $request->input('json');
        $params_array = json_decode($json, true);

        if(!empty($params_array)){

            $validate = \Validator::make($params_array, [
                'venta_id' => 'required|numeric',
                'modelo_id' => 'required|numeric',
                'quantity' => 'required|numeric',
                'price' => 'numeric'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                $detalleVenta = new DetalleVenta();
                $detalleVenta->venta_id = $params_array['venta_id'];
                $detalleVenta->modelo_id = $params_array['modelo_id'];
                $detalleVenta->quantity = $params_array['quantity'];
                $detalleVenta->price = $params_array['price'];
                $detalleVenta->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'detalleVenta' => $detalleVenta
                ];
            }

        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Faltan datos'
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $detalleVenta = DetalleVenta::find($id);

        if(is_null($detalleVenta)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encuentra el detalle de venta que busca'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'detalleVenta' => $detalleVenta
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function edit(DetalleVenta $detalleVenta){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(is_null(DetalleVenta::find($id))){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encuentra el detalle de venta que busca'
            ];
        } else {
            $json = $request->input('json');
            $params_array = json_decode($json, true);

            if(!empty($params_array)){
                $validate = \Validator::make($params_array, [
                    'venta_id' => 'required|numeric',
                    'modelo_id' => 'required|numeric',
                    'quantity' => 'required|numeric',
                    'price' => 'numeric'
                ]);
    
                if($validate->fails()){
                    $data = [
                        'code' => 400,
                        'status' => 'error',
                        'message' => $validate->errors()
                    ];
                } else {
                    unset($params_array['id']);
                    unset($params_array['created_at']);

                    $detalleVenta = DetalleVenta::find($id);
                    $detalleVenta->update($params_array);

                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'detalleVenta' => $params_array
                    ];
                }
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Faltan datos...'
                ];
            }
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DetalleVenta  $detalleVenta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $detalleVenta = DetalleVenta::find($id);

        if(is_null($detalleVenta)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encuentra el detalle de venta que busca'
            ];
        } else {
            $detalleVenta->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'El detalle de venta fue eliminado correctamente'
            ];
        }
        return response()->json($data, $data['code']);
    }    
    public function detalleVenta($id){
        $detalleVentas = DetalleVenta::where('venta_id', $id)->get()->load('modelo');

        if(!is_null($detalleVentas)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'detalleVentas' => $detalleVentas
            ];
        } else {
            $data = [
                'code' => 404,
                'status' => 'error',
                'message' => 'No se encuentra lo que busca'
            ];
        }

        return response()->json($data, $data['code']);
    }
}
