<?php
    // // // Code pour lancer le serveur Ratchet en PHP
    // exec('php ../config/server.php > /dev/null 2>&1 &');
    
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

    <script>
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
            conn.send('hello world !');
        };
    
        conn.onmessage = function(e) {
            console.log(e.data);
        };

        window.addEventListener("beforeunload", function() {
            conn.send('Me suis deco :(');
        });

        
    </script>

    <div class="main-content">
        <div class="received-message-container">
            <img class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="received-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="received-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="received-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="received-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="received-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="received-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>
        <div class="sent-message-container">
            <img  class="other-users-img" src="../assets/images/user2.jpg" alt="">
            <p class="sent-message">lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala lorem ipsum lalali lalala</p>
        </div>

        <div class="white-space"></div>
        

        <div class="send-container">
            <div class="send-message-container"><input type="text" name="sendMessage" id="sendMessage" placeholder="Ecrivez votre message ici"></div>
            <button class="send-button">Envoyer</button>
        </div>

    </div>

    

    <script src="../assets/js/chat-scroll-auto.js"></script>
    <script src="../assets/js/show-user.js"></script>
    
</body>
</html>