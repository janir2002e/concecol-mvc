<?php 
namespace Model;

class Vendedores extends ActiveRecord {

    public static $tabla = 'vendedores';
    public static $columnasDB = ['id', 'nombre', 'apellido', 'telefono', 'email', 'imagen', 'redes'];

    public $id;
    public $nombre;
    public $apellido;
    public $telefono;
    public $email;
    public $imagen;
    public $redes;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->redes =  $args['redes'] ?? '';
    }

    public function validar_vendedor(){
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre es Obligatorio';
        }

        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido es Obligatorio';
        }

        
        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono es Obligatorio';
        }

        if(strlen($this->telefono) < 10 ){
            self::$alertas['error'][] = 'El Numero de telefono debe Contener 10 numeros';
        }

        if(strlen($this->telefono) > 10 ){
            self::$alertas['error'][] = 'El Numero de telefono no debe Contener mas de 10 numeros';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email es obligatorio';
        }

        if(!$this->imagen) {
            self::$alertas['error'][] = 'La imagen es obligatoria';
        }

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            self::$alertas['error'][] = 'Email no Válido';
        }

        return self::$alertas;

    }
}
?>