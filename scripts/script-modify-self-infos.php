<?php
if (isset($_POST["submit_modify_self_infos"])) {
    session_set_cookie_params(3600);
    session_start();

    $db_host = "mysql-garage-v-parrot.alwaysdata.net";
    $db_user = "331032";
    $db_pass = "Beta2k15";
    $db_name = "hello-voisins_2023";
    $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

    if ($conn->connect_error) {
        die("La connexion à la base de données a échoué : " . $conn->connect_error);
    }

    $firstName = $_POST["selfFirstname"];
    $lastName = $_POST["selfLastname"];
    $phone = $_POST["selfPhone"];
    $email = $_POST["selfEmail"];
    $password = $_POST["selfPassword"];
    $confirmPassword = $_POST["selfConfirmPassword"];
    $id = $_SESSION['user_id'];

    if (strlen($password) >= 8 && preg_match("/[0-9]/", $password) && preg_match("/[!@#$%^&*]/", $password)) { 

    if ($password == $confirmPassword) {
        
        $validPassword = $password;
        $hash_password = password_hash($validPassword, PASSWORD_DEFAULT);

        $sql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ?, phone = ? WHERE id = ?";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Erreur de préparation de la requête : " . $conn->error);
        }

        $stmt->bind_param("sssssi", $firstName, $lastName, $email, $hash_password, $phone, $id);


        if ($stmt->execute()) {
            $_SESSION["success"] = "<p class='validation'>Compte crée !</p>";
            $conn->close();
            header("Location: ../pages/self-profile.php");
            exit();

            } else {
                $_SESSION["error"] = "<p class='error'>Erreur</p>";
                $stmt->close();
                $conn->close();
                header("Location: ../pages/self-profile.php");
                exit();
            }
        } else {
            $_SESSION["error"] = "<p class='error'>Les mdps ne correspondent pas.</p>";
            $stmt->close();
            $conn->close();
            header("Location: ../pages/self-profile.php");
            exit();
        }
    } else {
        $_SESSION["error"] = "<p class='error'>Le format du mot de passe n'est pas correct.</p>";
        $stmt->close();
        $conn->close();
        header("Location: ../pages/self-profile.php");
        exit();
    }
} else {
    $_SESSION["error"] = "<p class='error'>Format incorrect.</p>";
    $stmt->close();
    $conn->close();
    header("Location: ../../pages/self-profile.php");
    exit();
};

?>