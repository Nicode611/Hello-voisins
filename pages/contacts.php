<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/contacts.css">
    <title>Contacts</title>
</head>
<body>

    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    <div class="main-content">
        <h1>Vos contacts</h1>
        <input type="search" name="findContacts" id="findContacts" placeholder="Rechercher">
        <?php
            $includeFile = "../scripts/contacts-scripts/show-my-contacts.php";
            if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
        ?>
    </div>

    <script src="../assets/js/actions-contact.js"></script>
    
</body>
</html>