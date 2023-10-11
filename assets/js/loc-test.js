loc = document.querySelector('.position');

function initMap() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var coords = latitude + ' ' + longitude;

            console.log(coords);
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
            $.ajax({
                type: "POST", // Méthode de la requête
                url: "../scripts/send-loc.php", // URL du script PHP de réception
                data: { latitude: latitude, longitude: longitude }, // Données à envoyer
                success: function(response) {
                    // Gérer la réponse du serveur si nécessaire
                    console.log(response);
                }
            });
        });
    } else {
        console.log('La géolocalisation n\'est pas prise en charge');
    }
}

