<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


$logFilePath = 'logs.html';
$customLogMessage = "Serveur Ratchet démarré avec succès le " . date('Y-m-d H:i:s');
echo $customLogMessage ;
echo 'voici le port' . 8888;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $usernames;
    protected $userCounts = [];


    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usernames = [];
    }

    

    public function onOpen(ConnectionInterface $conn) {
        try {
            parse_str($conn->httpRequest->getUri()->getQuery(), $queryParameters);
            // Store the new connection to send messages to later
            $this->clients->attach($conn);
            
            $username = $queryParameters['username'] ?? null;
            $id = $queryParameters['id'] ?? null; // Ajout pour récupérer l'ID
            
            if ($username && $id) {
                $userData = [
                    "username" => $username,
                    "id" => $id,
                ];
                $this->usernames[$conn->resourceId] = $userData;
                $this->userCounts[$username] = ($this->userCounts[$username] ?? 0) + 1;
                $this->sendUserCountToClient($username, $this->userCounts[$username]);

                echo "New connection! ({$conn->resourceId}) - Username: $username, ID: $id\n";
            }
        } catch (\Exception $e) {
            echo "WebSocket erreur de connection - Error Message: {$e->getMessage()}\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $fromUserData = $this->usernames[$from->resourceId] ?? null;
        
        if ($fromUserData) {
            $fromUsername = $fromUserData['username'];
            $fromId = $fromUserData['id'];
            
            $messageData = json_encode([
                "username" => $fromUsername,
                "id" => $fromId,
                "message" => $msg
            ]);
            
            foreach ($this->clients as $client) {
                if ($from !== $client) {
                    $clientUserData = $this->usernames[$client->resourceId] ?? null;
                    
                    if ($clientUserData && $fromUsername === $clientUserData['username']) {
                        $client->send($messageData);
                    }
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $userData = $this->usernames[$conn->resourceId] ?? null;
        if ($userData) {
            $username = $userData['username'];
            $id = $userData['id'];
            $this->userCounts[$username] = ($this->userCounts[$username] ?? 0) - 1;
            if ($this->userCounts[$username] <= 0) {
                unset($this->userCounts[$username]);
            }
            $this->sendUserCountToClient($username, $this->userCounts[$username] ?? 0);
        }
        $this->clients->detach($conn);
        echo "Connection ({$conn->resourceId}) has disconnected - Username: $username, ID: $id\n";
    }
    

    public function onError(ConnectionInterface $conn, \Exception $e) {
        function logErrorToHTML($message) {
            global $logFilePath;
            $errorLog = date('Y-m-d H:i:s') . ' - ' . $message . "<br>";
            file_put_contents($logFilePath, $errorLog, FILE_APPEND);
        }

        $username = $this->usernames[$conn->resourceId] ?? 'N/A';
        echo("WebSocket Error - Username: $username, Error Message: {$e->getMessage()}"). "\n";


        $conn->close();
    }

    private function sendUserCountToClient($username, $count) {
        // Loop through clients to find those with the same username
        foreach ($this->clients as $client) {
            if ($this->usernames[$client->resourceId] === $username) {
                $client->send(json_encode(["user_count" => $count]));
            }
        }
    }
}