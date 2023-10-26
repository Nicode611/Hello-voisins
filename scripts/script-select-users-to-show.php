<?php
session_start();
if (isset($_GET['id'])) {

    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    $db_user = "331032";
    $db_pass = "Beta2k15";
    $db_name = "hello-voisins_2023";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $selfId = $_SESSION['user_id'];
    $id = $_GET['id'];
    $response = array();

    // Requête SQL pour obtenir firstname et lastname de l'utilisateur avec l'ID spécifié
    $sqlUsers = "SELECT first_name, last_name, id FROM users WHERE id = $id";
    $resultUsers = $conn->query($sqlUsers);

    if ($resultUsers->num_rows > 0) {
        $row = $resultUsers->fetch_assoc();
        
        // Créez un tableau associatif pour les données que vous souhaitez convertir en JSON
        $user_data = array(
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'id' => $row['id']
        );

        $response['user_data'] = $user_data;
    }

    $sqlContact = "SELECT statut FROM contacts WHERE added_user_id = $id AND added_by_user_id = $selfId";
    $resultContact = $conn->query($sqlContact);

    if ($resultContact->num_rows > 0) {
        $row = $resultContact->fetch_assoc();
        
        // Créez un tableau associatif pour les données que vous souhaitez convertir en JSON
        $contactStatut = $row["statut"];

        $response['contact_statut'] = $contactStatut;
    } else { 
        $response['contact_statut'] = 'null';
    };

    echo json_encode($response);
}

$conn->close();
