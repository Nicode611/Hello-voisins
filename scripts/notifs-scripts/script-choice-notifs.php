<?php
if (isset($_POST['choice_notifs'])) { 

    session_start();

    $includeFile = "../../config/db/db.php";
    if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $selfId = $_SESSION['user_id'];
    $choice = $_POST['choice_notifs'];



    if ($choice == 'accept') { 

        $choice = 'added';

        $sql = "UPDATE contacts SET statut='$choice' WHERE added_user_id='$selfId'";

        if ($conn->query($sql) === TRUE) {

            $choiceResponse = 'accepted';
            echo json_encode($choiceResponse);

        }


    } else if ($choice == 'refuses') { 

        $sql = "DELETE FROM contacts WHERE added_user_id='$selfId'";

        if ($conn->query($sql) === TRUE) {

            $choiceResponse = 'deleted';
            echo json_encode($choiceResponse);
            
        }

    }

    $conn->close();

};
?>