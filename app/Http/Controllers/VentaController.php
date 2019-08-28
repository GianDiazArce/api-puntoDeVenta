<?php

namespace App\Http\Controllers;

use App\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function __construct(){
        $this->middleware('api.auth', ['except' => ['index', 'show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $ventas = Venta::all()->load('user');

        $data = [
            'code' => 200,
            'status' => 'success',
            'ventas' => $ventas
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
                'user_id' => 'required|numeric',
                'total' => 'required|numeric',
                'discount' => 'nullable',
                'status' => 'nullable|alpha'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                $venta = new Venta();
                $venta->user_id = $params_array['user_id'];
                $venta->total = $params_array['total'];
                $venta->discount = $params_array['discount'];
                $venta->status = $params_array['status'];
                $venta->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'venta' => $venta
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
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $venta = Venta::find($id);

        if(is_null($venta)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No existe la venta que busca'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'venta' => $venta
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(is_null(Venta::find($id)) ) {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No existe la venta que busca actualizar'
            ];
        } else {
            $json = $request->input('json');
            $params_array = json_decode($json, true);

            if(!empty($params_array)){
                $validate = \Validator::make($params_array, [
                    'user_id' => 'required|numeric',
                    'total' => 'required|numeric',
                    'discount' => 'nullable',
                    'status' => 'nullable|alpha'
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

                    $venta = Venta::find($id);
                    $venta->update($params_array);

                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'venta' => $venta,
                        'changes' => $params_array
                    ];
                }
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'Faltan datos'
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $venta = Venta::find($id);

        if(is_null($venta)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No existe la venta que busca eliminar'
            ];
        } else {
            $venta->delete();
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'Fue eliminada la venta'
            ];
        }

        return response()->json($data, $data['code']);
    }

    public function getSaleByMonth($month){

        $ventas = Venta::whereMonth('created_at', $month)->get()->load('user');

        $data = [
            'code' => 200,
            'status' => 'success',
            'ventas' => $ventas
        ];


        return response()->json($data, $data['code']);
    }

    public function getSaleByYearAndMonth($month, $year){
        $ventas = Venta::whereYear('created_at', $year)->whereMonth('created_at', $month)->get()->load('user');

        $data = [
            'code' => 200,
            'status' => 'success',
            'ventas' => $ventas
        ];

        return response()->json($data, $data['code']);
    }
    public function getSaleByYear($year){
        $ventas = Venta::whereYear('created_at', $year)->get()->load('user');

        $data = [
            'code' => 200,
            'status' => 'success',
            'ventas' => $ventas
        ];

        return response()->json($data, $data['code']);
    }
}
