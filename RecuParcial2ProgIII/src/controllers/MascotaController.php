<?php

namespace App\Controllers;
use App\Models\Mascota;
use Auxiliar\Respuesta;

class MascotaController{

    public function add($request, $response, $args) {
        
        $mascota = new Mascota;
        $rta = [];
        $mascota->tipoMascota = $request->getParsedBody()['tipoMascota'];
        $mascota->precio = $request->getParsedBody()['precio'];

        if(Mascota::validarTipoMascota($mascota->tipoMascota) === true){

            $mascota->identificador_Mascota = Mascota::getIdentificadorMascota($mascota->tipoMascota);
            $rta = $mascota->save();
            $rta = array("rta"=>$rta);
        } else {

            $rta = 'Cuatrimestre Invalido';
        }

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
}