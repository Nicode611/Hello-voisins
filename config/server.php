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

$port = getenv('PORT') ? getenv('PORT') : 8080;

$chat = new Chat($logger);

$server = IoServer::factory(
    new HttpServer(
        new WsServer($chat)
    ),
    $port
);

$server->run();
