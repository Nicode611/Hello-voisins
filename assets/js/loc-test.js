loc = document.querySelector('.position');

function initMap() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var coords = latitude + ' ' + longitude;
            // Recupere la loc

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: parseFloat(latitude), // Convertir en nombre
                    lng: parseFloat(longitude) // Convertir en nombre
                },
                zoom: 15 // Réglez le niveau de zoom selon vos préférences
            });
            // Genere la map
        
            var customIcon = {
                url: '../assets/images/user-marker.png',
                scaledSize: new google.maps.Size(40, 40)
            };
            // Crée une icone personalisé

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
        });
      } else {
        console.log('La géolocalisation n\'est pas prise en charge');
      }
}
