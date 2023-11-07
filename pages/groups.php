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

            <script>
                // Script pour lancer le chat (récupération du nom, envoie a la page groups-chat.php)
                const startGroupChatBtns = document.querySelectorAll('#startGroupDiscussion');

                startGroupChatBtns.forEach(function(startGroupChatBtn) {
                    startGroupChatBtn.addEventListener('click', function() {
                        var channelName = startGroupChatBtn.classList.value;
                        var channelNameToShowContainer = startGroupChatBtn.closest(".group-infos");
                        var channelNameToShowElement = document.querySelector("#channelName");
                        var channelNameToShow = channelNameToShowElement.textContent;
                        var groupIdElement = startGroupChatBtn.nextElementSibling;
                        console.log(groupIdElement);
                        if (groupIdElement.classList.contains("group-id")) {
                            var groupId = groupIdElement.textContent;
                        }
                        if (channelName, channelNameToShow, groupId) {
                            // Redirigez l'utilisateur vers la page groups-chat.php avec le nom du canal en tant que paramètre d'URL
                            window.location.href = "groups-chat.php?channelName=" + channelName + "&channelNameToShow=" + channelNameToShow + "&groupId=" + groupId;
                        } else {
                            console.log("Missing arguments : " + channelName + channelNameToShow + groupId)
                        }
                    });
                });
            </script>

        </div>
    </div>
    <script src="../assets/js/groups-js/groups-options.js"></script>
</body>
</html>