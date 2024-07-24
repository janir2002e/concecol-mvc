<?php

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\ImageManager as Image;

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

function pagina_actual($path) : bool {
    return str_contains($_SERVER['REQUEST_URI'] ?? '/', $path) ? true : false;
}

function is_auth() : bool {
    // si la session no exite o es null devuelve true
    if(!isset($_SESSION)){
        session_start();
    }

    return isset($_SESSION['nombre']) && !empty($_SESSION);
}

function is_admin() : bool {
    if(!isset($_SESSION)){
        session_start();
    }

    return isset($_SESSION['admin']) && !empty($_SESSION['admin']);
}

function crearNombreImagen(){
    return md5(uniqid(rand(), true));
}





