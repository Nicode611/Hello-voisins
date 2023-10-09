loc = document.querySelector('.position');

function initMap() {
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;
            var coords = latitude + ' ' + longitude;

            var map = new google.maps.Map(document.getElementById('map'), {
                center: {
                    lat: parseFloat(latitude), // Convertir en nombre
                    lng: parseFloat(longitude) // Convertir en nombre
                },
                zoom: 15 // Réglez le niveau de zoom selon vos préférences
            });
        
            var marker = new google.maps.Marker({
                position: {
                    lat: parseFloat(latitude), // Convertir en nombre
                    lng: parseFloat(longitude) // Convertir en nombre
                },
                map: map,
                title: 'Votre position'
            });
        });
      } else {
        console.log('La géolocalisation n\'est pas prise en charge');
      }
}
