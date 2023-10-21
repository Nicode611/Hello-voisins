<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/proximity-chat.css">
    
    
    <title>Chat de proximité</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>


    <div class="main-content">
        <div class="all-users-container">
            <p id="user-count"></p>
            <div class="all-users-list">
                <!-- <div class="all-users">
                    <span class="other-users-id">1</span>
                    <img class="all-users-img" src="../assets/images/user2.jpg" alt="">
                    <span class="all-users-name">Nicolas</span>
                </div> -->
            </div>
        </div>

        <div class="messages-container">
            
        </div>

        <div class="send-container">
            <div class="send-message-container"><input type="text" name="sendMessage" id="sendMessage" placeholder="Ecrivez votre message ici"></div>
            <button class="send-button">Envoyer</button>
        </div>

    </div>


    <script>
        
        // Connection websocket
        username = '<?php echo $_SESSION['user_firstName']; ?>';
        myId = ' <?php echo $id = $_SESSION['user_id']; ?>';
        // Connection online
        try {
            var conn = new WebSocket('wss://hello-voisins.com/websocket?username=' + username + '&id=' + myId);
        } catch (error) {
            console.error('Erreur lors de la création de la connexion WebSocket :', error);
        }

        // Connection en local
        // var conn = new WebSocket('ws://localhost:8888?username=' + username + '&id=' + myId);

        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
            var receivedMessage = e.data;

            try {
                var data = JSON.parse(receivedMessage);

                if (data.user_count !== undefined) {
                    // C'est un message de compteur d'utilisateurs
                    updateUserCount(data.user_count); // Fonction pour mettre à jour le compteur
                } else if (data.connected_users !== undefined) {
                    // C'est un message contenant les données des utilisateurs connectés
                    processConnectedUsersData(data.connected_users);
                } else if (data.username !== undefined && data.message !== undefined && data.id !== undefined) {
                    // C'est un message texte
                    // Vous pouvez maintenant utiliser data.username pour le nom de l'utilisateur
                    // et data.message pour le message.
                    // Par exemple, vous pouvez appeler une fonction pour ajouter le message au chat.
                    appendReceivedMessage(data.username, data.message, data.id);
                }
            } catch (error) {
                // Si une erreur se produit lors de l'analyse du JSON, cela signifie que c'est un message texte simple.
                // Vous pouvez alors exécuter appendReceivedMessage pour afficher ce message.
                appendReceivedMessage(receivedMessage);
            }

            // Vérifiez si c'est un message de déconnexion et supprimez l'utilisateur de la liste
            if (data.message === "S'est déconnecté.") {
                removeUserFromList(data.id);
            }

            if (data.message === "S'est connecté.") {
                addUserToList(data.id, data.username);
            }
        };


        conn.onerror = function (event) {
            console.error("WebSocket error: ", event);
            console.log("Event type:", event.type);
            console.log("Event message:", event.message);
            console.log("Event target:", event.target);
            // ... et ainsi de suite
        };

        conn.onclose = function(event) {
            if (event.wasClean) {
                console.log("WebSocket connection closed cleanly, code=" + event.code + ", reason=" + event.reason);
            } else {
                console.error("WebSocket connection abruptly closed");
            }

            const disconnectionData = {
                username: username,
                id: myId,
                message: "S'est déconnecté."
            };
            
            conn.send(JSON.stringify(disconnectionData));
        };
    </script>

    <!-- Fenetre modale users -->
    <div class="popup-user">
        <div class="popup-user-container1">
            <img src="../assets/images/user2.jpg" alt="">
            <div>
                <span class="popup-first_name">Bruce</span>
                <span class="popup-last_name">Wils</span>
            </div>
        </div>
        <!-- <div class="popup-user-container2">
            <span>adresse adresse ad ress 64512 ADRESSE</span>
        </div> -->
        <div class="popup-user-container3">
            <svg fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>
        </div>
    </div>
    <div class="overlay"></div>


    <script src="../assets/js/chat-scroll-auto.js"></script>
    <script src="../assets/js/show-user.js"></script>
    <script src="../assets/js/proximity-chat-messages-handler.js"></script>
</body>
</html>