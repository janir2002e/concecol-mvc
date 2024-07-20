<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Automovil;
use Model\Marca;
use MVC\Router;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager as Image;


class AutomovilesController
{

    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /');
        }

        
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
       
        if(!$pagina_actual || $pagina_actual < 1){
            header('Location: /admin/automoviles?page=1');
        }

        $registros_por_pagina = 8;
        $total = Automovil::total();
        
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        // redireccionar si el total de paginas es menor a la pagina actual
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/automoviles?page=1');
        }

        $automoviles = Automovil::paginar($registros_por_pagina, $paginacion->offset());

        foreach ($automoviles as $key => $automovil) {
            $objeto = $automovil->getStdClass();

            // creamos una nueva propiedad y le asignamos el resultado de la consulta
            $objeto->nomMarca = Marca::find($objeto->marcaid);

            // agregamos el nuevo objeto al antiguo
            $automoviles[$key] = $objeto;
        }


        $router->render('admin/automoviles/index', [
            'titulo' => 'Automovíles',
            'automoviles' => $automoviles,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {

        $alertas = [];

        $marcas = Marca::all('ASC');

        if (!is_admin()) {
            header('Location: /');
        }

        $automovil = new Automovil;

        //debuguear($automoviles);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_admin()) {
                header('Location: /');
            }

            $carpeta_imagenes = '../public/img/automoviles';

            if (!is_dir($carpeta_imagenes)) {
                mkdir($carpeta_imagenes, 0755, true);
            }

            if (!empty($_FILES['fotouno']['tmp_name'])) {
                $manager = new Image(Driver::class);
                $imagen_png = $manager->read($_FILES['fotouno']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $imagen_webp = $manager->read($_FILES['fotouno']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen = crearNombreImagen();
                $_POST['fotouno'] = $nombre_imagen;
            }

            if (!empty($_FILES['fotodos']['tmp_name'])) {
                $manager = new Image(Driver::class);
                $imagen_png_2 = $manager->read($_FILES['fotodos']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $imagen_webp_2 = $manager->read($_FILES['fotodos']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen_2 = crearNombreImagen();
                $_POST['fotodos'] = $nombre_imagen_2;
            }

            $automovil->sincronizar($_POST);

            //debuguear($automovil);
            $alertas = $automovil->validarAuto();

            

            if (empty($alertas)) {
                // guardar imagenes
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                $imagen_png_2->save($carpeta_imagenes . '/' . $nombre_imagen_2 . ".png");
                $imagen_webp_2->save($carpeta_imagenes . '/' . $nombre_imagen_2 . ".webp");

                $Exitemarca = Marca::find($_POST['marcaid']);

                if(!$Exitemarca){
                    header('Location: /admin/automoviles');
                }

                $resultado = $automovil->guardar($automovil->id);

                if ($resultado) {
                    header('Location: /admin/automoviles');
                }
            }
        }

        $router->render('admin/automoviles/crear', [
            'titulo' => 'Crear Automóvil',
            'alertas' => $alertas,
            'marcas' => $marcas,
            'automovil' => $automovil
        ]);
    }


    public static function editar(Router $router)
    {
        $alertas = [];

        $id = $_GET['id'];
        $idV = filter_var($id, FILTER_VALIDATE_INT);

        if (!is_admin()) {
            header('location: /');
        }

        if (!$idV) {
            header('location: /admin/automoviles');
        }

        $automovil = Automovil::find($idV);

        if (!isset($automovil)) {
            header('Location: /admin/automoviles');
        }

        $marcas = Marca::all('ASC');

        // crear clase abstracta para crear propiedades dinamicas

        $automovilStd = $automovil->getStdClass();

        $automovilStd->imagen_actual_1 = $automovilStd->fotouno;
        $automovilStd->imagen_actual_2 = $automovilStd->fotodos;

        $carpeta_imagenes = '../public/img/automoviles';

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!is_admin()){
                header('Location: /');
            }

            $manager = new Image(Driver::class);     

            if(!empty($_FILES['fotouno']['tmp_name'])) {
                Automovil::borrarImagen($carpeta_imagenes, $automovilStd->imagen_actual_1, 'png');
                Automovil::borrarImagen($carpeta_imagenes, $automovilStd->imagen_actual_1, 'webp');
                
                $imagen_png_1 = $manager->read($_FILES['fotouno']['tmp_name'])->cover(1600, 1200)->encode(new WebpEncoder(quality: 65));
                $imagen_webp_1 = $manager->read($_FILES['fotouno']['tmp_name'])->cover(1600, 1200)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['fotouno'] = $nombre_imagen;
            } else {
                $_POST['fotouno'] = $automovilStd->imagen_actual_1;
            }

            if(!empty($_FILES['fotodos']['tmp_name'])) {
                Automovil::borrarImagen($carpeta_imagenes, $automovilStd->imagen_actual_2, 'png');
                Automovil::borrarImagen($carpeta_imagenes, $automovilStd->imagen_actual_2, 'webp');

                $imagen_png_2 = $manager->read($_FILES['fotodos']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $imagen_webp_2 = $manager->read($_FILES['fotodos']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen_2 = md5(uniqid(rand(), true));
                $_POST['fotodos'] = $nombre_imagen_2;
            } else {
                $_POST['fotodos'] = $automovilStd->imagen_actual_2;
            }

            $id_marca = filter_var($_POST['marcaid'], FILTER_VALIDATE_INT);

            if(!$id_marca){
                header('Location: /');
            }

            $Exitemarca = Marca::find($_POST['marcaid']);

            if(!$Exitemarca){
                header('Location: /admin/automoviles');
            }

            $automovil->sincronizar($_POST);

            $alertas = $automovil->validarAuto();
                
            if (empty($alertas)) {
                // guardar imagenes
                if(isset($imagen_png_1) || isset($imagen_webp_1)){
                    $imagen_png_1->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp_1->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                if(isset($imagen_png_2) || isset($imagen_webp_2)){
                    $imagen_png_2->save($carpeta_imagenes . '/' . $nombre_imagen_2 . ".png");
                    $imagen_webp_2->save($carpeta_imagenes . '/' . $nombre_imagen_2 . ".webp");
                }
                $resultado = $automovil->guardar($automovil->id);
            
                if ($resultado) {
                    header('Location: /admin/automoviles');
                }
            }     
            
        }

        $router->render('admin/automoviles/editar', [
            'titulo' => 'Editar Automóvil',
            'alertas' => $alertas,
            'marcas' => $marcas,
            'automovil' => $automovilStd,


        ]);
    }

    public static function eliminar (){

        if(!is_admin()){
            header('Location: /');
        }
        
        $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

        if(!$id){
            header('location: /admin/dashboard');
        }

        $automovil = Automovil::find($id);

        if(!$automovil){
            header('location: /admin/dashboard');
        }

        $carpeta_imagenes = '../public/img/automoviles';

        Automovil::borrarImagen($carpeta_imagenes, $automovil->fotouno, 'png');
        Automovil::borrarImagen($carpeta_imagenes, $automovil->fotouno, 'webp');
        Automovil::borrarImagen($carpeta_imagenes, $automovil->fotodos, 'png');
        Automovil::borrarImagen($carpeta_imagenes, $automovil->fotodos, 'webp');

        $resultado = $automovil->eliminar($automovil->id);

        $automovilR = [
            'tipo' => 'exito',
            'resultado' => $resultado,
            'mensaje' => 'Eliminado correctamente'
        ];

        echo json_encode($automovilR);
       

    }
}
