<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/proximity-chat.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Chat de proximité</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <script src="../assets/js/infos-js/get-loc.js"></script>

    <div class="main-content">

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

    <script>

        // Calcul de la distance
        function distance(lat1, lon1, lat2, lon2) {
            // Rayon de la Terre en mètres
            var R = 6371000;
            var dLat = (lat2 - lat1) * Math.PI / 180;
            var dLon = (lon2 - lon1) * Math.PI / 180;
            var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
            var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            var distance = R * c; // Distance en mètres
            return distance;
        }

        
        // Connection websocket
        channelName = 'Global'
        username = '<?php echo $_SESSION['user_firstName']; ?>';
        myId = ' <?php echo $id = $_SESSION['user_id']; ?>';
        profileImgPath = '<?php echo $_SESSION['user_profile_img_path']; ?>';
        channelId = "";
        userLatitude = <?php echo $_SESSION['user_latitude'];?>;
        userLongitude = <?php echo $_SESSION['user_longitude'];?>;
        console.log(userLatitude);
        console.log(userLongitude);
        
        // Connection online
        var conn = new WebSocket('wss://hello-voisins.com/websocket?username=' + username + '&id=' + myId + '&profileImgPath=' + profileImgPath + '&channelName=' + channelName + '&channelId=' + channelId);
        // Connection en local
        // var conn = new WebSocket('ws://localhost:8888?username=' + username + '&id=' + myId + '&profileImgPath=' + profileImgPath + '&channelName=' + channelName + '&channelId=' + channelId);

        conn.onopen = function(e) {
            console.log("Connection etablie!");
        };

        conn.onmessage = function(e) {
            var receivedMessage = e.data;

            try {
                var data = JSON.parse(receivedMessage);

                // C'est un message de compteur d'utilisateurs
                if (data.user_count !== undefined) {
                    updateUserCount(data.user_count);

                // C'est un message contenant les données des utilisateurs connectés
                } else if (data.connected_users !== undefined && (distance(userLatitude, userLongitude, data.userLatitude, data.userLongitude) <= 500)) {
                    processConnectedUsersData(data.connected_users);

                } else if (data.username !== undefined && data.message !== undefined && data.profileImgPath !== undefined && data.id !== myId) {
                    
                    if (distance(userLatitude, userLongitude, data.messageLatitude, data.messageLongitude) <= 500) {
                        console.log(userLatitude, userLongitude, data.messageLatitude, data.messageLongitude);
                        console.log("La position 2 est dans un rayon de 500 mètres de la position 1.");
                        appendReceivedMessage(data.username, data.message, data.id, data.profileImgPath);
                    } else {
                        console.log(userLatitude, userLongitude, data.messageLatitude, data.messageLongitude);
                        console.log("La position 2 n'est pas dans un rayon de 500 mètres de la position 1.");
                    }

                    // Si c'est message de déconnexion et qu'on est à bonne distance
                    if (data.message === "S'est déconnecté." && (distance(userLatitude, userLongitude, data.userLatitude, data.userLongitude) <= 500)) {
                        removeUserFromList(data.id);
                    }

                    // Si c'est message de connexion et qu'on est à bonne distance
                    if (data.message === "S'est connecté." && (distance(userLatitude, userLongitude, data.userLatitude, data.userLongitude) <= 500)) {
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
        };
    </script>

    <!-- Fenetre modale users -->
    <div class="popup-user">
    </div>


    <script src="../assets/js/chats-js/chat-scroll-auto.js"></script>
    <script src="../assets/js/chats-js/show-user.js"></script>
    <script src="../assets/js/chats-js/proximity-chat-messages-handler.js"></script>
    
</body>
</html>