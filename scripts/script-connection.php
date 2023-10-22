<?php
        if (isset($_POST["submit_connect"])) {

        $db_host = "mysql-garage-v-parrot.alwaysdata.net";
        $db_user = "331032";
        $db_pass = "Beta2k15";
        $db_name = "hello-voisins_2023";
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            die("La connexion à la base de données a échoué : " . $conn->connect_error);
        }

        // Récupérer les données de localisation envoyées via la requête Ajax
        $email = $_POST['logInEmail'];
        $password = $_POST['logInPassword'];

        $email = mysqli_real_escape_string($conn, $email);

        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($query);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $hashMdp = $row["password"];
    
            if (password_verify($password, $hashMdp)) {
    
                session_start();
    
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION["user_id"] = $row["id"];
                $_SESSION["user_firstName"] = $row["first_name"];
                $_SESSION["user_lastName"] = $row["last_name"];
                $_SESSION["user_email"] = $row["email"];
                $_SESSION["user_password"] = $row["password"];
                $_SESSION["user_phone"] = $row["phone"];
                $_SESSION["user_latitude"] = $row["latitude"];
                $_SESSION["user_longitude"] = $row["longitude"];
                
                $conn->close();
                header("Location: proximity-chat.php");
                exit();
                
            } else {
                session_start();
                $_SESSION["error"] = "<p class='error'>Mot de passe incorect</p>";
                $conn->close();
                header("Location: ../pages/maps.php");
                exit();
            }
        } else {
            session_start();
            $_SESSION["error"] = "<p class='error'>Mot de passe incorect</p>";
            $conn->close();
            header("Location: ../pages/connection.php");
            exit();
        }

    };
        
    ?>


