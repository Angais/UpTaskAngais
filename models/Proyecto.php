<?php 

namespace Model;

use Model\ActiveRecord;

class Proyecto extends ActiveRecord{
    protected static $tabla = "proyectos";
    protected static $columnasDB = ["id", "proyecto", "url", "propietarioId"];

    public function __construct($args = []){
        $this->id = $args["id"] ?? null;
        $this->proyecto = $args["proyecto"] ?? "";
        $this->url = $args["url"] ?? "";
        $this->propietarioId = $args["propietarioId"] ?? "";
    }

    public function validarProyecto(){
        if(!$this->proyecto){
            self::$alertas["error"][] = "Añada un nombre al Proyecto";
        }
        return self::$alertas;
    }
}