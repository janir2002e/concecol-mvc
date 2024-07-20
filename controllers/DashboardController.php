<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Automovil;
use Model\Usuario;
use MVC\Router;

class DashboardController
{
    public static function index(Router $router)
    {
        if(!is_admin()){
            header('Location: /');
        }

        $automoviles = Automovil::get(6);

        $router->render('admin/dashboard/index', [
            'titulo' => 'Panel de Administración', 
            'automoviles' => $automoviles
        ]);
    }

    public static function usuarios(Router $router){
        if(!is_admin()){
            header('Location: /');
        } 

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

         
        if(!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/usuarios?page=1');
        }

        $registros_por_pagina = 10;
        $total = Usuario::total('admin', 0);

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        if($paginacion->total_paginas() < $pagina_actual){
            header('Location: /admin/usuarios?page=1');
        }

        $usuarios = Usuario::paginar($registros_por_pagina, $paginacion->offset());

        $router->render('admin/dashboard/usuarios', [
            'titulo' => 'Usuarios',
            'usuarios' => $usuarios,
            'paginacion' => $paginacion->paginacion()
        ]);
    }
}
