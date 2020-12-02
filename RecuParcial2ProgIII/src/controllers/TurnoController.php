<?php

namespace App\Controllers;

use App\Models\Turno;
use App\Models\Mascota;
use App\Models\User;
use JWT\Token;

class TurnoController{
    
    public function PedirTurno($request, $response, $args) {
        
        $turno = new Turno;
        
        $token = $_SERVER['HTTP_TOKEN'] ?? '';
        $payload = Token::ValidateToken($token);
        $cliente = User::where('email',$payload->email)->get()->first();
        
       

        if(Mascota::validarTipoMascota($request->getParsedBody()['tipoMascota']) === true){
            
            $turno->tipoMascota = $request->getParsedBody()['tipoMascota'];
            $turno->fecha = $request->getParsedBody()['fecha'];
            $turno->idCliente = $cliente->id;
            $turno->atendido = "No";

            $rta = $turno->save();
            $rta = array("rta"=> $rta);
            
        } else {
            $rta = array("rta"=> "Tipo de mascota no valido");
        }

        $response->getBody()->write(json_encode($rta));

        return $response;
    }

 /*  public function ObtenerTurnos($request, $response, $args) {

        $turnos = Turno::get()->where('tipo')
                    ->join('users', );

        $listaTurnos = array();

        foreach ($turnos as $turno) {

            if($turno){

                array_push($listaTurnos, $turno->materia);
            }
        }
        $i = 0;
        foreach ($listaMaterias as $key => $value) {
            
            $listaMaterias["rta"][$i] = $value;
            unset($listaMaterias[$i]);
            $i++;
        }

        $response->getBody()->write(json_encode($listaMaterias));

    }
*/
    public function Atender($request, $response, $args) {

        $idTurno = $args['idTurno'] ?? '';
        $turno = Turno::find($idTurno);

        if(!is_null($turno)){

            $turno->atendido = "Si";
            $rta = $turno->save();
            $rta = array("rta"=> $rta);
        } else {
            $rta = array("rta"=> "El turno no existe");
        }

        $response->getBody()->write(json_encode($rta));

    }

}