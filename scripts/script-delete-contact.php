<?php


$db_host = "mysql-garage-v-parrot.alwaysdata.net";
$db_user = "331032";
$db_pass = "Beta2k15";
$db_name = "hello-voisins_2023";
$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("La connexion à la base de données a échoué : " . $conn->connect_error);
}

$contactId = $_POST["contact_id"];

$sql = "DELETE FROM contacts WHERE id='$contactId'";

if ($conn->query($sql) === TRUE) {

    $response = 'deleted';
    echo json_encode($response);
}

$conn->close();


