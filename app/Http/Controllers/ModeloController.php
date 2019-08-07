<?php

namespace App\Http\Controllers;

use App\Modelo;
use Illuminate\Http\Request;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $modelos = Modelo::orderBy('name', 'asc')->get()->load('talla', 'marca', 'tipo');

        $data = [
            'code' => 200,
            'status' => 'success',
            'modelos' => $modelos
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
                'tipo_id' => 'required|numeric',
                'marca_id' => 'required|numeric',
                'talla_id' => 'required|numeric',
                'name' => 'required',
                'stock' => 'nullable'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                $modelo = new Modelo();
                $modelo->tipo_id = $params_array['tipo_id'];
                $modelo->marca_id = $params_array['marca_id'];
                $modelo->talla_id = $params_array['talla_id'];
                $modelo->name = $params_array['name'];
                $modelo->stock = $params_array['stock'];

                $modelo->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'modelo' => $modelo
                ];

            }
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'No se encontraron datos'
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $modelo = Modelo::find($id);

        if(is_null($modelo)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'No se encontro el modelo que busca'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'modelo' => $modelo
            ];
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(is_null(Modelo::find($id))){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontro el modelo que busca'
            ];
        } else {
            $json = $request->input('json', null);
            $params_array = json_decode($json, true);

            if(!empty($params_array)){
                $validate = \Validator::make($params_array, [
                    'tipo_id' => 'required|numeric',
                    'marca_id' => 'required|numeric',
                    'talla_id' => 'required|numeric',
                    'name' => 'required',
                    'stock' => 'nullable'
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
    
                    $modelo = Modelo::find($id);
                    
                    $modelo->update($params_array);
    
                    $data = [
                        'code' => 200,
                        'status' => 'success',
                        'modelo' => $modelo,
                        'changes' => $params_array
                    ];
                }
            } else {
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => 'No se encontraron datos...'
                ];
            }            
        }
        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $modelo = Modelo::find($id);

        if(is_null($modelo)){
            $data = [
                'code' => 200,
                'status' => 'success',
                'message' => 'El modelo que quiere eliminar no existe... vuelva a intentarlo'
            ];
        } else {

            $modelo->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'modelo' => $modelo,
                'message' => 'El modelo ha sido eliminado correctamente'
            ];
        }

        

        return response()->json($data, $data['code']);
    }


    
    /**
     * Display the specified resource.
     *
     * @param  \App\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function getModeloByTipoAndMarca($tipo_id, $marca_id){
        $modelos = Modelo::where('tipo_id', $tipo_id)->where('marca_id', $marca_id)->get()->load('talla');

        $data = [
            'code' => 200,
            'status' => 'success',
            'modelos' => $modelos
        ];

        return response()->json($data, $data['code']);
    }
}
