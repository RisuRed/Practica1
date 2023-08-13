<?php
// Incluir el controlador de autenticación
//namespace Controllers;
require_once __DIR__.'/../vendor/autoload.php';
require_once '../Helpers/token.php';
//use TokenHandler;


class UserController{
    public static function login(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtener y decodificar los datos JSON del cuerpo de la peticion
        $data = json_decode(file_get_contents("php://input"), true);
        // Verificar si los datos necesarios están presentes y no sean nulos
        if (isset($data['username']) && isset($data['password'])) {
            $username = $data['username'];
            $password = $data['password'];

            $tokenHandler = new TokenHandler();
            
            // Llamar al método login() del controlador de autenticación
             $response = $tokenHandler->Authenticate($username, $password);
            // Establecer el código de respuesta HTTP en función de si hay un error o no
            http_response_code(isset($response['error']) ? 401 : 200);

            // Establecer la cabecera de respuesta en formato JSON
            header("Content-type: application/json; charset=UTF-8");
            http_response_code(200);
            $json_result = array("Message" => "Acceso exitoso", "username" => $username, "token" => $response);
            // Imprimir la respuesta JSON
            echo json_encode($json_result);
        } else {
            // Si faltan datos de inicio de sesión, establecer código de respuesta 400
            http_response_code(400);
            echo json_encode(['error' => 'Datos de inicio de sesion incompletos']);
        }
    }
    }
}
