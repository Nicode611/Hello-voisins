<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/proximity-chat.css">
    <link rel="stylesheet" href="../assets/css/private-chats.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Group Chat</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <?php
        // Si on a le nom du channel ...
        $channelName = $_GET['channelName'] ?? null;
        $channelNameToShow = $_GET['channelNameToShow'] ?? null;

        if ($channelName) { ?>
            
            <script>
                // On crée la connexion websocket
                channelName = '<?php echo $channelName ?>';
                channelNameToShow = '<?php echo $channelNameToShow ?>';
                username = '<?php echo $_SESSION['user_firstName']; ?>';
                myId = ' <?php echo $id = $_SESSION['user_id']; ?>';
                profileImgPath = '<?php echo $_SESSION['user_profile_img_path']; ?>';
                // Connection online
                // var conn = new WebSocket('wss://hello-voisins.com/websocket?username=' + username + '&id=' + myId + '&channelName=' + channelName + '&profileImgPath=' + profileImgPath);
                // Connection en local
                var conn = new WebSocket('ws://localhost:8888?username=' + username + '&id=' + myId + '&channelName=' + channelName + '&profileImgPath=' + profileImgPath);

                conn.onopen = function(e) {
                    console.log('Connexion établie');
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
                } else if (data.username !== undefined && data.message !== undefined && data.profileImgPath !== undefined && data.id !== myId) {
                    // C'est un message texte
                    // Vous pouvez maintenant utiliser data.username pour le nom de l'utilisateur
                    // et data.message pour le message.
                    // Par exemple, vous pouvez appeler une fonction pour ajouter le message au chat.
                    appendReceivedMessage(data.username, data.message, data.id, data.profileImgPath);
                    if (data.message === "S'est déconnecté.") {
                        removeUserFromList(data.id);
                    }

                    if (data.message === "S'est connecté.") {
                        addUserToList(data.id, data.username, data.profileImgPath);
                    }
                }
            } catch (error) {
                // Si une erreur se produit lors de l'analyse du JSON, cela signifie que c'est un message texte simple.
                // Pour modifier le message de connexion au channel
                appendReceivedServerMessage(receivedMessage);
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

                    conn.close();
                };

            </script>
    <?php
        }
    ?>

    <div class="chat-name-container-mobile">
        <span class="chat-name"><?php echo $channelNameToShow ?></span>
    </div>
    <div class="main-content">
        <div class="chat-name-container">
            <span class="chat-name"><?php echo $channelNameToShow ?></span>
        </div>
        <div class="all-users-container">
            <p id="user-count"></p>
            <div class="all-users-list">
            </div>
        </div>

        <div class="messages-container">
            
        </div>

        <div class="send-container">
            <div class="send-message-container"><input type="text" name="sendMessage" id="sendMessage" placeholder="Ecrivez votre message ici"></div>
            <button class="send-button">Envoyer</button>
        </div>

    </div>

    <!-- Fenetre modale users -->
    <div class="popup-user">
    </div>


    <script src="../assets/js/chats-js/chat-scroll-auto.js"></script>
    <script src="../assets/js/chats-js/show-user.js"></script>
    <script src="../assets/js/chats-js/proximity-chat-messages-handler.js"></script>
    <script src="../assets/js/infos-js/get-loc.js"></script>
</body>
</html>