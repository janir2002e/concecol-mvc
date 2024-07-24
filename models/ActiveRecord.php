<?php

namespace Model;

use Attribute;
use Dotenv\Parser\Value;
use LDAP\Result;
use LDAP\ResultEntry;
use stdClass;

class ActiveRecord
{

    // Base DE DATOS
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];

    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database)
    {
        self::$db = $database;
    }

    //setear un tipo de alerta
    public static function setAlerta($tipo, $mensaje)
    {
        static::$alertas[$tipo][] = $mensaje;
    }

    // obtener alertas
    public static function getAlertas()
    {
        return static::$alertas;
    }

    public function sincronizar($args = [])
    {        
        foreach ($args as $key => $value) {
            // validar  si la key de arreglo exite en el objeto y si su valor no es null o vacio
            if (property_exists($this, $key) && !is_null($value)) {
                // asignamos el valor de arreglo al objeto dependiendo su key
                $this->$key = $value;
            }
        }
    }

    public static function borrarImagen($carpeta_imagenes, $imagen, $extencion){
        // comprobar si la imagen existe
        $ExiteImagen = file_exists($carpeta_imagenes . "/" . $imagen . "." . $extencion);
        if($ExiteImagen){
            unlink($carpeta_imagenes . "/" . $imagen . "." . $extencion);
        }
    }

    // crear un objeto en memoria de mysqli de activeRecord
    public static function consultarSQL($query)
    {
        $resultado = self::$db->query($query);

        // iterar
        $array = [];
        while ($registro = $resultado->fetch_assoc()) {
            $array[] = static::crearObjeto($registro);
        }

        //liberar memoria
        $resultado->free();

        return $array;
    }

    protected static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
               
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    // Paginar los registros
     public static function paginar($por_pagina, $offset, $campo = '', $valor = ''){
        if($campo){
            $query = "SELECT *  FROM " . static::$tabla . " WHERE {$campo} = '{$valor}' ORDER BY id DESC LIMIT {$por_pagina} OFFSET {$offset} ";
        }else{
            $query = "SELECT *  FROM " . static::$tabla . " ORDER BY id DESC LIMIT {$por_pagina} OFFSET {$offset} ";
        }
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function where($columna, $valor)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE {$columna} = '{$valor}'";
        $resultado = self::consultarSQL($query);
        // ingresar al primera posición del arreglo
        return array_shift($resultado);
    }

    public static function all($orden = 'DESC'){
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$orden}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function find($id){
        $query = "SELECT * FROM " . static::$tabla . " WHERE id={$id}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function total($columna = '', $valor = ''){
        $query = "SELECT COUNT(*) FROM " . static::$tabla;
        
        if($columna){
            $query .= " WHERE {$columna} = '{$valor}' ";
        }
        $resultado = self::$db->query($query);

        $total = $resultado->fetch_array();
        
        return array_shift($total);
    }

    public static function get($limite, $orden = 'DESC'){
        $query = "SELECT * FROM " . static::$tabla . " ORDER BY id {$orden} LIMIT {$limite} ";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function sanitizarAtributos()
    {
        // asignamos lo que retorna funcion a la variable de atributos
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
       
    }

    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna; //unión del arreglo de columnasDB con el objeto en memoria 
        }

        return $atributos;
    }


    public function guardar($id)
    {
        $resultado = '';
        if (!is_null($id)) {
            $resultado = $this->actualizar($id);
        } else {
            $resultado = $this->crear();
        }

        return $resultado;
    }

    public function crear()
    {
        $atributos = $this->sanitizarAtributos();

        $query = " INSERT INTO " . static::$tabla . " ( ";
        $query .= join(', ', array_keys($atributos)); 
        $query .= " ) VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";

        //debuguear($query);

        // insertar los datos
        $resultado = self::$db->query($query);
    
        return [
           'resultado' =>  $resultado,
           'id' => self::$db->insert_id
        ];
    }

    public function actualizar($id) {

        $atributos = $this->sanitizarAtributos();

        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }

        $query = " UPDATE " . static::$tabla . " SET ";
        $query .= join(', ', $valores); 
        $query .= " WHERE id = '" . self::$db->escape_string($id) . "' ";
        $query .= " LIMIT 1 ";

        // Actualizar DB
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminar($id){
        $query = "DELETE FROM "  . static::$tabla . " WHERE id = " . self::$db->escape_string($id) . " LIMIT 1";
        $resultado = self::$db->query($query);
        return $resultado;
        
    }
    
    public function getStdClass(){
        $object = new stdClass;

        // crear un nuevo objeto tipo stdClass
        foreach(static::$columnasDB as $column){
            if(property_exists($this, $column)){
               $object->$column = $this->$column;
            }
        }

        return $object;
    }
}
