<?php
    // // // Code pour lancer le serveur Ratchet en PHP
    exec('php ../config/server.php > /dev/null 2>&1 &');
    
?>




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
            var message = sendBar.value; // Obtenir la valeur du champ de texte
            appendSentMessage(message); // Ajouter le message localement
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

        <?php $port = $_SERVER['PORT'] ?>
        var conn = new WebSocket('wss://hello-voisins-25649417130d.herokuapp.com:2650');
        conn.onopen = function(e) {
            console.log("Connection established!");
            
        };
    
        conn.onmessage = function(e) {
            var receivedMessage = e.data;
            appendReceivedMessage(receivedMessage); // Afficher le message reçu
        };

        window.addEventListener("beforeunload", function() {
            conn.send('Me suis deco :(');
        });
    </script>

    

    <script src="../assets/js/chat-scroll-auto.js"></script>
    <script src="../assets/js/show-user.js"></script>
    
</body>
</html>