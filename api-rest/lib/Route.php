<?php

namespace lib;
require_once __DIR__ . '/../Controllers/login.php';

class Route
{
    private static $routes = [];

    //los metodos guardan las rutas en el arreglo routes
    public static function get($uri, $callback)
    {
        self::$routes['GET'][$uri] = $callback;
        $callback();
    }

    public static function post($uri, $callback)
    {
        self::$routes['POST'][$uri] = $callback;
       /* $callbackParts = explode('@', $callback); // Divide la cadena en nombre de clase y nombre de método
        $class = $callbackParts[0];
        $method = $callbackParts[1];
        call_user_func([$class, $method]);*/
        $class = $callback[0];
        $method = $callback[1];
        $class::$method();
    }

    public static function put($uri, $callback)
    {
        self::$routes['PUT'][$uri] = $callback;
        $callback();
    }

    public static function delete($uri, $callback)
    {
        self::$routes['DELETE'][$uri] = $callback;
        $callback();
    }

    /**
     * Metodo para obtener la ruta a la cual esta accediendo el usuario.
     * @return void
     */
    public static function dispatch()
    {
        // Se obtiene la uri
        $uri = $_SERVER['REQUEST_URI'];
        // Se elimina el caracter '/' del principio y final de la uri
        $uri = trim($uri, '/');
        // Se obtiene el metodo
        $method = $_SERVER['REQUEST_METHOD'];
        // Recorremos el arreglo routes para encontrar la ruta que coincida con la uri y el method
        foreach (self::$routes[$method] as $route => $callback) {
            // Aqui tengo un problema ya que como tengo que acceder a la carpeta public para que se ejecute el index, ahora mis rutas no coinciden. Pero lo que voy a hacer es concatenar a la ruta public al inicio, asi no tendre problemas.
            // Variable especial para concatenar la ruta public al inicio
            $especial = 'public/' . $route;
            $especial = trim($especial, '/');
            // se usa una exprecion regular que la routa mas parametros coincida con cualquier uri que tenga parametros o si no tiene parametro que tambien funcione
            if (strpos($especial, ':') !== false) {
                // Se remplaza el parametro que este delante de : por una exprecion regular
                $especial = preg_replace('#:[a-zA-Z0-9]+#', '([a-zA-Z0-9]+)', $especial);
            }
            // Si la ruta coincide con la uri se ejecuta el callback
            if (preg_match("#^$especial$#", $uri, $matches)) {
                // Se crea un arreglo con los parametros que se le pasen en la url
                $params = array_slice($matches, 1);
                // Se llama al callback con los parametros como si fueran parametros separados
                // $response = $callback(...$params);
                // Verificamos si lo que estamos recibiendo en el callback es una funcion
                if (is_callable($callback)) {
                    // Se recibe la respuesta de la funcion
                    $response = $callback(...$params);
                }
                // Verificamos si lo que estamos recibiendo en el callback es un array
                if (is_array($callback)) {
                    // Creamos una instancia de la clase Controller que se esta mandando 
                    // Recordemos que en el arreglo que se manda la primera posicion es una clase y la segunda una funcion de dicha clase
                    $controller = new $callback[0]();
                    // Se llama la funcion y se guarda en una variable response
                    $response = $controller->{$callback[1]}(...$params);
                }
                // Verificamos si la respuesta es un objeto o un arreglo
                if (is_object($response) || is_array($response)) {
                    // Se agrega la cabecera de tipo json y la codificacion utf8
                    header("Content-type: application/json; charset=UTF-8");
                    // Se imprime el json
                    echo json_encode($response);
                    return;
                }
                echo $response;
                return;
            }
        }
        // Se agrega la cabecera de tipo json y la codificacion utf8
        header("Content-type: application/json; charset=UTF-8");
        // Si no se encuentra la ruta se manda un error 404
        http_response_code(404);
        // Se crea un json con el error 404 y un mensaje de error
        $json = json_encode([
            "code" => "404",
            "message" => "Page not found",
        ]);
        // Se imprime el json
        echo $json;
    }
}