<?php

$db_host = "mysql-garage-v-parrot.alwaysdata.net";
$db_user = "331032";
$db_pass = "Beta2k15";
$db_name = "hello-voisins_2023";
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