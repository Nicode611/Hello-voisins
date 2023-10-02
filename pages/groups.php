<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/groups.css">
    <title>Groupes</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <div class="main-content">
        <h1>Vos contacts</h1>
        <input type="text" name="findContacts" id="findContacts" placeholder="Rechercher">
        <div class="group">
            <div>
                <div class="group-infos">
                    <h4>Groupe voisins 1</h4>
                    <img class="group-img" src="../assets/images/user2.jpg" alt="">
                    <p>6 membres</p>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>