<?php

namespace Controllers;

use MVC\Router;
use Model\Marca;
use Model\Automovil;
use Classes\Paginacion;
use PHPMailer\PHPMailer\PHPMailer;

class PaginasController {
    public static function index(Router $router){

        $automoviles =  Automovil::get(6, 'ASC');

        $router->render('paginas/index', [
            'titulo' => 'Bienvenido',
            'automoviles' => $automoviles
        ]);
    }

    public static function consejos(Router $router){
        $router->render('paginas/consejos', [
            'titulo' => 'Tips o Consejos'
        ]);
    }

    public static function automoviles(Router $router){

        
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
       
        if(!$pagina_actual || $pagina_actual < 1){
            header('Location: /automoviles?page=1');
        }

        $registros_por_pagina = 6;
        $total = Automovil::total();
        
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);

        // redireccionar si el total de paginas es menor a la pagina actual
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /automoviles?page=1');
        }

        $automoviles = Automovil::paginar($registros_por_pagina, $paginacion->offset());

        foreach ($automoviles as $key => $automovil) {
            $objeto = $automovil->getStdClass();

            // creamos una nueva propiedad y le asignamos el resultado de la consulta
            $objeto->nomMarca = Marca::find($objeto->marcaid);

            // agregamos el nuevo objeto al antiguo
            $automoviles[$key] = $objeto;
        }

        $router->render('paginas/automoviles', [
            'titulo' => 'Automovíles en Venta',
            'automoviles' => $automoviles,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function automovil(Router $router){
        $id = $_GET['id'];
        $idV = filter_var($id, FILTER_VALIDATE_INT);

        if(!$idV){
            header('Location: /automoviles');
        }

        $automovil = Automovil::find($id);

        if(!isset($automovil)){
            header('Location: /automoviles');
        }

        $automovilSTD = $automovil->getStdClass();

        $automovilSTD->marca = Marca::find($automovilSTD->marcaid);

        $router->render('paginas/automovil', [
            'titulo' => $automovilSTD->marca->nombre,
            'automovil' => $automovilSTD
        ]);
    }

    public static function contacto(Router $router){
        $mensaje = null;
        $automovil = '';

        $nombre = '';
        
        if(is_auth()){
            $nombre = $_SESSION['nombre'] . ' ' . $_SESSION['apellido'];
        }
        
        $id = $_GET['id'] ?? false;
        if($id){
            $idV = filter_var($id, FILTER_VALIDATE_INT);
    
            if(!$idV) {
               header('Location: /contacto');
            }
            
            $automovil = Automovil::find($idV);

            if(!isset($automovil)){
                header('Location: /contacto');
            }  
            
        }

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $respuestas = $_POST['contacto'];

            $mail = new PHPMailer();

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = $_ENV['EMAIL_HOST'];
            $mail->SMTPAuth = true;
            $mail->Port = $_ENV['EMAIL_PORT'];
            $mail->Username = $_ENV['EMAIL_USER'];
            $mail->Password = $_ENV['EMAIL_PASS'];

            //Configurar el contenido del mail
              
            $mail->setFrom('admin@Concesionario.com');
            $mail->addAddress('admin@Concesionarion.com', 'Concecol.com');
            $mail->Subject = 'Tienes un Nuevo Mensaje';

            //Habilitar HTML
            $mail->isHTML(true);
            $mail->CharSet = 'UTF-8';

            // Definir el Contenido
            $contenido = '<html>'; 
            $contenido .= '<p>Tienes un nuevo mensaje</p>';
            $contenido .= '<p>Nombre: ' . $respuestas['nombre'] . '</p>';

            // Enviar de forma condiccional algunas campos de email o teléfono
            if($respuestas['contacto'] === 'telefono'){
                $contenido .= '<p>Eligió ser contactado por teléfono</p>';
                $contenido .= '<p>Teléfono: ' . $respuestas['telefono'] . '</p>';
                $contenido .= '<p>Fecha Contacto: ' . $respuestas['fecha'] . '</p>';
                $contenido .= '<p>Hora: ' . $respuestas['hora'] . '</p>';
                
            }else{
                $contenido .= '<p>Eligió ser contactado por email</p>';
                $contenido .= '<p>Email: ' . $respuestas['email'] . '</p>';
            }
            
            $contenido .= '<p>Automovil: ' . $respuestas['Auto'] . '</p>';
            $contenido .= '<p>Mensaje: ' . $respuestas['mensaje'] . '</p>';
            $contenido .= '<p>Vende o Compra: ' . $respuestas['tipo'] . '</p>';
            $contenido .= '<p>Precio o Presupuesto: ' . $respuestas['precio'] . '</p>';
            $contenido .= '<p>Prefiere ser Contactado por: ' . $respuestas['contacto'] . '</p>';
            $contenido .= '</html>';
            
            $mail->Body = $contenido;
            $mail->AltBody = 'Esto es texto alternativo sin html';

            //Enviar el email
            if($mail->send()){
                $mensaje = "Mensaje enviado Correctamente";
            } else {
                $mensaje ="El mensaje no se pudo enviar...";
            }
        }
        
        $router->render('paginas/contacto',[
            'mensaje' => $mensaje,
            'titulo' => 'Contáctanos',
            'automovil' => $automovil,
            'nombre' => $nombre
        ]);
    }
}