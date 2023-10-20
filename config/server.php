<?php

require dirname(__DIR__) . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use \MyApp\Chat;

$port = 8080;


$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    $port
);

// Configuration du contexte SSL/TLS
$context = stream_context_create([
    'ssl' => [
        'local_cert' => '/etc/letsencrypt/live/hello-voisins.com/fullchain.pem', // Chemin vers votre certificat SSL
        'local_pk' => '/etc/letsencrypt/live/hello-voisins.com/privkey.pem', // Chemin vers la clé privée associée
        'verify_peer' => false, // Pour le développement, désactivez la vérification du certificat
    ]
]);

// Lier le serveur WebSocket au contexte SSL/TLS
$socket = stream_socket_server("ssl://hello-voisins.com:{$port}", $errno, $errstr, STREAM_SERVER_BIND | STREAM_SERVER_LISTEN, $context);

if (!$socket) {
    echo "Erreur lors de la création du socket SSL : $errstr ($errno)\n";
} else {
    $server->loop->addReadStream($socket, $server->socket);

    echo "Serveur WebSocket sécurisé en cours d'exécution sur le port {$port}\n";
}

$server->run();
