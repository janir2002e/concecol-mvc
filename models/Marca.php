<?php

namespace Model;

class Marca extends ActiveRecord {
    protected static $tabla = 'marcas';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

}
?>