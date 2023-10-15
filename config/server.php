<?php

file_put_contents('config/server_status.txt', 'running');


$port = $_SERVER['PORT'] ?? 2650; // Utilisez 8080 si la variable d'environnement PORT n'est pas définie

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;

require dirname(__DIR__) . '/vendor/autoload.php';

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat() // Instanciez la classe Chat avec la référence à l'objet serveur
        )
    ),
    2650
);

$server->run();

    

    // Mettez à jour le fichier d'état
