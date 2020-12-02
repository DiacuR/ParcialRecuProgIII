<?php

namespace App\Models;
use Illuminate\DataBase\Eloquent\Model;

class Mascota extends Model{
    public $timestamps = false;


    public static function validarTipoMascota($tipo){

        $rta = true;
        if(!(strcasecmp($tipo,"huron") == 0 || strcasecmp($tipo,"perro") == 0 || strcasecmp($tipo,"gato") == 0 )){
            
            $rta = array("rta"=>"Tipo de animal incorrectp");
        }

        return $rta;
    }

    public static function getIdentificadorMascota($tipo){

        switch ($tipo) {
            case 'huron':
                $identificador = 100;
                break;
            case 'perro':
                $identificador = 101;
                break;
            case 'gato':
                $identificador = 102;
                break;
        }

        return $identificador;
    }
}