<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;


$customLogMessage = "Serveur Ratchet démarré avec succès le " . date('Y-m-d H:i:s');
echo $customLogMessage ;
echo 'voici le port' . 8888;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $usernames;
    protected $channels;


    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usernames = [];
        $this->channels = [];
    }

    

    public function onOpen(ConnectionInterface $conn) {
        try {
            parse_str($conn->httpRequest->getUri()->getQuery(), $queryParameters);
            // Store the new connection to send messages to later
            
            
            $username = $queryParameters['username'] ?? null;
            $id = $queryParameters['id'] ?? null; // Ajout pour récupérer l'ID
            $channelName = $queryParameters['channelName'] ?? null;
            
            if ($username && $id) {
                $userData = [
                    "username" => $username,
                    "id" => $id,
                    "channel" => $channelName,
                ];
                $this->usernames[$conn->resourceId] = $userData;
                
                
                // Vérifiez si l'utilisateur a l'intention de rejoindre un canal de groupe privé
                if (isset($queryParameters['channelName'])) {
                    $channelName = $queryParameters['channelName'];
                    if (!isset($this->channels[$channelName])) {
                        // Le canal n'existe pas, créez-le
                        $this->channels[$channelName] = new \SplObjectStorage();
                    }
                    $this->channels[$channelName]->attach($conn);
                    $userData = [
                        "username" => $username,
                        "id" => $id,
                        "channel" => $channelName, // Ajoutez cette ligne pour stocker le canal dans le tableau $userData
                    ];
                    $this->usernames[$conn->resourceId] = $userData;
                    $conn->send("Vous avez rejoint le canal $channelName.");
                    $connectedUsersInChannel = $this->getAllConnectedUsersDataInChannel($channelName);
                    $conn->send(json_encode(["connected_users" => $connectedUsersInChannel]));
                }


                // Compte tous les utilisateurs connectés (visible dans l'objet $this->clients)
                $countAllUsers = count($this->clients); 

                // Après avoir ajouté l'utilisateur, envoyez les données des utilisateurs connectés
                $this->sendConnectedUsersDataToUserInChannel($conn);

                // Envoyer un message de connexion à tous les clients
                $connectionMessage = [
                    "username" => $username,
                    "id" => $id,
                    "channel" => $channelName,
                    "message" => "S'est connecté."
                ];

                $this->sendToChannel($channelName, $connectionMessage);
                // $this->sendToAllClients($connectionMessage);
                // Envoie le nombre d'utilisateurs connectés a la fonction
                $this->sendUserCountToClient($countAllUsers);

                echo "New connection! ({$conn->resourceId}) - Username: $username, ID: $id Channel: $channelName\n";
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
            
            if (isset($fromUserData['channel'])) {
                $channelName = $fromUserData['channel'];
                $this->sendToChannel($channelName, $messageData);
            
                    // Condition pour envoyer a ceux qui ont le meme username
                    // $clientUserData = $this->usernames[$client->resourceId] ?? null;
                    // if ($clientUserData && $fromUsername === $clientUserData['username']) {
                    //     $client->send($messageData);
                    // }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Mettez à jour le nombre total d'utilisateurs connectés
        
        // Vous pouvez toujours afficher les informations de l'utilisateur qui se déconnecte
        $userData = $this->usernames[$conn->resourceId] ?? null;
        if ($userData) {
            $username = $userData['username'];
            $id = $userData['id'];
            $channelName = $userData['channel'];
    
            // Envoie la mise à jour de la liste des utilisateurs dans le canal aux autres utilisateurs
            $connectedUsersInChannel = $this->getAllConnectedUsersDataInChannel($channelName);
            $this->sendToChannel($channelName, ["connected_users" => $connectedUsersInChannel]);
            
    
            // Envoyer un message de déconnexion à tous les clients
            $disconnectionMessage = [
                "username" => $username,
                "id" => $id,
                "message" => "S'est déconnecté."
            ];
            $this->sendToChannel($channelName, $disconnectionMessage);
    
            echo "Connection ({$conn->resourceId}) has disconnected - Username: $username, ID: $id\n";
    
            // Supprimez l'utilisateur de la liste $usernames
            unset($this->usernames[$conn->resourceId]);

            // Envoyez la nouvelle liste des utilisateurs connectés à tous les clients
            $this->sendToChannel($channelName, ["connected_users" => $connectedUsersInChannel]);

        }
        // Supprimez la connexion de la liste des clients
        $this->clients->detach($conn); 
        // Compte tous les utilisateurs connectés (visible dans l'objet $this->clients)
        $countAllUsers = count($this->clients);
        // Envoie le nombre d'utilisateurs connectés a la fonction
        $this->sendUserCountToClient($countAllUsers);
    }
    
    
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $username = $this->usernames[$conn->resourceId] ?? 'N/A';
        echo("WebSocket Error - Username: $username, Error Message: {$e->getMessage()}"). "\n";
        $conn->close();
    }

    private function sendUserCountToClient($count) {
        // Loop through clients to send the total user count to all of them
        foreach ($this->clients as $client) {
            $client->send(json_encode(["user_count" => $count]));
        }
    }

    
    private function sendToChannel($channelName, $message) {
        if (isset($this->channels[$channelName])) {
            $messageData = json_encode($message);
            foreach ($this->channels[$channelName] as $client) {
                $client->send($messageData);
            }
        }
    }

    // Cette fonction envoie tout les utilisateurs connectés au server
    private function sendConnectedUsersDataToUserInChannel(ConnectionInterface $userConnection) {
        $connectedUsers = $this->getAllConnectedUsersDataInChannel($this->channels[$channelName]);
        $userConnection->send(json_encode(["connected_users" => $connectedUsers]));
    }
    
    
    // Cette fonction récupere tout les utilisateurs connectés au channel
    private function getAllConnectedUsersDataInChannel($channelName) {
        $connectedUsers = [];
    
        if (isset($this->channels[$channelName])) {
            foreach ($this->channels[$channelName] as $userData) {
                $connectedUsers[] = $userData;
            }
        }
    
        return $connectedUsers;
    }

    // // Cette fonction récupere tout les utilisateurs connectés au server 
    // private function getAllConnectedUsersData() {
    //     $connectedUsers = [];
    
    //     foreach ($this->usernames as $userData) {
    //         $connectedUsers[] = $userData;
    //     }
    
    //     return $connectedUsers;
    // }
    
    

}