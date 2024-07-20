<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController {
    public static function login(Router $router){
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validar_Login();
          
            if(empty($alertas)) {
                $userExists = Usuario::where('email', $usuario->email);
             
                if(!$userExists || !$userExists->confirmado){
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                } else {
                    // validar password 
                    if(password_verify($usuario->password, $userExists->password)){
                        session_start();
                        $_SESSION['id'] = $userExists->id;
                        $_SESSION['nombre'] = $userExists->nombre;
                        $_SESSION['apellido'] =$userExists->apellido;
                        $_SESSION['email'] = $userExists->email;
                        $_SESSION['admin'] = $userExists->admin ?? null;

                        if($userExists->admin) {
                            header('Location: /admin/dashboard');
                        } else {
                            header('Location: /');
                        }

                    } else {
                        Usuario::setAlerta('error', 'Password incorrecto');
                    }
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/login', [
            'titulo' => 'Iniciar Sesión',
            'alertas' => $alertas
        ]);
    }

    public static function logout(Router $router){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            session_start();
            $_SESSION = [];
            header('Location: /');
        }
        
    }

    public static function registro(Router $router){

        $alertas = [];
        $usuario = new Usuario;
        
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_registro();

            $id = $usuario->id;

            if(empty($alertas)){
                $userExists = $usuario::where('email', $usuario->email);

                if($userExists){
                    Usuario::setAlerta('error', 'El usuario ya existe');
                    $alertas = Usuario::getAlertas();
                } else {
                    $usuario->hashPassword();

                    $usuario->crearToken();

                    unset($usuario->password__confirmation);

                    // guardar el usuario
                    $resultado = $usuario->guardar($id);

                    //Enviar email
                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
                    $email->enviarConfirmacion();

                    if($resultado) {
                        header('Location: /mensaje');
                    } 

                }
            }

        }
    
        $router->render('auth/registro', [
            'titulo' => 'Crea tu Cuenta',
            'alertas' => $alertas,
            'usuario' => $usuario
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje', [
            'titulo' => 'Cuenta creada correctamente'
        ]);
    }

    public static function confirmar(Router $router){

        $token = s($_GET['token']);

        if(!$token){
            header('Location /');
        }

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            // no se encontro el usuario con ese token
            Usuario::setAlerta('error', 'Token no valido, cuenta no confirmada');
        } else {
            // confirmar cuenta
            $id = $usuario->id;
            $usuario->confirmado = 1;
            $usuario->token = '';
            unset($usuario->password__confirmation);

            $usuario->guardar($id);

            Usuario::setAlerta('exito', 'Cuenta Comprobada Éxitosamente');
        }

        $router->render('auth/confirmar', [
            'titulo' => 'Confirmar cuenta',
            'alertas' => Usuario::getAlertas()
        ]);
    }

    public static function olvide(Router $router){

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario = new Usuario($_POST);

            $alertas = $usuario->validarEmail();

            if(empty($alertas)){
                $userExists = Usuario::where('email', $usuario->email);
               
                if(isset($userExists) && $userExists->confirmado === "1"){
                    $id = $userExists->id;
                    $userExists->crearToken();
                    unset($userExists->password__confirmation);

                    // actualizar usuario
                    $userExists->guardar($id);

                    $email = new Email($userExists->email, $userExists->nombre, $userExists->token);
                    $email->enviarInstrucciones();

                    Usuario::setAlerta('error', 'Hemos enviado intruciones a tu email');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o no esta confirmado');
                }
            }

            $alertas = Usuario::getAlertas();

        }
        $router->render('auth/olvide', [
            'alertas' => $alertas,
            'titulo' => 'Olvidaste tu Password'
        ]);
    }

    public static function reestablecer(Router $router) {
        $token = s($_GET['token']);

        $token_valido = true;

        if(!$token){
            header('Location: /login');
        }

        $usuario = Usuario::where('token', $token);

        if(empty($usuario)){
            Usuario::setAlerta('error', 'Token no Válido');
            $token_valido = false;
        } 

        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $usuario->sincronizar($_POST);

            $alertas = $usuario->validarPassword();

            if(empty($alertas)){

                $id = $usuario->id;
                $usuario->hashPassword();
                $usuario->token = null;

                $resultado = $usuario->guardar($id);

                if($resultado) {
                    header('Location: /login');
                }
    
            }
        }


        $alertas = Usuario::getAlertas();

        $router->render('auth/reestablecer', [
            'titulo' => 'Reestablecer Password',
            'token_valido' => $token_valido,
            'alertas' => $alertas
        ]);
    }
}
?>