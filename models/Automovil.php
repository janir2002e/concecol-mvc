<?php

namespace Model;
use Model\ActiveRecord;

class Automovil extends ActiveRecord {
    protected static $tabla = 'automoviles';
    protected static $columnasDB = ['id', 'modelo', 'version', 'marcaid', 'combustible', 'precio', 'cambio', 'descripcion', 'fotouno', 'fotodos',
    'vendedorid', 'creado'];

    public $id;
    public $modelo;
    public $version;
    public $marcaid;
    public $combustible;
    public $precio;
    public $cambio;
    public $descripcion;
    public $fotouno;
    public $fotodos;
    public $vendedorid;
    public $creado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->modelo = $args['modelo'] ?? '';
        $this->version = $args['version'] ?? '';
        $this->marcaid = $args['marcaid'] ?? '';
        $this->combustible = $args['combustible'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->cambio = $args['cambio'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fotouno = $args['fotouno'] ?? '';
        $this->fotodos = $args['fotodos'] ?? '';
        $this->vendedorid = $args['vendedorid'] ?? '';
        $this->creado = date('Y/m/d');

    }

    public function validarAuto(){
        if(!$this->modelo){
            self::$alertas['error'][] = 'El modelo es obligatorio';
        }
        if(!$this->version){
            self::$alertas['error'][] = 'La version es obligatoria';
        }
        if(!$this->marcaid){
            self::$alertas['error'][] = 'La marca es obligatoria';
        }

        if(!filter_var($this->marcaid, FILTER_VALIDATE_INT)){
            self::$alertas['error'][] = 'Marca inválida';
        }
        
        if(!$this->combustible){
            self::$alertas['error'][] = 'El Tipo de combustible es obligatorio';
        }
        if(!$this->precio){
            self::$alertas['error'][] = 'El Precio es obligatorio';
        }

        if(strlen($this->precio) > 10){
            self::$alertas['error'][] = 'Precio inválido';
        }

        if(!filter_var($this->precio, FILTER_VALIDATE_FLOAT)){
            self::$alertas['error'][] = 'Precio inválido';
        }

        if(!$this->cambio){
            self::$alertas['error'][] = 'El Tipo de cambio es obligatorio';
        }

        if(!$this->descripcion){
            self::$alertas['error'][] = 'La descripción es obligatoria';
        }

        if(strlen($this->descripcion) > 1000){
            self::$alertas['error'][] = 'Descripción demasiado larga';
        }

        if(!$this->fotouno){
            self::$alertas['error'][] = 'La foto del exterior es obligatoria';
        }

        if(!$this->fotodos){
            self::$alertas['error'][] = 'La foto del interior es obligatoria';
        }

        if(!$this->vendedorid){
            self::$alertas['error'][] = 'El Vendedor es obligatorio';
        }

        return self::$alertas;
    }
}

?>