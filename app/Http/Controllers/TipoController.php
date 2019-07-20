<?php

namespace App\Http\Controllers;

use App\Tipo;
use Illuminate\Http\Request;

class TipoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipos = Tipo::all();

        $data = [
            'code' => 200,
            'status' => 'success',
            'tipos' => $tipos
        ];

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $json = $request->input('json');
        $params_array = json_decode($json,true);

        if(!empty($params_array)){
            $validate = \Validator::make($params_array, [
                'name' => 'required'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'error' => $validate->errors()
                ];
            } else {

                $tipo = new Tipo();
                $tipo->name = $params_array['name'];

                $tipo->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'tipo' => $tipo
                ];

            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontraron datos'
            ];
        }

        return response()->json($data, $data['code']);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $tipo = Tipo::find($id);
        
        if(is_null($tipo)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No existe el tipo que busca'
                
            ];
        } else {

            $data = [
                'code' => 200,
                'status' => 'success',
                'tipo' => $tipo
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function edit(Tipo $tipo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(!is_null(Tipo::find($id))){
            $json = $request->input('json');
            $params_array = json_decode($json, true);

            if(!empty($params_array)){
                $validate = \Validator::make($params_array, [
                    'name' => 'required'
                ]);
    
                if($validate->fails()){
                    $data = [
                        'code' => 400,
                        'status' => 'error',
                        'error' => $validate->errors()
                    ];
                } else {
                    $tipo = Tipo::find($id);

                    $tipo->update($params_array);

                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'tipo' => $tipo,
                        'changes' => $params_array
                    ];
                }
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se encontraron datos'
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontro el tipo que busca'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tipo  $tipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(/* Tipo $tipo */$id){
        $tipo = Tipo::find($id);

        if(is_null($tipo)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontro el tipo que busca'
            ];
        } else {

            $tipo->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => "El tipo fue eliminado correctamente",
                'tipo' => $tipo
            ];
        }
        return response()->json($data, $data['code']);
    }

    
}
