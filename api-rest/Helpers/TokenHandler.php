<?php
namespace Helpers;
require_once __DIR__ . '/../vendor/autoload.php';
use Models\UserModel;
use Firebase\JWT\JWT;

class TokenHandler {
    protected $secret_key;
    protected $iat;
    protected $expire;
    protected $jwToken;
    protected $token;

    public function __construct()
    {
        $this->iat = time();
        $this->expire = $this->iat + (3600 * 8 );
        $envVars = parse_ini_file("../.ENV");
        $this->secret_key = $envVars['SECRET_PRIVATE_KEY'];
    }

    public function Authenticate($correo, $contrasena) {
      // Utiliza el modelo UserModel para verificar las credenciales
      $userModel = new UserModel();
      // Verificar las credenciales (cambiar esto por una consulta a la base de datos)
      $isValidCredentials = $userModel->verifyCredentials($correo, $contrasena);
      
      if ($isValidCredentials) {
          $playload = [
            'correo' => $correo
          ];
          $token=$this->tokenEncode($playload);
          return $token;
                    
      } else {
          http_response_code(401);
          return ['error' => 'Credenciales invalidas'];
      }
  }

    //data = playload
    public function tokenEncode($data){
        $this->token = array(
            "iat" => $this->iat,
            "exp"=> $this->expire,
            "data" => $data
        );
       return $this->jwToken = JWT::encode($this->token, $this->secret_key, 'HS256');
    }


    // public function tokenDecode($jwt_token){
    //   try {
    //     //$decode = JWT::decode($jwt_token, $this->secret_key, array('HS256'));
    //   }catch(Exception $e){
    //     return $e->getMessage();
    //   }
        
    // }
    
}