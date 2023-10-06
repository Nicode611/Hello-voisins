<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/settings.css">
    <title>Parametres</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <div class="main-content">
        <div class="settings">
            <div class="setting night-mode">
                <p>Mode sombre</p>
                <label class="switch">
                    <input type="checkbox" checked>
                    <span></span> 
                </label>
            </div>
            <div class="setting">
                <p>Apparaitre sur la carte</p>
                <label class="switch">
                    <input type="checkbox" checked>
                    <span></span> 
                </label>
            </div>
            <div class="setting">
                <p>Masquer l'adresse</p>
                <label class="switch">
                    <input type="checkbox" checked>
                    <span></span> 
                </label>
            </div>
            <div class="setting">
                <p>Distance de detection</p>
                <select name="chooseDistance" id="chooseDistance">
                    <option value="50m">50m</option>
                    <option value="100m">100m</option>
                    <option value="200m">200m</option>
                    <option value="400m">400m</option>
                    <option value="600m">600m</option>
                </select>
            </div>
        </div>
    </div>
    
</body>
</html>