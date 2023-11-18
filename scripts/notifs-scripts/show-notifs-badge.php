<?php
session_start();

$includeFile = "../../config/db/db.php";
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
    $rowNotifsContacts = $resultNotifsContacts->fetch_assoc();

    ?><div class="patch"></div><?php

    };

$conn->close();


?>