
<?php
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once '../Helpers/app.php';
    use lib\Route;

    //Route::post('/login', 'UserController@login');
    Route::post('/login', [UserController::class, 'login']);

    Route::dispatch();

 


    /*
    header('Content-Type: application/json');
    // Obtener el método de la solicitud (GET, POST) y la URI
    $request_method = $_SERVER['REQUEST_METHOD'];
    $request_uri = $_SERVER['REQUEST_URI'];

    // Definir la URL base de la API
    $base_url = 'http://localhost:8000';

    // Verificar si la solicitud es POST y la URI coincide con el endpoint esperado
    if ($request_method === 'POST' && $request_uri === $base_url . '/endpoints') {
        include 'endpoints/login.php';
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Endpoint no encontrado']);
    }
    */
?>


