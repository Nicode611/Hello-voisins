loc = document.querySelector('.position');


function initMap() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var coords = latitude + ' ' + longitude;

            // Vérifiez si les valeurs de latitude et longitude sont définies et valides
if (typeof latitude !== 'undefined' && typeof longitude !== 'undefined') {
    // Les valeurs sont définies et valides, vous pouvez envoyer la requête AJAX
    $.post("../scripts/send-loc.php", { boo: latitude, too: longitude }, function() {
            // Gérer la réponse du serveur si nécessaire
            console.log('Succès');
        });
} else {
    // Les valeurs de latitude et longitude ne sont pas définies ou invalides
    console.log('Latitude ou longitude manquante ou invalide, la requête n\'a pas été envoyée.');
}

            
            // Récupère la localisation

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: parseFloat(latitude), // Convertir en nombre
                    lng: parseFloat(longitude) // Convertir en nombre
                },
                zoom: 15 // Réglez le niveau de zoom selon vos préférences
            });
            // Génère la carte
        
            var customIcon = {
                url: '../assets/images/user-marker.png',
                scaledSize: new google.maps.Size(40, 40)
            };
            // Crée une icône personnalisée

            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(latitude), // Convertir en nombre
                    lng: parseFloat(longitude) // Convertir en nombre
                },
                map: map,
                title: 'Votre position',
                icon: customIcon
            });
            // Place le marqueur

            // Envoi des données de localisation via une requête Ajax
            
        });
    } else {
        console.log('La géolocalisation n\'est pas prise en charge');
    }
}

