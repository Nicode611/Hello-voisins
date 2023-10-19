<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;

$port = isset($_SERVER['SERVER_PORT']) ? $_SERVER['SERVER_PORT'] : 8080; // Port par défaut si non spécifié


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $port
);

$server->run();

echo 'voici le port' . $port ;