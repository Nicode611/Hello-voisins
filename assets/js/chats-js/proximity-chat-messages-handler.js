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

        
        // Fonction pour afficher le message de connexion
        function appendConnectionMessage(username, message, profileImgPath) {
            var messageContainer = document.createElement('div');
            messageContainer.className = 'received-message-container';
            
            var userImg = document.createElement('img');
            userImg.className = 'other-users-img';
            userImg.src = '../' + profileImgPath;
            userImg.alt = '';

            var idText = document.createElement('p');
            idText.className = 'other-users-id hide';
            idText.textContent = id;

            var receivedMessage = document.createElement('div');
            receivedMessage.className = 'received-message';

            var usernameText = document.createElement('span');
            usernameText.className = 'received-message-username';
            usernameText.textContent = username;

            var messageText = document.createElement('p');
            messageText.className = 'received-message-content';
            messageText.textContent = message;

            messagesContainer.appendChild(messageContainer);
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(idText);
            messageContainer.appendChild(receivedMessage);
            receivedMessage.appendChild(usernameText);
            receivedMessage.appendChild(messageText);

            scrollToBottom();
        }


        // Fonction pour ajouter le message qu'on viens d'envoyer
        function appendSentMessage(message, profileImgPath) {
            var message = sendBar.value;

            var messageContainer = document.createElement('div');
            messageContainer.className = 'sent-message-container';

            var userImg = document.createElement('img');
            userImg.className = 'self-user-img';
            userImg.src = '../' + profileImgPath;
            userImg.alt = '';

            var messageText = document.createElement('p');
            messageText.className = 'sent-message';
            messageText.textContent = message;
            
            messagesContainer.appendChild(messageContainer);
            messageContainer.appendChild(userImg);
            messageContainer.appendChild(messageText);

            scrollToBottom();
        }

        


     // Fonction pour ajouter un message reçu au format souhaité
    function appendReceivedMessage(username, message, id, profileImgPath, userLatitude, userLongitude, messageLatitude, messageLongitude) {
        if (userLatitude !== null) {
            const distance = calculDistance(userLatitude, userLongitude, messageLatitude, messageLongitude);
        }
        console.log(username, message, id, profileImgPath, userLatitude, userLongitude, messageLatitude, messageLongitude)

        var messageContainer = document.createElement('div');
        messageContainer.className = 'received-message-container';

        var userImg = document.createElement('img');
        userImg.className = 'other-users-img';
        userImg.src = '../' + profileImgPath;
        userImg.alt = '';

        var idText = document.createElement('p');
        idText.className = 'other-users-id hide';
        idText.textContent = id;

        var receivedMessage = document.createElement('div');
        receivedMessage.className = 'received-message';

        var usernameText = document.createElement('span');
        usernameText.className = 'received-message-username';

        if (userLatitude !== null) {
            usernameText.textContent = username + " " + distance.toFixed(0) + "m";
        } else {
            usernameText.textContent = username ;
        }
        
        var messageText = document.createElement('p');
        messageText.className = 'received-message-content';
        messageText.textContent = message;

        console.log(usernameText.textContent, message, id, profileImgPath, userLatitude, userLongitude, messageLatitude, messageLongitude)


        messagesContainer.appendChild(messageContainer);
        messageContainer.appendChild(userImg);
        messageContainer.appendChild(idText);
        messageContainer.appendChild(receivedMessage);
        receivedMessage.appendChild(usernameText);
        receivedMessage.appendChild(messageText);

        scrollToBottom();
    }

    // Messages du serveur
    function appendReceivedServerMessage(message) {
        var messageContainer = document.createElement('div');
        messageContainer.className = 'received-message-container';

        var receivedMessage = document.createElement('div');
        receivedMessage.className = 'received-message';

        var messageText = document.createElement('span');
        messageText.className = 'received-message-username';
        messageText.textContent = message;

        messagesContainer.appendChild(messageContainer);
        messageContainer.appendChild(receivedMessage);
        receivedMessage.appendChild(messageText);

        scrollToBottom();
    }


    // Fonction pour mettre a jour le compteur d'utilisateurs
    function updateUserCount(count) {
        var userCountElement = document.querySelector('#user-count');
        userCountElement.textContent = count;
    }

    // Fonction pour afficher les utilisateurs connectés
    function processConnectedUsersData(userId, username, profileImgPath) {
        var allUsersList = document.querySelector('.all-users-list');

        var allUsers = document.createElement('div');
        allUsers.className = 'all-users';
        
        var userImg = document.createElement('img');
        userImg.className = 'all-users-img';
        userImg.src = '../' + profileImgPath;
        userImg.alt = '';

        var allUsersId = document.createElement('span')
        allUsersId.className = 'other-users-id hide';
        allUsersId.textContent = userId;

        var allUsersName = document.createElement('span')
        allUsersName.className = 'all-users-name';
        allUsersName.textContent = username;

        allUsers.appendChild(userImg);
        allUsers.appendChild(allUsersId);
        allUsers.appendChild(allUsersName);

        allUsersList.appendChild(allUsers);
    }

    // fonction pour ajouter un utilisateur de la liste coté client 
    function addUserToList(userId, username, profileImgPath) {
        var allUsersList = document.querySelector('.all-users-list');
    
        // Vérifiez si un élément .all-users contient déjà un .other-users-id avec le même texte
        var userExists = [...allUsersList.querySelectorAll('.all-users')].some(function(user) {
            var idElement = user.querySelector('.other-users-id');
            return idElement && idElement.textContent === userId;
        });
    
        if (!userExists) {
            var allUsers = document.createElement('div');
            allUsers.className = 'all-users';
    
            var userImg = document.createElement('img');
            userImg.className = 'all-users-img';
            userImg.src = '../' + profileImgPath;
            userImg.alt = '';

            var allUsersId = document.createElement('span');
            allUsersId.className = 'other-users-id hide';
            allUsersId.textContent = userId;
    
            var allUsersName = document.createElement('span');
            allUsersName.className = 'all-users-name';
            allUsersName.textContent = username;
    
            allUsers.appendChild(userImg);
            allUsers.appendChild(allUsersId);
            allUsers.appendChild(allUsersName);
    
            allUsersList.appendChild(allUsers);
        }
    }
    

    // Fonction pour supprimer un utilisateur de la liste côté client
    function removeUserFromList(userId) {
        var userElements = document.querySelectorAll('.all-users');
        userElements.forEach(function(userElement) {
            var idSpan = userElement.querySelector('.other-users-id');
            if (idSpan && idSpan.textContent === userId) {
                userElement.remove(); // Supprime l'élément de la liste
            }
        });
    }

    function calculDistance(lat1, lon1, lat2, lon2) {
        const rayonTerre = 6371; // Rayon moyen de la Terre en kilomètres
    
        // Conversion des degrés en radians
        const radLat1 = (Math.PI * lat1) / 180;
        const radLon1 = (Math.PI * lon1) / 180;
        const radLat2 = (Math.PI * lat2) / 180;
        const radLon2 = (Math.PI * lon2) / 180;
    
        // Différence de coordonnées
        const deltaLat = radLat2 - radLat1;
        const deltaLon = radLon2 - radLon1;
    
        // Formule de la haversine
        const a =
            Math.sin(deltaLat / 2) ** 2 +
            Math.cos(radLat1) * Math.cos(radLat2) * Math.sin(deltaLon / 2) ** 2;
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    
        // Distance en mètres
        const distance = rayonTerre * c * 1000;
    
        return distance;
    }


