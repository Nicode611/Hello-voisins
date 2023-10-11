<?php
        $db_host = "mysql-garage-v-parrot.alwaysdata.net";
        $db_user = "331032";
        $db_pass = "Beta2k15";
        $db_name = "hello-voisins_2023";
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        $query = "SELECT latitude, longitude FROM users";
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


