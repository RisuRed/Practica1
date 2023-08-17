<?php
// Incluir el controlador de autenticación
//namespace Controllers;

namespace Controllers;

use Helpers\TokenHandler;
use Models\UserModel;



class UserController
{
    public static function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener y decodificar los datos JSON del cuerpo de la peticion
            $data = json_decode(file_get_contents("php://input"), true);
            // Verificar si los datos necesarios están presentes y no sean nulos
            if (isset($data['correo']) && isset($data['contrasena'])) {
                $correo = $data['correo'];
                $contrasena = $data['contrasena'];

                $tokenHandler = new TokenHandler();

                // Llamar al método Authenticate del controlador de autenticación
                $response = $tokenHandler->Authenticate($correo, $contrasena);

                // Establecer el código de respuesta HTTP en función de si hay un error o no
                http_response_code(isset($response['error']) ? 401 : 200);
                // Establecer la cabecera de respuesta en formato JSON
                header("Content-type: application/json; charset=UTF-8");
                http_response_code(200);
                $json_result = array("Message" => "Acceso exitoso", "Correo" => $correo, "token" => $response);
                // Imprimir la respuesta JSON
                echo json_encode($json_result);
            } else {
                // Si faltan datos de inicio de sesión, establecer código de respuesta 400
                http_response_code(400);
                echo json_encode(['error' => 'Datos de inicio de sesion incompletos']);
            }
        }
    }

    public static function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtener y decodificar los datos JSON del cuerpo de la petición
            $data = json_decode(file_get_contents("php://input"), true);

            // Verificar si los datos necesarios están presentes y no son nulos
            if (isset($data['nombre']) && isset($data['apellido']) && isset($data['correo']) && isset($data['contrasena']) && isset($data['rol'])) {
                $nombre = $data['nombre'];
                $apellido = $data['apellido'];
                $correo = $data['correo'];
                $contrasena = $data['contrasena'];
                $rol = $data['rol'];

                // Verificar si el correo ya está registrado en la base de datos
                $userModel = new UserModel();
                $isEmailTaken = $userModel->isEmailTaken($correo);

                if ($isEmailTaken) {
                    http_response_code(400);
                    echo json_encode(['error' => 'El correo ya esta registrado']);
                    return;
                } else {
                    // Hash de la contraseña antes de guardarla en la base de datos
                    $hashedPassword = password_hash($contrasena, PASSWORD_DEFAULT);

                    // Guardar los datos del usuario en la base de datos
                    $userModel->createUser($nombre, $apellido, $correo, $hashedPassword, $rol);

                    // Responder con un mensaje de éxito
                    http_response_code(201);
                    echo json_encode(['message' => 'Usuario creado exitosamente']);
                }
            } else {
                // Si faltan datos para crear el usuario, establecer código de respuesta 400
                http_response_code(400);
                echo json_encode(['error' => 'Datos incompletos para crear usuario']);
            }
        }
    }
}
