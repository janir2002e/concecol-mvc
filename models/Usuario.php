<?php 

namespace Model;

class Usuario extends ActiveRecord {
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'password', 'token', 'admin', 'confirmado'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $password__confirmation;
    public $token;
    public $admin;
    public $confirmado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password__confirmation = $args['password__confirmation'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
    }


    public function validar_login() {
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no Válido';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        return self::$alertas;
    }
    
    public function validar_registro() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'El nombre es obligatorio';
        }

        if(!$this->apellido) {
            self::$alertas['error'][] = 'El apellido es obligatorio';
        }

        if(!$this->email) {
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no válido';
        }

        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio';
        }

        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener 8 caracteres';
        }

        if($this->password !== $this->password__confirmation) {
            self::$alertas['error'][] = 'los password son diferentes';
        }

        return self::$alertas;
    }

    public function validarEmail(){
        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no Válido';
        }
        return self::$alertas;
    }

     // Valida el Password 
     public function validarPassword() {
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 8) {
            self::$alertas['error'][] = 'El password debe contener al menos 8 caracteres';
        }
        return self::$alertas;
    }

    public function hashPassword() : void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() : void {
        $this->token = uniqid();
    }
}
?>