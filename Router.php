<?php

namespace MVC;

class Router
{
    public array $getRoutes = [];
    public array $postRoutes = [];

    public function get($url, $fn)
    {
       //creamos un arreglo donde la llave que es la url y tiene como valor el nombre de la funcion
        $this->getRoutes[$url] = $fn;
    }

    public function post($url, $fn)
    {
        $this->postRoutes[$url] = $fn;
    }

    public function comprobarRutas()
    {

        //$url_actual = $_SERVER['PATH_INFO'] ?? '/';
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {
            // obtenemos el valor del arreglo que tiene la url actual que leemos
            $fn = $this->getRoutes[$url_actual] ?? null;
        } else {
            $fn = $this->postRoutes[$url_actual] ?? null;
        }

        if ( $fn ) {
            // idenficamos si al crear una funcion esta definida o es valida y mandamos a llamar todas las rutas con this
            call_user_func($fn, $this);
        } else {
           header('Location: /404');
        }
    }

    public function render($view, $datos = [])
    {
        foreach ($datos as $key => $value) {
            $$key = $value; 
        }

        ob_start(); //iniciar un almacenamiento en memoria ej la vista

        include_once __DIR__ . "/views/$view.php";

        $contenido = ob_get_clean(); // Limpia el Buffer y le asignamos el contenido de la vista a la variable

        // Utilizar el layout de acuerdo a la URL
        $url_actual = strtok($_SERVER['REQUEST_URI'], '?') ?? '/';

        // dependiendo la condición el contenido de la vista utiliza admin-layout o loyaut
        if(str_contains($url_actual, '/admin')){
            include_once __DIR__ . '/views/admin-layout.php';
        }else{
            include_once __DIR__ . '/views/layout.php';
        }

    }
}
