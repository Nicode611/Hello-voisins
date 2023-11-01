<?php
session_destroy();
session_set_cookie_params(3600);
session_start(); 


if (isset($_POST["submit_create"])) {

    $includeFile = "../../config/db/db.php";
    if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $firstName = $_POST["signInFirstName"];
    $lastName = $_POST["signInLastName"];
    $phone = $_POST["signInPhone"];
    $email = $_POST["signInEmail"];
    $password = $_POST["signInPassword"];
    $confirmPassword = $_POST["signInConfirmPassword"];

    if (strlen($password) >= 8 && preg_match("/[0-9]/", $password) && preg_match("/[!@#$%^&*]/", $password)) { 

    if ($password == $confirmPassword) {
        
        $validPassword = $password;
        $hash_password = password_hash($validPassword, PASSWORD_DEFAULT);
        $adress = 'yes';

        $sql = "INSERT INTO users (first_name, last_name, email, password, phone, adress) VALUES (?, ?, ?, ?, ?, ?)";


        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        // Liaison des paramètres
        $stmt->bind_param('ssssss', $firstName, $lastName, $email, $hash_password, $phone, $adress);

        if ($stmt->execute()) {
            ?> <span class="validation">Compte crée, connectez vous</span> <?php
            $_SESSION["success"] = "<p class='validation'>Compte crée, connectez vous !</p>";
            $conn->close();
            header("Location: ../../pages/connection.php");
            exit();

            } else {
                $_SESSION["error"] = "<p class='error'>Erreur</p>";
                $stmt->close();
                $conn->close();
                header("Location: ../../pages/create-account.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "<p class='error'>Code incorrect.</p>";
            $stmt->close();
            $conn->close();
            header("Location: ../../pages/create-account.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "<p class='error'>Les mdps ne correspondent pas.</p>";
        $stmt->close();
        $conn->close();
        header("Location: ../../pages/create-account.php");
        exit();
    }
} else {
    $_SESSION["error"] = "<p class='error'>Format incorrect.</p>";
    $stmt->close();
    $conn->close();
    header("Location: ../../pages/create-account.php");
    exit();
};

?>