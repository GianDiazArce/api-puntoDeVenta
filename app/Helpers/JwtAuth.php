<?php
namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth{

    public $key;

    public function __construct() {
        $this->key = 'esto_es_una_clave_super_secreta-123456';
    }

    public function signup($username, $password, $getToken = null){
        // Buscar si existe el usuario con sus credenciales
        $user = User::where([
            'username' => $username,
            'password' => $password
        ])->first();

        // Comprobar si son correctas (Objeto)
        $signup = false;
        if(is_object($user)){
            $signup = true;
        }
        // Generar el token con los datos del usuario identificado
        if($signup){
            $token = array(
                'sub'       => $user->id,
                'username'  => $user->username,
                'name'      => $user->name,
                'role'      => $user->role,
                'iat'       => time(),
                'exp'       => time() + (30 * 24 * 60 * 60)
            );

            $jwt = JWT::encode($token, $this->key, 'HS256');
            $decode = JWT::decode($jwt, $this->key, ['HS256']);
            // Devolver los datos decodificados o el token, en funcion de un parametro
            if(is_null($getToken)){
                $data = $jwt;
            } else {
                $data = $decode;
            }
        } else {
            $data = [
                'status' => 'error',
                'message' => 'Login incorrecto'
            ];
        }
        return $data;
    }

    public function checkToken($jwt, $getIdentity = false){
        $auth = false;

        try{
            $jwt = str_replace('"', '', $jwt);
            $decoded = JWT::decode($jwt, $this->key, ['HS256']);
        } catch(\UnexpectedValueException $e){
            $auth = false;
        } catch(\DomainException $e){
            $auth = false;
        }

        if(!empty($decoded) && is_object($decoded) && isset($decoded->sub)){
            $auth = true;
        } else {
            $auth = false;
        }

        if($getIdentity){
            return $decoded;
        }

        return $auth;
    }
    
}