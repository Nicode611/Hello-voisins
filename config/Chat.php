<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Monolog\Logger; // Importez la classe Logger de Monolog

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $logger; // Ajoutez une propriété pour le logger Monolog
    
    public function __construct(Logger $logger) {
        $this->clients = new \SplObjectStorage;
        $this->logger = $logger; // Initialisez le logger
    }

    public function onOpen(ConnectionInterface $conn) {
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
    
        $this->logger->info("New connection! ({$conn->resourceId})");
    }
    
    public function onMessage(ConnectionInterface $from, $msg) {
        $numRecv = count($this->clients) - 1;
    
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    
        $this->logger->info(sprintf('Connection %d sending message "%s" to %d other connection%s', $from->resourceId, $msg, $numRecv, $numRecv == 1 ? '' : 's'));
    }
    

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        // Utilisez le logger pour enregistrer la fermeture de connexion
        $this->logger->info("Connection {$conn->resourceId} has disconnected");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        // Utilisez le logger pour enregistrer les erreurs
        $this->logger->error("An error has occurred: " . $e->getMessage());


        $conn->close();
    }
}
