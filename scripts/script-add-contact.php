<?php

if (isset($_POST['idContact'])) { 

    session_start();

    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    $db_user = "331032";
    $db_pass = "Beta2k15";
    $db_name = "hello-voisins_2023";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $selfId = $_SESSION['user_id'];
    $contactId = $_POST["idContact"];
    $firstNameContact = $_POST['firstNameContact'];
    $lastNameContact = $_POST['lastNameContact'];
    $statut = 'waiting';
    $notifMessage = 'Souhaite vous ajouter à ses contacts';

    // Requette pour ajouter le contact
    $sqlContact = "INSERT INTO contacts (contact_firstName, contact_lastName, added_by_user_id, added_user_id, statut) VALUES (?, ?, ?, ?, ?) ";

    $stmtContact = $conn->prepare($sqlContact);

    if ($stmtContact === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    $stmtContact->bind_param('sssss', $firstNameContact, $lastNameContact, $selfId, $contactId, $statut);

    if ($stmtContact->execute()) { 

        // Requette pour ajouter la notif
        $sqlNotif = "INSERT INTO notifs (contact_id, target_id, message, statut) VALUES (?, ?, ?, ?) ";

        $stmtNotif = $conn->prepare($sqlNotif);

        if ($stmtNotif === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        $stmtNotif->bind_param('ssss', $selfId, $contactId, $notifMessage, $statut);

        if ($stmtNotif->execute()) { 

            $ok = 'ok';
            echo json_encode($ok);
        } else {
            header('../pages/maps.php');
        };

    } else {
        header('../pages/proximity-chat.php');
    };

    
};