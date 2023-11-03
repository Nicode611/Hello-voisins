<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
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
        <h1>Vos groupes</h1>
        <input class="search-bar" type="search" name="findContacts" id="findContacts" placeholder="Rechercher">

        <div class="create-new-group">
            <form class="new-group-form" action="../scripts/groups-scripts/add-group.php" method="POST" onsubmit="return verifierCasesCochees()">
                <input type="text" name="groupName" id="groupName" placeholder="Nom du groupe" required>
                <div class="contacts-container-new-group">
                    <?php
                        $includeFile = "../scripts/groups-scripts/show-contacts-to-choose-for-groups.php";
                        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
                    ?>
                </div>
                <input type="submit" name="create_group" value="Créer un groupe">
            </form>

            <script>
                function verifierCasesCochees() {
                    // Sélectionnez toutes les cases à cocher avec le nom "choix[]"
                    const casesCocher = document.querySelectorAll('input[name="contacts[]"]');

                    // Compteur pour les cases cochées
                    let casesCochees = 0;

                    // Parcourez les cases à cocher et comptez celles qui sont cochées
                    casesCocher.forEach(checkbox => {
                        if (checkbox.checked) {
                            casesCochees++;
                        }
                    });

                    // Vérifiez si au moins deux cases sont cochées
                    if (casesCochees >= 2) {
                        return true; // Autoriser la soumission du formulaire
                    } else {
                        alert("Sélectionnez au moins deux cases à cocher.");
                        return false; // Empêcher la soumission du formulaire
                    }
                }
            </script>


        </div>

        <div class="groups-container">
            <?php
                $includeFile = "../scripts/groups-scripts/show-my-groups.php";
                if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
            ?>
    
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
                <div class="group-actions">
                    <svg class="plus" fill="#69E13F" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"><path d="M19.75 16c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75zM19.75 27c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75zM19.75 5c0 2.071-1.679 3.75-3.75 3.75s-3.75-1.679-3.75-3.75c0-2.071 1.679-3.75 3.75-3.75s3.75 1.679 3.75 3.75z"></path></svg>
                    <div class="start">
                        <span>Commencer à discuter</span>
                    </div>
                    <div class="popup-group-options">
                        <span class="leave-group">Quitter le groupe</span>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        <div class="contact-group-container">
                            <span>Bruce Wils</span>
                            <svg class="add-user-group" fill="#000000" viewBox="0 0 24 24" id="add-user-left-6" data-name="Line Color" xmlns="http://www.w3.org/2000/svg" class="icon line-color"><path id="secondary" d="M7,5H3M5,7V3" style="fill: none; stroke: #69E13F; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary" d="M11,3.41A5.11,5.11,0,0,1,13,3a5,5,0,1,1-4.59,7" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path><path id="primary-2" data-name="primary" d="M12,13h2a7,7,0,0,1,7,7v0a1,1,0,0,1-1,1H6a1,1,0,0,1-1-1v0A7,7,0,0,1,12,13Z" style="fill: none; stroke: #000000; stroke-linecap: round; stroke-linejoin: round; stroke-width: 2;"></path></svg>                    
                        </div>
                        
                    </div>
                    <div class="overlay-groups"></div>
                </div>
            </div>
        </div>
    </div>
    <script src="../assets/js/groups-js/groups-options.js"></script>
</body>
</html>