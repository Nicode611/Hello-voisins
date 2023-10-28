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
    deleteBtn.addEventListener('click', function(event) {
        var clickedBtn = event.target;
        var notifContainer = clickedBtn.closest(".notification-container");
        var confirmMessage = document.createElement("p");
        confirmMessage.textContent = "Refusé";
        const choice = 'refuses';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../scripts/script-choice-notifs.php', true);

        // Envoie les données du btn au script PHP
        var choiceData = new FormData();
        choiceData.append('choice_notifs', choice);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Contient les données JSON retournées par le script PHP
                const responseData = JSON.parse(xhr.responseText);

                if (responseData == 'deleted') {
                    
                    notifContainer.replaceWith(confirmMessage);

                    var delai = 3000;

                    setTimeout(function() {

                        confirmMessage.remove();

                    }, delai);
                }

            }
        }
    });
});

validBtns.forEach(ValidBtn => {
    ValidBtn.addEventListener('click', function(event) {
        var clickedBtn = event.target;
        var notifContainer = clickedBtn.closest(".notification-container");
        var confirmMessage = document.createElement("p");
        confirmMessage.textContent = "Contact ajouté";
        const choice = 'accept';

        const xhr = new XMLHttpRequest();
        xhr.open('POST', '../scripts/script-choice-notifs.php', true);

        // Envoie les données du btn au script PHP
        var choiceData = new FormData();
        choiceData.append('choice_notifs', choice);

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Contient les données JSON retournées par le script PHP
                const responseData = JSON.parse(xhr.responseText);

                if (responseData == 'accepted') {

                    notifContainer.replaceWith(confirmMessage);

                    var delai = 3000;

                    setTimeout(function() {

                        confirmMessage.remove();

                    }, delai);
                }
            }
        }

    });
});