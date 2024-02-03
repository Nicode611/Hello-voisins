<?php 
    session_set_cookie_params(3600);
    session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Hello voisins</title>
</head>
<body>
    
    <h1>Hello voisins</h1>
    <a href="pages/connection.php"><button class="connect-btns">Se connecter</button></a>
    <a href="pages/create-account.php"><button class="connect-btns">Create account</button></a>
  
</body>
</html>