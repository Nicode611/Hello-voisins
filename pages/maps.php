<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="../assets/css/global.css">
    <link rel="stylesheet" href="../assets/css/maps.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Carte</title>
</head>
<body>
    
<script src="../assets/js/loc-test.js"></script>



    <?php
        $includeFile = "../includes/navigation.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

    

    <div class="main-content">

    <?php
        $includeFile = "../scripts/send-loc.php";
        if (file_exists($includeFile)) { include($includeFile); } else { echo "Le fichier $includeFile n'a pas été trouvé."; }
    ?>

        <div id="map">

        </div>
    </div>



    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBGd9Tr4P6a71MMWhjcWjpApcEFhN7dURk&callback=initMap" async defer></script>
    
</body>
</html>