<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use mysqli;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $usernames;
    protected $channels;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        $this->usernames = [];
        $this->channels = [];
    }

    // Étape 1 : Lorsqu'une nouvelle connexion WebSocket est établie
    public function onOpen(ConnectionInterface $conn) {
        parse_str($conn->httpRequest->getUri()->getQuery(), $queryParameters);

        $username = $queryParameters['username'] ?? null;
        $id = $queryParameters['id'] ?? null;
        $channelName = $queryParameters['channelName'] ?? null;
        $profileImgPath = $queryParameters['profileImgPath'] ?? null;

        if ($username && $id) {
            $userData = [
                "username" => $username,
                "id" => $id,
                "channel" => $channelName,
                "profileImgPath" => $profileImgPath
            ];

            $this->usernames[$conn->resourceId] = $userData;

            if (isset($channelName)) {
                if (!isset($this->channels[$channelName])) {
                    $this->channels[$channelName] = new \SplObjectStorage();
                }
                $this->channels[$channelName]->attach($conn);

                // Envoie un message de confirmation de rejoindre le canal
                // $conn->send("Vous avez rejoint le canal $channelName.");

                // Envoyer la liste des utilisateurs connectés dans le canal au nouvel utilisateur
                $this->sendConnectedUsersDataToUserInChannel($conn, $channelName);
            }

            // Envoyer un message de connexion au canal
            $this->sendConnectionMessageToChannel($username, $id, $channelName, $profileImgPath);

            // Compter tous les utilisateurs connectés
            $countAllUsers = count($this->channels[$channelName]);
            // On envoie le compteur au channel grace a la fonction
        $this->sendUserCountToChannel($channelName, $countAllUsers);

            echo "Nouvelle connexion ! ({$conn->resourceId}) - Username: $username, ID: $id, Channel: $channelName\n";
        }
    }

    // Étape 2 : Lorsqu'un message est reçu d'un client
    public function onMessage(ConnectionInterface $from, $msg) {
        $fromUserData = $this->usernames[$from->resourceId] ?? null;

        if ($fromUserData) {
            $fromUsername = $fromUserData['username'];
            $fromId = $fromUserData['id'];
            $fromProfileImgPath = $fromUserData['profileImgPath'];

            $messageData = [
                "username" => $fromUsername,
                "id" => $fromId,
                "profileImgPath" => $fromProfileImgPath,
                "message" => $msg
            ];

            if (isset($fromUserData['channel'])) {
                $channelName = $fromUserData['channel'];

                if ($channelName == "Global") {
                    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
                    $db_user = "331032";
                    $db_pass = "Beta2k15";
                    $db_name = "hello-voisins_2023";
                    $connexion = new mysqli($db_host, $db_user, $db_pass, $db_name);

                    if ($connexion->connect_error) {
                        die("La connexion à la base de données a échoué : " . $connexion->connect_error);
                    }

                    $globalChatMessage =  $messageData["message"];
                    $globalChatSenderId = $messageData["id"];

                    $query = "INSERT INTO global_chat_messages (message, sender_id) VALUES (?, ?)";
                    $stmt = $connexion->prepare($query);

                    if ($stmt === false) {
                        die("Erreur de préparation de la requête : " . $connexion->error);
                    }

                    // Liaison des paramètres
                    $stmt->bind_param('ss', $globalChatMessage, $globalChatSenderId);

                    $stmt->execute();

                    $connexion->close();

                }

                $this->sendToChannel($channelName, $messageData);
            }
        }
    }

    // Étape 3 : Lorsqu'une connexion se ferme
    public function onClose(ConnectionInterface $conn) {
        $userData = $this->usernames[$conn->resourceId] ?? null;

        if ($userData) {
            $username = $userData['username'];
            $id = $userData['id'];
            $channelName = $userData['channel'];
            $profileImgPath = $userData['profileImgPath'];

            // Envoyer un message de déconnexion au canal
            $this->sendDisconnectionMessageToChannel($username, $id, $channelName, $profileImgPath);

            

            // Envoyer la liste des utilisateurs connectés dans le canal au nouvel utilisateur
            $this->sendConnectedUsersDataToUserInChannel($conn, $channelName);

            // Supprime l'utilisateur de la liste
            unset($this->usernames[$conn->resourceId]);
        }


        // Détacher la connexion fermée de la liste des clients
        $this->channels[$channelName]->detach($conn);

        // Compter tous les utilisateurs connectés
        $countAllUsers = count($this->channels[$channelName]);
        // On envoie le compteur au channel grace a la fonction
        $this->sendUserCountToChannel($channelName, $countAllUsers);

    }

    // Étape 4 : En cas d'erreur sur une connexion
    public function onError(ConnectionInterface $conn, \Exception $e) {
        $username = $this->usernames[$conn->resourceId]['username'] ?? 'N/A';
        echo "WebSocket Error - Username: $username, Error Message: {$e->getMessage()}\n";
        $conn->close();
    }

    // Fonction utilitaire pour envoyer le nombre total d'utilisateurs connectés à un canal
    private function sendUserCountToChannel($channelName, $count) {
        if (isset($this->channels[$channelName])) {
            $countMessage = ["user_count" => $count];
            $this->sendToChannel($channelName, $countMessage);
        }
    }


    // Fonction utilitaire pour envoyer un message à un canal spécifique
    private function sendToChannel($channelName, $message) {
        if (isset($this->channels[$channelName])) {
            $messageData = json_encode($message);
            foreach ($this->channels[$channelName] as $client) {
                $success = $client->send($messageData);
                if (!$success) {
                    echo "Sur le channel ". $channelName ." le message n'a pas été envoyé par : ". $client->resourceId . " Le message = " . $messageData;
                } else {
                    // echo "Sur le channel ". $channelName ." le message a été envoyé par : ". $client->resourceId . " Le message = " . $messageData;
                };
            }
        }
    }

    // Fonction utilitaire pour envoyer un message de connexion au canal
    private function sendConnectionMessageToChannel($username, $id, $channelName, $profileImgPath) {
        $connectionMessage = [
            "username" => $username,
            "id" => $id,
            "channel" => $channelName,
            "profileImgPath" => $profileImgPath, 
            "message" => "S'est connecté."
        ];
        $this->sendToChannel($channelName, $connectionMessage);
    }

    // Fonction utilitaire pour envoyer un message de déconnexion au canal
    private function sendDisconnectionMessageToChannel($username, $id, $channelName, $profileImgPath) { 
        $disconnectionMessage = [
            "username" => $username,
            "id" => $id,
            "channel" => $channelName,
            "profileImgPath" => $profileImgPath,
            "message" => "S'est déconnecté."
        ];
        $this->sendToChannel($channelName, $disconnectionMessage);
    }

    // Fonction utilitaire pour envoyer la liste des utilisateurs connectés dans un canal à un utilisateur
    private function sendConnectedUsersDataToUserInChannel(ConnectionInterface $userConnection, $channelName) {
        $connectedUsers = $this->getAllConnectedUsersDataInChannel($channelName);
        
        $userConnection->send(json_encode(["connected_users" => $connectedUsers]));
    }

    // Fonction utilitaire pour récupérer la liste des utilisateurs connectés dans un canal
    private function getAllConnectedUsersDataInChannel($channelName) {
        $connectedUsers = [];
    
        if (isset($this->channels[$channelName])) {
            foreach ($this->channels[$channelName] as $userConnection) {
                $userData = $this->usernames[$userConnection->resourceId];
                $connectedUsers[] = $userData;
            }
        }
        // echo" Les connected Users : ". $connectedUsers ." ";
        return $connectedUsers;
    }
}