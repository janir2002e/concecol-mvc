<?php 

namespace Controllers;

use Model\Vendedores;
use MVC\Router;

class ApiVendedores {
    public static function index(){
        if(!is_admin()){
            header('Location: /');
        }
        $vendedores = Vendedores::all('ASC');
        echo json_encode($vendedores);
    }

    public static function vendedor(){
        if(!is_admin()){
            header('Location: /');
        }

        $id = $_GET['id'];
        $idv = filter_var($id, FILTER_VALIDATE_INT);

        $vendedor = Vendedores::find($idv);

        if(!isset($idv) || !$id || $idv < 1){
            echo json_encode([]);
            return;
        }

        echo json_encode($vendedor, JSON_UNESCAPED_SLASHES);
    }

}
?>