const http = require('http');
const fs = require('fs');
const path = require('path');

const server = http.createServer((req, res) => {
    // Servez la page proximity-chat.php
    const phpPath = path.join("http://localhost/Hello-voisins/pages/proximity-chat.php");
    fs.readFile(phpPath, 'utf8', (err, data) => {
      if (err) {
        res.writeHead(500);
        res.end('Erreur serveur');
      } else {
        res.writeHead(200, { 'Content-Type': 'text/html' });
        res.end(data);
      }
    });
});

const io = require('socket.io')(server);

io.on('connection', (socket) => {
  console.log('Un utilisateur s\'est connecté');
  // Vos gestionnaires d'événements Socket.io vont ici.
});

server.listen(3050, () => {
  console.log('Le serveur Socket.io écoute sur le port 3050');
});
