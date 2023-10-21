<?php
if (isset($_GET['id'])) {

    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    $db_user = "331032";
    $db_pass = "Beta2k15";
    $db_name = "hello-voisins_2023";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    // Supposons que vous avez déjà défini $id, par exemple :
    $id = $_GET['id'];

    // Requête SQL pour obtenir firstname et lastname de l'utilisateur avec l'ID spécifié
    $sql = "SELECT first_name, last_name FROM users WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        // Créez un tableau associatif pour les données que vous souhaitez convertir en JSON
        $user_data = array(
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name']
        );

        // Convertissez le tableau en JSON
        // Convertissez le tableau en JSON et renvoyez-le
        echo json_encode($user_data);
    } else {
        echo json_encode(array('error' => 'Utilisateur non trouvé'));
    }
} else {
    echo json_encode(array('error' => 'ID non spécifié'));
}

$conn->close();
