<?php

require __DIR__ . '/../../vendor/autoload.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

    
    // $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    // $db_user = "331032";
    // $db_pass = "Beta2k15";
    // $db_name = "hello-voisins_2023";
    // $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    $db_host = $_ENV['DB_HOST'];
    $db_user = $_ENV['DB_USER'];
    $db_pass = $_ENV['DB_PASSWORD'];
    $db_name = $_ENV['DB_NAME'];


?>