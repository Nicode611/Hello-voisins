<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/self-profile.css">
    <title>Chat de proximité</title>
</head>
<body>
    
    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <div class="main-content">
        
        <form class="self-infos" action="">
            <div class="self-infos-section">
                <img class="self-img" src="../assets/images/user1.jpg" alt="">
                <input class="hide" type="file" name="selfImage" id="selfImage" accept="image/*">
            </div>
            <div class="self-infos-section">
                <label for="selfFirstname">Prénom</label>
                <span class=""><?php echo $_SESSION["user_firstName"]; ?></span>
                <input class="hide" type="text" name="selfFirstname" id="selfFirstname">
            </div>
            <div class="self-infos-section">
                <label for="selfLastname">Nom</label>
                <span class=""><?php echo $_SESSION["user_lastName"]; ?></span>
                <input class="hide" type="text" name="selfLastname" id="selfLastname">
            </div>
            <div class="self-infos-section">
                <label for="selfPhone">Téléphone</label>
                <span class=""><?php echo $_SESSION["user_phone"]; ?></span>
                <input class="hide" type="text" name="selfPhone" id="selfPhone">
            </div>
            <div class="self-infos-section">
                <label for="selfEmail">Email</label>
                <span class=""><?php echo $_SESSION["user_email"]; ?></span>
                <input class="hide" type="text" name="selfEmail" id="selfEmail">
            </div>
            <div class="self-passwords">
                <div class="self-infos-section">
                    <label for="selfPassword">Mot de passe</label>
                    <span class="">azerty64</span>
                    <input class="hide" type="text" name="selfPassword" id="selfPassword">
                </div>
                <div class="self-infos-section">
                    <label for="selfConfirmPassword">Confirmer le mot de passe</label>
                    <span class="">azerty64</span>
                    <input class="hide" type="text" name="selfConfirmPassword" id="selfConfirmPassword">
                </div>
            </div>
            <input class="hide" type="submit" name="" id="" value="Valider les infos">
        </form>
        <button class="modify">Modifier les infos</button>
    </div>
    
    <script src="../assets/js/modify-infos.js"></script>
</body>
</html>