var selfId = document.querySelector(".self-user-id").textContent;

if (localStorage.getItem('geolocationPermission')) {
        
            // Récupère la localisation
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Enregistre l'autorisation dans le stockage local
            localStorage.setItem('geolocationPermission', 'granted');

            sendLocation(latitude, longitude);
    
            
        } else {
            // Si non, demande l'autorisation
            navigator.geolocation.getCurrentPosition(function(position) {
                // Récupère la localisation
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;

                // Enregistre l'autorisation dans le stockage local
                localStorage.setItem('geolocationPermission', 'granted');

                sendLocation(latitude, longitude);
            }, function(error) {
                var mainContent = document.querySelector('.main-content');
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        // L'utilisateur a refusé la demande de géolocalisation
                        mainContent.innerText = 'L\'utilisateur a refusé la géolocalisation.';
                        console.log("L'utilisateur a refusé la géolocalisation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        // La position n'a pas pu être déterminée
                        mainContent.innerText = 'La position n\'a pas pu être déterminée.';
                        console.log("La position n'a pas pu être déterminée.");
                        break;
                    case error.TIMEOUT:
                        // La demande de géolocalisation a expiré
                        mainContent.innerText = 'La demande de géolocalisation a expiré.';
                        console.log("La demande de géolocalisation a expiré.");
                        break;
                    case error.UNKNOWN_ERROR:
                        // Une erreur inconnue s'est produite
                        mainContent.innerText = 'Une erreur inconnue s\'est produite.';
                        console.log("Une erreur inconnue s'est produite.");
                        break;
                }
            })
        }
        

    function sendLocation(latitude, longitude) {
        // Envoie la localisation a la BDD
        $.ajax({
            type: "POST",
            url: "../scripts/infos-scripts/send-loc.php",
            data: { 
                latitude: latitude,
                longitude: longitude
            },
            success: function(response) {
                
                // Affiche les anciens messages
                $.ajax({
                    type: "GET",
                    url: "../scripts/global-chat-scripts/show-old-global-chat-messages.php",
                    
                    success: function(response) {
                        
                        var messages = JSON.parse(response);

                        messages.forEach(function(message) {

                            if (selfId == message.sender_id) {
                                ShowOldsSelfMessages(message.message, message.sender_profile_img_path);
                            } else {
                                showOldsMessages(message.sender_first_name, message.message, message.sender_id, message.sender_profile_img_path);
                            }
                        });

                        validationToConnect(latitude, longitude);
                    }
                });
            }
        });
    }
    

    function showOldsMessages(username, message, id, profileImgPath) {
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
    }

    function ShowOldsSelfMessages(message, profileImgPath) {

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
    }