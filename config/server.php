<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('ratchet');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));


$port = $_SERVER['PORT']; 

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat() // Instanciez la classe Chat avec la référence à l'objet serveur
        )
    ),
    $port
);

$server->run();


