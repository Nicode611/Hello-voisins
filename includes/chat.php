<!DOCTYPE html>
<link rel="stylesheet" href="../assets/css/global.css">
<link rel="stylesheet" href="../assets/css/chat.css">

<body>
    
    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <div class="main-content">
        
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