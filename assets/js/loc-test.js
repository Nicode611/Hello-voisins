function initMap() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var coords = latitude + ' ' + longitude;

            // Vérifiez si les valeurs de latitude et longitude sont définies et valides
                // Les valeurs sont définies et valides, vous pouvez envoyer la requête AJAX
                
            $.ajax({
                type: "POST",
                url: "../scripts/send-loc.php",
                data: { 
                    latitude: latitude,
                    longitude: longitude
                },
                success: function(response) {
                    $("#resultat").html(response);
                }
            });

            
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

            for (var i = 0; i < userData.length; i++) {
                var user = userData[i];
                var userLatitude = parseFloat(user.latitude);
                var userLongitude = parseFloat(user.longitude);
            
                var customIcon = {
                    url: '../assets/images/user-marker.png',
                    scaledSize: new google.maps.Size(40, 40)
                };
            
                var marker = new google.maps.Marker({
                    position: {
                        lat: userLatitude,
                        lng: userLongitude
                    },
                    map: map,
                    title: 'Utilisateur ' + i, // Vous pouvez personnaliser le titre du marqueur
                    icon: customIcon
                });
            }

            // Place le marqueur

            // Envoi des données de localisation via une requête Ajax
            
        });
    } else {
        console.log('La géolocalisation n\'est pas prise en charge');
    }
}

