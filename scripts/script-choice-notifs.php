<?php

if (isset($_POST['choice_notifs'])) { 

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
    $choice = $_POST['choice_notifs'];


    if ($choice == 'accept') { 

        $sql = "UPDATE contact SET statut='$choice' WHERE added_user_id='$selfId'";

        if ($connexion->query($sql) === TRUE) {

            $choiceResponse = 'accepted';
            echo json_encode($choiceResponse);

        }


    } else if ($choice == 'refuses') { 

        $sql = "DELETE contact WHERE added_user_id='$selfId'";

        if ($connexion->query($sql) === TRUE) {

            $choiceResponse = 'deleted';
            echo json_encode($choiceResponse);
            
        }

    };

    $conn->close();

};