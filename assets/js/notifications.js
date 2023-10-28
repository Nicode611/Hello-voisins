// Ouverture / Fermeture de l'onglet notifications
const notifBtn = document.querySelector('.notifications-icon');
const notifBtnMobile = document.querySelector('.notifications-icon-mobile');
const notifContainer = document.querySelector('.notifications-container');
const overlay = document.querySelector('.overlay');

notifBtn.addEventListener('click', function() {
    notifBtn.classList.toggle('open');
    notifContainer.classList.toggle('open');
    overlay.classList.toggle('active');
});

notifBtnMobile.addEventListener('click', function() {
    notifBtn.classList.toggle('open');
    notifContainer.classList.toggle('open');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', function() {
    notifBtn.classList.remove('open');
    notifContainer.classList.remove('open');
    overlay.classList.remove('active');
});


// Actions sur les boutons
const validBtns = document.querySelectorAll('.valid-notification-icon');
const deleteBtns = document.querySelectorAll('.cross-notification-icon');

deleteBtns.forEach(deleteBtn => {
    deleteBtn.addEventListener('click', () => {

        const choice = 'refuses';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../scripts/script-choose-notifs.php', true);

        // Envoie les données du btn au script PHP
        var choiceData = new FormData();
        choiceData.append('choice', choice);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Contient les données JSON retournées par le script PHP
                const data = JSON.parse(xhr.responseText);
            }
        }
    });
});

validBtns.forEach(ValidBtn => {
    ValidBtn.addEventListener('click', () => {

        const choice = 'accept';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../scripts/script-choose-notifs.php', true);

        // Envoie les données du btn au script PHP
        var choiceData = new FormData();
        choiceData.append('choice', choice);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Contient les données JSON retournées par le script PHP
                const data = JSON.parse(xhr.responseText);
            }
        }

    });
});