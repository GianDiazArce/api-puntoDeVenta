<?php

namespace App\Http\Controllers;

use App\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $marcas = Marca::all();

        $data = [
            'code' => 200,
            'status' => 'success',
            'marcas' => $marcas
        ];

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
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
                'name' => 'required'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'error' => $validate->errors()
                ];
            } else {
                
                $marca = new Marca();
                $marca->name = $params_array['name'];

                $marca->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'marca' => $marca
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $marca = Marca::find($id);

        if(is_null($marca)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontro la marca que busca'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'marca' => $marca
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(!is_null(Marca::find($id))){
            $json = $request->input('json');
            $params_array = json_decode($json, true);

            if(!empty($params_array)){
                $validate = \Validator::make($params_array,[
                    'name' => 'required'
                ]);

                if($validate->fails()){
                    $data = [
                        'code' => 400,
                        'status' => 'error',
                        'error' => $validate->errors()
                    ];
                } else {
                    unset($params_array['id']);
                    unset($params_array['created_at']);
                    
                    $marca = Marca::find($id);

                    $marca->update($params_array);

                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'marca' => $marca,
                        'changes' => $params_array
                    ];
                }

            }else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se encontro datos'
                ];
            }
            

            
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontro la marca que busca'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $marca = Marca::find($id);


        if(is_null($marca)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'No se encontro la marca que busca'
            ];
        } else {

            $marca->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'La marca fue eliminada correctamente',
                'marca' => $marca
            ];
        }

        return response()->json($data, $data['code']);
    }
}
