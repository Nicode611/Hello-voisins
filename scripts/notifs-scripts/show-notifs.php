<?php

$includeFile = "../config/db/db.php";
if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$selfId = $_SESSION['user_id'];

$sqlNotifsContacts = "SELECT * FROM contacts WHERE added_user_id = $selfId AND statut = 'waiting'";

$resultNotifsContacts = $conn->query($sqlNotifsContacts);

// On récupere toutes les notifs
if ($resultNotifsContacts->num_rows > 0) {
    while ($rowNotifsContacts = $resultNotifsContacts->fetch_assoc()) {

        $notifsAddedByUserId = $rowNotifsContacts["added_by_user_id"];
        $notifsContactStatut = $rowNotifsContacts["statut"];
        $notifsContactMessage = 'Souhaite vous ajouter à ses contacts';
        
        $sqlUsers = "SELECT first_name, last_name FROM users WHERE id = $notifsAddedByUserId";

        $resultUsers = $conn->query($sqlUsers);

        // On récupere le nom et prénom de l'user selon l'id du contact dans la notif
        if ($resultUsers->num_rows > 0) { 
            $rowUsers = $resultUsers->fetch_assoc();

            $notifsUserFirstName = $rowUsers["first_name"];
            $notifsUserLastName = $rowUsers["last_name"];

        }; ?>

        <div class="notification-container">
            <label class="notif-label" for="notif"><?php echo $notifsContactMessage ?></label>
            <div class="notification" name="notif">
                <div>
                    <img src="../assets/images/user2.jpg" alt="">
                    <span><?php echo $notifsUserFirstName . ' ' . $notifsUserLastName ?></span>
                </div>
                <div>
                    <svg class="valid-notification-icon" fill="#3dcc00" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 21 21" xml:space="preserve"><style type="text/css"> .st0{fill:none;} </style> <path d="M19.3,5.3L9,15.6l-4.3-4.3l-1.4,1.4l5,5L9,18.4l0.7-0.7l11-11L19.3,5.3z"></path> <rect class="st0" width="24" height="24"></rect></svg>
                    <svg class="cross-notification-icon" fill="#e00000" viewBox="-5 -8 28 28" xmlns="http://www.w3.org/2000/svg" stroke="#e00000"><<path d="M0 14.545L1.455 16 8 9.455 14.545 16 16 14.545 9.455 8 16 1.455 14.545 0 8 6.545 1.455 0 0 1.455 6.545 8z" fill-rule="evenodd"></path></svg>
                </div>
            </div>
        </div>

    <?php
    }

    $conn->close();
} else {
    echo "Pas de notifications";
    $conn->close();
};


?>