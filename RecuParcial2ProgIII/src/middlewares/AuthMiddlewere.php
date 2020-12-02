<?php

namespace App\Middlewares;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Psr\Http\Message\ResponseInterface as Res;
use Slim\Psr7\Response;
use App\Models\User;
use JWT\Token;

class AuthMiddleware{

    public $_AuthUsers;

    public function __construct( $AuthUser ) { $this->_AuthUsers = $AuthUser; }

    public function __invoke($request, $handler)
    {
        $token = $_SERVER['HTTP_TOKEN'] ?? '';
        
        $payload = Token::ValidateToken($token);
        $flag = false;

        if(is_null($payload)){

            $response = new Response();
            $rta = array("rta"=>"Token Invalido");
            $response->getBody()->write(json_encode($rta));

            return $response->withStatus(403);

        } else {

            $user = User::where('email',$payload->email)->get()->first();

            foreach ($this->_AuthUsers as $tipoUser) {
                
                if($user->tipo == $tipoUser){
                    $flag = true;
                    break;
                } else {
                    $flag = false;
                }
            }
            
            if($flag){
                $response = $handler->handle($request);
                $body = (string) $response->getBody();
                
                $res = new Response();
                $res->getBody()->write($body);
                return $res;
            } else {
                $response = new Response();
                $rta = array("rta"=>"Error. No tiene los permisos necesarios.");
                $response->getBody()->write(json_encode($rta));
                return $response;
            }
            
        }
    }
}