
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
                    console.log('mis a jour')
                }
            });
        }, function(error) {
                var mainContent = document.querySelector('.main-content');
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                        // L'utilisateur a refusé la demande de géolocalisation
                        mainContent.innerText = 'L\'utilisateur a refusé la géolocalisation.';
                        console.log("L'utilisateur a refusé la géolocalisation.");
                        break;
                    case error.POSITION_UNAVAILABLE:
                        // La position n'a pas pu être déterminée
                        mainContent.innerText = 'La position n\'a pas pu être déterminée.';
                        console.log("La position n'a pas pu être déterminée.");
                        break;
                    case error.TIMEOUT:
                        // La demande de géolocalisation a expiré
                        mainContent.innerText = 'La demande de géolocalisation a expiré.';
                        console.log("La demande de géolocalisation a expiré.");
                        break;
                    case error.UNKNOWN_ERROR:
                        // Une erreur inconnue s'est produite
                        mainContent.innerText = 'Une erreur inconnue s\'est produite.';
                        console.log("Une erreur inconnue s'est produite.");
                        break;
                }
            });
    }


// refreshButton = document.querySelector('.refresh-position');

// refreshButton.addEventListener('click', demanderLocalisation);

// function demanderLocalisation() {
//     console.log('click');
//     if (navigator.geolocation) {
//       // Si le navigateur prend en charge la géolocalisation
//       navigator.geolocation.getCurrentPosition(succesCallback, erreurCallback);
//     } else {
//       // Si le navigateur ne prend pas en charge la géolocalisation
//       alert("La géolocalisation n'est pas prise en charge par votre navigateur.");
//     }
// }

// // Fonction appelée en cas de succès de la géolocalisation
// function succesCallback(position) {
//     var latitude = position.coords.latitude;
//     var longitude = position.coords.longitude;

//     // Vérifiez si les valeurs de latitude et longitude sont définies et valides
//     // Les valeurs sont définies et valides, vous pouvez envoyer la requête AJAX
        
//     $.ajax({
//         type: "POST",
//         url: "../scripts/infos-scripts/send-loc.php",
//         data: { 
//             latitude: latitude,
//             longitude: longitude
//         },
//         success: function(response) {
//             console.log('mis a jour')
//         }
//     });
//   }
  
//   // Fonction appelée en cas d'erreur de la géolocalisation
//   function erreurCallback(error) {
//     switch (error.code) {
//       case error.PERMISSION_DENIED:
//         alert("La demande de géolocalisation a été refusée par l'utilisateur.");
//         break;
//       case error.POSITION_UNAVAILABLE:
//         alert("Les informations de localisation ne sont pas disponibles.");
//         break;
//       case error.TIMEOUT:
//         alert("La demande de géolocalisation a expiré.");
//         break;
//       case error.UNKNOWN_ERROR:
//         alert("Une erreur inconnue s'est produite.");
//         break;
//     }
//   }



