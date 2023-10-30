<?php 
    session_set_cookie_params(3600);
    session_start(); 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/global.css">
    <link rel="stylesheet" href="assets/css/index.css">
    <title>Hello voisins</title>
</head>
<body>
    <h1>Hello voisins</h1>
    <a href="pages/connection.php"><button class="connect-btns">Se connecter</button></a>
    <a href="pages/create-account.php"><button class="connect-btns">Create account</button></a>

    <img id="imageDisplay" src="" alt="">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aws-sdk/2.1163.0/aws-sdk.min.js"></script>
    <script>
    const s3 = new AWS.S3({
      accessKeyId: 'VOTRE_ACCESS_KEY_ID',
      secretAccessKey: 'VOTRE_SECRET_ACCESS_KEY',
      region: 'eu-west-1' // Remplacez par le code de région approprié
    });
    const params = {
      Bucket: 'hello-voisins',  // Remplacez par le nom de votre bucket S3
      Key: 'images/add-user.png'  // Chemin de l'image que vous souhaitez télécharger
    };
    const imageElement = document.getElementById('imageDisplay');

    s3.getObject(params, (err, data) => {
      if (err) {
        console.error('Erreur lors du téléchargement de l\'image :', err);
      } else {
        const imageSrc = 'data:image/png;base64,' + data.Body.toString('base64');
        imageElement.src = imageSrc;
      }
    });
  </script>
  
</body>
</html>