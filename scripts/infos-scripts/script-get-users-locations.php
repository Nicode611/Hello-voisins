<?php
        $includeFile = "../../config/db/db.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }


        $query = "SELECT first_name, last_name, latitude, longitude FROM users WHERE id <> $id AND adress = 'yes'";
        $result = $conn->query($query);

        if (!$result) {
            die("Échec de la requête : " . $conn->error);
        }

        $userData = array();

        while ($row = $result->fetch_assoc()) {
            $userData[] = $row;
        }

        $jsonUserData = json_encode($userData);

        $conn->close();
    ?>


