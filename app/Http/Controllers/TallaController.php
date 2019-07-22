<?php

namespace App\Http\Controllers;

use App\Talla;
use Illuminate\Http\Request;

class TallaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $tallas = Talla::all();

        
        $data = [
            'code' => 200,
            'status' => 'success',
            'tallas' => $tallas
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
                'name' => 'required'
            ]);

            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                $talla = new Talla();
                $talla->name = $params_array['name'];

                $talla->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'talla' => $talla
                ];
            }
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No ha enviado ningun nombre, vuelva a intentar'
            ];
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Talla  $talla
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        $talla = Talla::find($id);

        if(is_null($talla)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Esa talla no existe o fue eliminada'
            ];
        } else {
            $data = [
                'code' => 200,
                'status' => 'success',
                'talla' => $talla
            ]; 
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Talla  $talla
     * @return \Illuminate\Http\Response
     */
    public function edit(Talla $talla){
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Talla  $talla
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        if(is_null(Talla::find($id))){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encontró la talla que quiere actualizar... '
            ];
        } else {
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
                        'message' => $validate->errors()
                    ];
                } else {
                    $talla = Talla::find($id);

                    if(!is_null($talla)){
                        unset($params_array['id']);
                        unset($params_array['created_at']);
                        $talla->update($params_array);

                        $data = [
                            'code' => 200,
                            'status' => 'success',
                            'talla' => $talla,
                            'changes' => $params_array
                        ];
                    } else {                        

                        $data = [
                            'code' => 500,
                            'status' => 'error',
                            'message' => 'No se encuentra'
                        ];
                    }
                }
            } else {
                $data = [
                    'code' => 500,
                    'status' => 'error',
                    'message' => 'No se encuentra datos'
                ];
            }
        }

        return response()->json($data, $data['code']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Talla  $talla
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $talla = Talla::find($id);

        if(is_null($talla)){
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'No se encuentra la talla que busca'
            ];
        } else {
            
            $talla->delete();

            $data = [
                'code' => 200,
                'status' => 'success',
                'talla' => $talla,
                'message' => 'La talla fue eliminada correctamente'
            ];
        }
        return response()->json($data, $data['code']);
    }
}
