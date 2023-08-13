<?php

require_once __DIR__ . '/../vendor/autoload.php';  // Cargar la biblioteca JWT

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
        $this->secret_key = $_ENV['SECRET_PRIVATE_KEY'];
    }

    public function Authenticate($username, $password) {
      // Verificar las credenciales (cambiar esto por una consulta a la base de datos)
      if ($username === 'usuario' && $password === 'contrasena') {
          $playload = [
            'username' => $username
          ];
          return $this->tokenEncode($playload);
          
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


    public function tokenDecode($jwt_token){
      try {
        $decode = JWT::decode($jwt_token, $this->secret_key, array('HS256'));
      }catch(Exception $e){
        return $e->getMessage();
      }
        
    }
    
}