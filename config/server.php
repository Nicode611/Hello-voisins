<?php
require dirname(__DIR__) . '/vendor/autoload.php';

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;

$logger = new Logger('ratchet');
$logger->pushHandler(new StreamHandler('php://stdout', Logger::INFO));

$port = $_SERVER['PORT']; 

$chat = new Chat($logger); // Passer le logger à la classe Chat

$server = IoServer::factory(
    new HttpServer(
        new WsServer($chat) // Utiliser l'instance de Chat avec le logger
    ),
    $port
);

$server->run();
