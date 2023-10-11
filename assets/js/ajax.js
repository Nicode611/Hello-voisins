
        $(document).ready(function() {
            $.post("./test.php", { latitude: 'valeur_latitude', longitude: 'valeur_longitude' }, function(response) {
                // Gérer la réponse du serveur si nécessaire
                console.log('Succès');
                console.log(response); // Afficher la réponse du serveur
            });
        });
