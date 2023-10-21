<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;

$port = 8080;

// Lier le serveur WebSocket au contexte SSL/TLS
$socket = stream_socket_server("ssl://0.0.0.0:{$port}", $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);

if (!$socket) {
    echo "Erreur lors de la création du socket SSL : $errstr ($errno)\n";
} else {
    echo "Serveur WebSocket sécurisé en cours d'exécution sur le port {$port}\n";
}

// Créer le serveur Ratchet WebSocket
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $socket
);

$server->run();
