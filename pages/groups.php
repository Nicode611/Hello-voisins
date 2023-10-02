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
        <input class="search-bar" type="text" name="findContacts" id="findContacts" placeholder="Rechercher">
        <div class="group">
            <div class="group-infos-container">
                <div class="group-infos">
                    <h4>Groupe voisins 1</h4>
                    <img class="group-img" src="../assets/images/user2.jpg" alt="">
                    <div class="number-container">
                        <svg class="user-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="12" cy="6" r="4" fill="#000000"></circle> <path d="M20 17.5C20 19.9853 20 22 12 22C4 22 4 19.9853 4 17.5C4 15.0147 7.58172 13 12 13C16.4183 13 20 15.0147 20 17.5Z" fill="#000000"></path></svg>    
                        <p class="number">6 membres</p>
                    </div>
                </div>
                <div class="members-names-container">
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                    <span>Bruce Wils</span>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>