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
    <p id="user-count">Utilisateurs à portée: 0</p>
    <a href="../config/logs.html">LOGS</a>
        <div class="messages-container">
            <div class="received-message-container">
                <img class="other-users-img" src="../assets/images/user2.jpg" alt="">
                <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
            </div>
            <div class="sent-message-container">
                <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
                <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
            </div>
            
        </div>

        <div class="send-container">
            <div class="send-message-container"><input type="text" name="sendMessage" id="sendMessage" placeholder="Ecrivez votre message ici"></div>
            <button class="send-button">Envoyer</button>
        </div>

    </div>


    <script>
        var sendButton = document.querySelector('.send-button');
        var sendBar = document.querySelector('#sendMessage');
        const messagesContainer = document.querySelector('.messages-container');

        function scrollToBottom() {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }

        window.addEventListener('load', scrollToBottom);

        // Simule un clic lorsque la touche "Entrée" est enfoncée.
        sendBar.addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
            sendButton.click();
            }
        });

        // Fonction pour ajouter un message qui viens d'etre envoyé
        function appendSentMessage(message) {
            var message = sendBar.value;

            var messageContainer = document.createElement('div');
            messageContainer.className = 'sent-message-container';

            var userImg = document.createElement('img');
            userImg.className = 'other-users-img';
            userImg.src = '../assets/images/user2.jpg';
            userImg.alt = '';

            var messageText = document.createElement('p');
            messageText.className = 'sent-message';
            messageText.textContent = message;
            
            messagesContainer.appendChild(messageContainer);
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(messageText);

            conn.send(message);
            scrollToBottom();
        }

        sendButton.addEventListener('click', function() {
            var message = sendBar.value; // Obtiens la valeur du champ de texte
            appendSentMessage(message); // Ajoute le message localement
            sendBar.value = '';
        });


     // Fonction pour ajouter un message reçu au format souhaité
        function appendReceivedMessage(message) {
            var messageContainer = document.createElement('div');
            messageContainer.className = 'received-message-container';

            var userImg = document.createElement('img');
            userImg.className = 'other-users-img';
            userImg.src = '../assets/images/user2.jpg';
            userImg.alt = '';

            var messageText = document.createElement('p');
            messageText.className = 'received-message';
            messageText.textContent = message;

            messagesContainer.appendChild(messageContainer);
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(messageText);

            scrollToBottom();
        }

        // Connection websocket
        // <?php $port = getenv('PORT') ? getenv('PORT') : 8080; ?>
        // username = '<?php echo $_SESSION['user_firstName']; ?>';
        username = 'Nicolas';

        // Connection Heroku
        var conn = new WebSocket('wss://hello-voisins-25649417130d.herokuapp.com:<?php echo $_SERVER['PORT'] ?>?username=' + username);
        // Connection en local
        // var conn = new WebSocket('ws://localhost:8080?username=' + username);

        conn.onopen = function(e) {
            console.log("Connection established!");
        };

        conn.onmessage = function(e) {
    var receivedMessage = e.data;

    try {
        var data = JSON.parse(receivedMessage);
        if (data.user_count !== undefined) {
            // Update the user count in your client interface
            document.getElementById("user-count").textContent = "Utilisateurs à portée: " + (data.user_count - 1);
        }
    } catch (error) {
        // Si une erreur se produit lors de l'analyse du JSON, cela signifie que c'est un message texte simple.
        // Vous pouvez alors exécuter appendReceivedMessage pour afficher ce message.
        appendReceivedMessage(receivedMessage);
    }
};


        conn.onerror = function(error) {
            console.error("WebSocket error: " + error);
        };

        conn.onclose = function(event) {
            if (event.wasClean) {
                console.log("WebSocket connection closed cleanly, code=" + event.code + ", reason=" + event.reason);
            } else {
                console.error("WebSocket connection abruptly closed");
            }
        };

        window.addEventListener("beforeunload", function() {
            conn.send('l\'utilisateur s\'est déconnecté');
        });
    </script>

    

    <script src="../assets/js/chat-scroll-auto.js"></script>
    <script src="../assets/js/show-user.js"></script>
    
</body>
</html>