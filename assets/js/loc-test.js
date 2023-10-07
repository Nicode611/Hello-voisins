loc = document.querySelector('.position');



if ("geolocation" in navigator) {
    navigator.geolocation.getCurrentPosition(function(position) {
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        var coords = latitude + ' ' + longitude;
        // Utilisez latitude et longitude dans votre application
        
        loc.innerText = coords;

        console.log(latitude, longitude);
    });
  } else {
    // La géolocalisation n'est pas prise en charge
  }
  