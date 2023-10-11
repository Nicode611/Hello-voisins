<?php
    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    $db_user = "331032";
    $db_pass = "Beta2k15";
    $db_name = "hello-voisins_2023";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Récupérer les données de localisation envoyées via la requête Ajax
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Requête SQL pour insérer les données de localisation dans la table "users"
    $sql = "UPDATE users SET latitude = ?, longitude = ? WHERE id = '5'"; // Remplacez user_id par l'identifiant de l'utilisateur concerné

    // Préparer la requête
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Erreur de préparation de la requête : " . $conn->error);
    }

    // Remplacez 'i' par le type de données correspondant à l'identifiant de l'utilisateur
    $stmt->bind_param('dd', $latitude, $longitude);

    // Exécutez la requête
    if ($stmt->execute()) {
        echo "Données de localisation mises à jour avec succès.";
    } else {
        echo "Erreur lors de la mise à jour des données de localisation : " . $stmt->error;
    }

    // Fermez la connexion
    $stmt->close();
    $conn->close();
?>
