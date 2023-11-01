<?php
if (isset($_POST["submit_modify_self_infos"])) {
    session_set_cookie_params(3600);
    session_start();

    $includeFile = "../../config/db/db.php";
    if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }

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

        $_SESSION['user_firstName'] = $firstName;
        $_SESSION['user_lastName'] = $lastName;
        $_SESSION['user_phone'] = $phone;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_password'] = $hash_password;


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