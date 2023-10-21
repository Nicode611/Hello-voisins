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
        <div class="messages-container">
            
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

        function appendConnectionMessage(username, message) {
            var messageContainer = document.createElement('div');
            messageContainer.className = 'received-message-container';

            var idText = document.createElement('p');
            idText.className = 'other-users-id';
            idText.textContent = id;

            var userImg = document.createElement('img');
            userImg.className = 'other-users-img';
            userImg.src = '../assets/images/user2.jpg';
            userImg.alt = '';

            var receivedMessage = document.createElement('div');
            receivedMessage.className = 'received-message';

            var usernameText = document.createElement('span');
            usernameText.className = 'received-message-username';
            usernameText.textContent = username;

            var messageText = document.createElement('p');
            messageText.className = 'received-message-content';
            messageText.textContent = message;

            messagesContainer.appendChild(messageContainer);
            messageContainer.appendChild(idText); // Ajoutez l'ID de l'utilisateur
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(receivedMessage);
            receivedMessage.appendChild(usernameText);
            receivedMessage.appendChild(messageText);

        scrollToBottom();

            scrollToBottom();
        }


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
    function appendReceivedMessage(username, message, id) {
        var messageContainer = document.createElement('div');
        messageContainer.className = 'received-message-container';

        var idText = document.createElement('p');
        idText.className = 'other-users-id';
        idText.textContent = id;

        var userImg = document.createElement('img');
        userImg.className = 'other-users-img';
        userImg.src = '../assets/images/user2.jpg';
        userImg.alt = '';

        var receivedMessage = document.createElement('div');
        receivedMessage.className = 'received-message';

        var usernameText = document.createElement('span');
        usernameText.className = 'received-message-username';
        usernameText.textContent = username;

        var messageText = document.createElement('p');
        messageText.className = 'received-message-content';
        messageText.textContent = message;

        messagesContainer.appendChild(messageContainer);
        messageContainer.appendChild(idText); // Ajoutez l'ID de l'utilisateur
        messageContainer.appendChild(userImg);
        messageContainer.appendChild(receivedMessage);
        receivedMessage.appendChild(usernameText);
        receivedMessage.appendChild(messageText);

        scrollToBottom();
    }

    function updateUserCount(count) {
        // Mettez à jour l'affichage du compteur d'utilisateurs
        var userCountElement = document.querySelector('#user-count');
        userCountElement.textContent = 'Utilisateurs connectés ' + count;
    }



        // Connection websocket
        username = '<?php echo $_SESSION['user_firstName']; ?>';
        myId = ' <?php echo $id = $_SESSION['user_id']; ?>';
        // Connection Heroku
        // try {
        //     var conn = new WebSocket('wss://hello-voisins.com/websocket?username=' + username + '&id=' + myId);
        // } catch (error) {
        //     console.error('Erreur lors de la création de la connexion WebSocket :', error);
        // }

        // Connection en local
        var conn = new WebSocket('ws://localhost:8888?username=' + username + '&id=' + myId);

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
</body>
</html>