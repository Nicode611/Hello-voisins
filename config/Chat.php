<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $usernames;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usernames = [];
    }

    public function onOpen(ConnectionInterface $conn) {
        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParameters);
        // Store the new connection to send messages to later
        $this->clients->attach($conn);
        

        $username = $queryParameters['username'] ?? null;
        if ($username) {
            $this->usernames[$conn->resourceId] = $username;
        }

        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        // Lorsqu'un utilisateur envoie un message, vérifiez si d'autres utilisateurs ont le même nom
        $fromUsername = $this->usernames[$from->resourceId] ?? null;
        
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $clientUsername = $this->usernames[$client->resourceId] ?? null;
                
                // Les noms d'utilisateur sont les mêmes,
                if ($fromUsername && $clientUsername && $fromUsername === $clientUsername) {
                    $client->send($msg);
                    // $client->send("Vous êtes maintenant connecté à " . $from->resourceId);
                    // $from->send("Vous êtes maintenant connecté à " . $client->resourceId);
                }
            }
        }
    }
    

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        $this->clients->detach($conn);

        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }


    private function getLoc(ConnectionInterface $conn)
    {   
        // Vous pouvez définir une méthode pour obtenir le nom d'utilisateur de la connexion
        // Cela dépendra de la structure de vos messages, par exemple, si le nom d'utilisateur est inclus dans le message.
        // Dans cet exemple, nous utilisons le message lui-même comme nom d'utilisateur.
        return $conn->resourceId;
    }
}