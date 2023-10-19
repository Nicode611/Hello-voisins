<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="proximity-chat.php">test</a>

    <script>
        username = 'Nicolas';

        try {
            var conn = new WebSocket('wss://hello-voisins-25649417130d.herokuapp.com/wss');
        } catch (error) {
            console.error('Erreur lors de la création de la connexion WebSocket :', error);
        }

        conn.onopen = function(e) {
            console.log("Connection established!");
        };
        
        conn.onmessage = function(e) {
            console.log(e.data);
        };

        conn.onerror = function (event) {
            console.error("WebSocket error: ", event);

            // Accédez aux propriétés de l'événement pour obtenir plus d'informations
            console.log("Event type:", event.type);
            console.log("Event message:", event.message);
            console.log("Event target:", event.target);
            // ... et ainsi de suite
        };

        conn.onclose = function(event) {
            if (event.wasClean) {
                console.log("WebSocket connection closed cleanly, code=" + event.code + ", reason=" + event.reason);
            } else {
                console.error("WebSocket connection abruptly closed");
            }
        };
    </script>


</body>
</html>