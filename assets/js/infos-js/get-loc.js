
    if ("geolocation" in navigator) {
        navigator.geolocation.getCurrentPosition(function(position) {
            // Récupère la localisation
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            // Vérifiez si les valeurs de latitude et longitude sont définies et valides
            // Les valeurs sont définies et valides, vous pouvez envoyer la requête AJAX
                
            $.ajax({
                type: "POST",
                url: "../scripts/infos-scripts/send-loc.php",
                data: { 
                    latitude: latitude,
                    longitude: longitude
                },
                success: function(response) {
                }
            });
    });
}

