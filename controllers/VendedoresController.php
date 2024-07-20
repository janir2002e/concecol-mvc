<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Model\Vendedores;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager as Image;

class VendedoresController
{

    public static function index(Router $router)
    {

        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);

        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/vendedores?page=1');
        }


        $registros_por_pagina = 10;
        $total = Vendedores::total();

        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        // redireccionar si el total de paginas es menor a la pagina actual
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/vendedores?page=1');
        }

        $vendedores = Vendedores::paginar($registros_por_pagina, $paginacion->offset());

        if (!is_admin()) {
            header('Location: /login');
        }

        $router->render('admin/vendedores/index', [
            'titulo' => 'Vendedores',
            'vendedores' => $vendedores,
            'paginacion' => $paginacion->paginacion()

        ]);
    }

    public static function crear(Router $router)
    {

        $alertas = [];

        $vendedor = new Vendedores;

        if (!is_admin()) {
            header('Location /');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!is_admin()) {
                header('Location /');
            }


            // Leer Imagen
            if (!empty($_FILES['imagen']['tmp_name'])) {
                //ubicación
                $carpeta_imagenes = '../public/img/vendedores';

                // crear carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                $manager = new Image(Driver::class);
                $imagen_png = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            }

            // convertir el arreglo a un string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);

            $vendedor->sincronizar($_POST);

            $alertas = $vendedor->validar_vendedor();

            if (empty($alertas)) {
                // Guardar imagen en su carpeta definida
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");

                $resultado = $vendedor->guardar($vendedor->id);

                if ($resultado) {
                    header('Location: /admin/vendedores');
                }
            }
        }

        $router->render('admin/vendedores/crear', [
            'titulo' => 'Crear Vendedor',
            'alertas' => $alertas
        ]);
    }


    public static function editar(Router $router)
    {

        $alertas = [];

        if (!is_admin()) {
            header('Location: /');
        }

        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('Location: /admin/vendedores');
        }

        $vendedor = Vendedores::find($id);

        if (empty($vendedor)) {
            header('Location: /admin/vendedores');
        }

        // convertir en el objeto en un stdClass para crear propiedades dinamicas
        $vendedorStd = $vendedor->getStdClass();

        $vendedorStd->imagen_actual = $vendedorStd->imagen;

        $redes = json_decode($vendedorStd->redes);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /');
            }

            // VALIDA SI EL ARREGLO DE FILES ESTA VACIO, SI CONTIENE ALGUN VALOR RETORNA FALSE PERO AL NEGAR LA CONDICION ENTRA EL IF
            if (!empty($_FILES['imagen']['tmp_name'])) {
                //ubicación
                $carpeta_imagenes = '../public/img/vendedores';

                // crear carpeta si no existe
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }

                Vendedores::borrarImagen($carpeta_imagenes, $vendedorStd->imagen_actual, 'png');
                Vendedores::borrarImagen($carpeta_imagenes, $vendedorStd->imagen_actual, 'webp');

                $manager = new Image(Driver::class);
                $imagen_png = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $imagen_webp = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600)->encode(new WebpEncoder(quality: 65));
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                //asignar la imagen actual al post si no se subido una imagen nueva
                $_POST['imagen'] = $vendedorStd->imagen_actual;
            }

            // convierte el arreglo a un string
            $_POST['redes'] = json_encode($_POST['redes'], JSON_UNESCAPED_SLASHES);


            $vendedor->sincronizar($_POST);

            $alertas = $vendedor->validar_vendedor();

            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    // Guardar la imagenes en su carpeta definida
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }

                $resultado = $vendedor->guardar($vendedor->id);


                if ($resultado) {
                    header('Location: /admin/vendedores');
                }
            }
        }

        $router->render('admin/vendedores/editar', [
            'titulo' => 'Editar Vendedor',
            'alertas' => $alertas,
            'vendedor' => $vendedorStd,
            'redes' => json_decode($vendedorStd->redes)
        ]);
    }

    public static function EliminarValidar()
    {
        if (!is_admin()) {
            header('Location /admin/vendedores');
        }

        $url_id = $_GET['id'];
        $id = filter_var($url_id, FILTER_VALIDATE_INT);

        if (!$id) {
            header('location: /admin/vendedores');
        }

        $vendedor = Vendedores::where('id', $id);

        if (!$vendedor) {
            header('location: /admin/vendedores');
        }
        echo json_encode($vendedor);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /');
            }

            $id_V = $_POST['id'];
            $id = filter_var($id_V, FILTER_VALIDATE_INT);

            if (!$id) {
                header('Location: /admin/vendedores');
            }

            $vendedor = Vendedores::find($id);

            $carpeta_imagenes = '../public/img/vendedores';

            Vendedores::borrarImagen($carpeta_imagenes, $vendedor->imagen, 'png');
            Vendedores::borrarImagen($carpeta_imagenes, $vendedor->imagen, 'webp');

            if (!isset($vendedor)) {
                header('Location: /admin/vendedores');
            }

            $resultado = $vendedor->eliminar($vendedor->id);

            $vendedor = [
                'tipo' => 'exito',
                'resultado' => $vendedor,
                'mensaje' => 'Eliminado correctamente'
            ];
            echo json_encode($vendedor);

        }
    }
}
