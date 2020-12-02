<?php

require_once "../vendor/autoload.php";

use \Firebase\JWT\JWT;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Exception\NotFoundException;
use Slim\Routing\RouteCollectorProxy;       //Group
use Slim\Middleware\ErrorMiddleware;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;

use Config\DataBase;
use App\Controllers\LoginController;
use App\Controllers\UserController;
use App\Controllers\MascotaController;
use App\Controllers\TurnoController;

use App\Middlewares\JsonMiddleware;
use App\Middlewares\AuthMiddleware;


$app = AppFactory::create();
new DataBase;
$app->setBasePath("/ProgramacionIII/RecuParcial2ProgIII/public");


$app->post('/users', UserController::class . ":add");

$app->post("/login", LoginController::class . ":login");


$app->group('/turno', function (RouteCollectorProxy $group) {
    
    $group->post("[/]", TurnoController::class . ":PedirTurno")->add(new AuthMiddleware(array('cliente')));

    $group->get("{/}", TurnoController::class . ":ObtenerTurnos")->add(new AuthMiddleware(array('admin')));

    $group->put("/{idTurno}", TurnoController::class . ":Atender")->add(new AuthMiddleware(array('admin')));

});

$app->group('/mascota', function (RouteCollectorProxy $group) {

    $group->post('[/]', MascotaController::class . ":add")->add(new AuthMiddleware(array('admin')));

});

$app->add(new JsonMiddleware);

$app->addBodyParsingMiddleware();

$app->run();