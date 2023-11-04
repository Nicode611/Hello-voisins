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
            $this->clients->attach($conn);
            
            $username = $queryParameters['username'] ?? null;
            $id = $queryParameters['id'] ?? null; // Ajout pour récupérer l'ID
            
            if ($username && $id) {
                $userData = [
                    "username" => $username,
                    "id" => $id,
                ];
                $this->usernames[$conn->resourceId] = $userData;
                
                // Compte tous les utilisateurs connectés (visible dans l'objet $this->clients)
                $countAllUsers = count($this->clients); 

                // Après avoir ajouté l'utilisateur, envoyez les données des utilisateurs connectés
                $this->sendConnectedUsersDataToUser($conn);

                // Envoyer un message de connexion à tous les clients
                $connectionMessage = [
                    "username" => $username,
                    "id" => $id,
                    "message" => "S'est connecté."
                ];
                $this->sendToAllClients($connectionMessage);
                // Envoie le nombre d'utilisateurs connectés a la fonction
                $this->sendUserCountToClient($countAllUsers);

                echo "New connection! ({$conn->resourceId}) - Username: $username, ID: $id\n";
            }
        } catch (\Exception $e) {
            echo "WebSocket erreur de connection - Error Message: {$e->getMessage()}\n";
        }
    }

    public function onMessage(ConnectionInterface $from, $msg) {

        // Commence par vérifier si le message reçu est au format JSON et s'il contient une action
        $data = json_decode($msg, true);

        // Si l'action est "join_or_create_channel", extrait le nom du canal à partir du message JSON. 
        if ($data && isset($data['action'])) {
            switch ($data['action']) {
                case 'join_or_create_channel':
                    $channelName = $data['channelName'];
                    if (!isset($this->channels[$channelName])) {
                        // Le canal n'existe pas, créez-le
                        $this->channels[$channelName] = new \SplObjectStorage();
                        $this->channels[$channelName]->attach($from);
                        $from->send("Le canal $channelName a été créé.");
                    } else {
                        // Le canal existe, rejoignez-le
                        $this->channels[$channelName]->attach($from);
                        $from->send("Vous avez rejoint le canal $channelName.");
                    }
                    break;
                // ...
            }
        }


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

                    $client->send($messageData);

                    // Condition pour envoyer a ceux qui ont le meme username
                    // $clientUserData = $this->usernames[$client->resourceId] ?? null;
                    // if ($clientUserData && $fromUsername === $clientUserData['username']) {
                    //     $client->send($messageData);
                    // }
                }
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
    
            // Envoyer un message de déconnexion à tous les clients
            $disconnectionMessage = [
                "username" => $username,
                "id" => $id,
                "message" => "S'est déconnecté."
            ];
            $this->sendToAllClients($disconnectionMessage);
    
            echo "Connection ({$conn->resourceId}) has disconnected - Username: $username, ID: $id\n";
    
            // Supprimez l'utilisateur de la liste $usernames
            unset($this->usernames[$conn->resourceId]);
    
            // Mise à jour de $connectedUsers pour supprimer l'utilisateur déconnecté
            $connectedUsers = $this->getAllConnectedUsersData();

            // Envoyez la nouvelle liste des utilisateurs connectés à tous les clients
            $this->sendToAllClients(["connected_users" => $connectedUsers]);

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

    // Cette fonction envoie un message à tous les clients connectés
    private function sendToAllClients($message) {
        foreach ($this->clients as $client) {
            $client->send(json_encode($message));
        }
    }

    // Cette fonction récupere tout les utilisateurs connectés au server 
    private function getAllConnectedUsersData() {
        $connectedUsers = [];
    
        foreach ($this->usernames as $userData) {
            $connectedUsers[] = $userData;
        }
    
        return $connectedUsers;
    }
    
    // Cette fonction envoie tout les utilisateurs connectés au server
    private function sendConnectedUsersDataToUser(ConnectionInterface $userConnection) {
        $connectedUsers = $this->getAllConnectedUsersData();
        $userConnection->send(json_encode(["connected_users" => $connectedUsers]));
    }
    

}