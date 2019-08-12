<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class UserController extends Controller
{
    public function register(Request $request){
        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        if(!empty($params) && !empty($params_array)){
            // Limpiar datos
            $params_array = array_map('trim', $params_array);

            $validate = \Validator::make($params_array, [
                'name' => 'required',
                'username' => 'required',
                'password' => 'required'
            ]);
            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                // Cifrar Contraseña
                $pwd = hash('sha256', $params->password);
                $user = new User();
                $user->name = $params_array['name'];
                $user->username = $params_array['username'];
                $user->password = $pwd;
                $user->role = "ROLE_USER";

                $user->save();

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'user' => $user
                ];
            }
            
            
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error faltan datos...'
            ];
        }
        return response()->json($data, $data['code']);
    }

    public function login(Request $request){
        $jwtAuth = new \JwtAuth();

        $json = $request->input('json', null);
        $params = json_decode($json);
        $params_array = json_decode($json, true);

        $validate = \Validator::make($params_array, [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validate->fails()){
            $signup = [
                'code' => 400,
                'status' => 'error',
                'message' => $validate->errors()
            ];
        } else {
            $pwd = hash('sha256', $params->password);

            $signup = $jwtAuth->signup($params->username, $pwd);
            if(!empty($params->gettoken)){
                $signup = $jwtAuth->signup($params->username, $pwd, true);
            }
        }
        return response()->json($signup, 200);
    }

    public function update(Request $request){
        $token = $request->header('Authorization');
        $jwtAuth = new \JwtAuth();
        $checkToken = $jwtAuth->checkToken($token);


        $json = $request->input('json', null);
        $params_array = json_decode($json, true);
        if($checkToken && !empty($params_array)){
            
            
            $user = $jwtAuth->checkToken($token, true);
            $validate = \Validator::make($params_array, [
                'name' => 'required',
                'username' => 'required|unique:users,username,'.$user->sub
            ]);
            if($validate->fails()){
                $data = [
                    'code' => 400,
                    'status' => 'error',
                    'message' => $validate->errors()
                ];
            } else {
                // Quitar los campos que no quiero actualizar
                unset($params_array['id']);
                unset($params_array['created_at']);
                unset($params_array['password']);
                unset($params_array['remember_token']);

                // Actualizar usuario en bbdd
                $user_update = User::where('id', $user->sub)->update($params_array);

                $data = [
                    'code' => 200,
                    'status' => 'success',
                    'user' => $user_update,
                    'changes' => $params_array
                ];
            }
           
        } else {
            $data = [
                'code' => 400,
                'status' => 'error',
                'message' => 'Error al actualizar, vuelva a intentarlo'
            ];
        }

        return response()->json($data, $data['code']);
    }
}
