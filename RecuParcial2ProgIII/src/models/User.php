<?php

namespace App\Models;
use Illuminate\DataBase\Eloquent\Model;

class User extends Model{
    public $timestamps = false;

    /*public static function getLegajo(){
        
        $legajo = null;

        while(is_null($legajo)){

        $legajo = rand(100,10000);
        
        $valido = User::get()->where('legajo',$legajo)->first();

            if(is_null($valido)){
                return $legajo;
            } else {
                $legajo = null;
            }
        }
    }
*/
    public static function validarDatosUser($nombre, $email, $clave, $tipo){

        $valido = User::get()->where('email',$email)->first()?? null;
        $rta = true;

        if(strpos($nombre, " ")){
            $rta = array("rta"=>"Nombre invalido");
        }
        if(!is_null($valido)){
            
            $rta = array("rta"=>"Email invalido");
        }
        if(strlen($clave)<4){
           
            $rta = array("rta"=>"Clave invalido");
        }
        if(!(strcasecmp($tipo,"admin") == 0 || strcasecmp($tipo,"cliente") == 0 )){
            
            $rta = array("rta"=>"Tipo de usuario invalido");
        }
        
        return $rta;
    }
}