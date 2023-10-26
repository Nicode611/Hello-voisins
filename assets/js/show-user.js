const allUsersContainer = document.querySelector('.all-users-container');
const messagesContainerPopup = document.querySelector('.messages-container');
const userIdPopup = document.querySelectorAll('.other-users-id');
const popupUser = document.querySelector('.popup-user');
const overlay2 = document.querySelector('.overlay');

messagesContainerPopup.addEventListener('click', function(event) {
    if (event.target.classList.contains('other-users-id')) {
        const idPopup = event.target;
        idPopup.classList.toggle('open');
        popupUser.classList.toggle('open');
        overlay2.classList.toggle('active');

        // Envoyez une requête AJAX pour obtenir les informations de l'utilisateur
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../scripts/script-select-users-to-show.php?id=' + idPopup.textContent, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Les données JSON de l'utilisateur seront dans xhr.responseText
                const userData = JSON.parse(xhr.responseText);

                // Utilisez userData pour afficher les informations dans votre popup

                const firstNameSpan = document.querySelector('.popup-first_name');
                const lastNameSpan = document.querySelector('.popup-last_name');
                const idSpan = document.querySelector('.popup-id');
                const addContactBtn = document.querySelector('.add-contact-btn');

                // Remplacez le texte dans les éléments <span> avec les données de l'utilisateur
                firstNameSpan.textContent = userData.first_name;
                lastNameSpan.textContent = userData.last_name;
                idSpan.textContent = userData.id;

                // Ajouter un contact
                addContactBtn.addEventListener('click', function(event) {

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '../scripts/script-add-contact.php', true);

                    var contactData = new FormData();
                    contactData.append('idContact', idSpan.textContent);
                    contactData.append('firstNameContact', firstNameSpan.textContent);
                    contactData.append('lastNameContact', lastNameSpan.textContent);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = xhr.responseText;
                            var ok = JSON.parse(response);

                            if (ok == 'ok') {
                                console.log('oui');
                                var validMessage = document.createElement('p');
                                validMessage.innerText = 'Demande d\'ajout envoyée !'

                                popupUser.appendChild(validMessage);

                                validMessage.innerText = 'Demande d\'ajout envoyée !'
                            };
                        };
                    };

                    xhr.send(contactData);
                });

            }
        };
        xhr.send();
    }
});

allUsersContainer.addEventListener('click', function(event) {
    if (event.target.classList.contains('other-users-id')) {
        const idPopup = event.target;
        idPopup.classList.toggle('open');
        popupUser.classList.toggle('open');
        overlay2.classList.toggle('active');

        // Envoyez une requête AJAX pour obtenir les informations de l'utilisateur
        const xhr = new XMLHttpRequest();
        xhr.open('GET', '../scripts/script-select-users-to-show.php?id=' + idPopup.textContent, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Les données JSON de l'utilisateur seront dans xhr.responseText
                const userData = JSON.parse(xhr.responseText);

                // Utilisez userData pour afficher les informations dans votre popup

                const firstNameSpan = document.querySelector('.popup-first_name');
                const lastNameSpan = document.querySelector('.popup-last_name');
                const idSpan = document.querySelector('.popup-id');
                const addContactBtn = document.querySelector('.add-contact-btn');

                // Remplacez le texte dans les éléments <span> avec les données de l'utilisateur
                firstNameSpan.textContent = userData.first_name;
                lastNameSpan.textContent = userData.last_name;
                idSpan.textContent = userData.id;

                // Ajouter un contact
                addContactBtn.addEventListener('click', function(event) {

                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '../scripts/script-add-contact.php', true);

                    var contactData = new FormData();
                    contactData.append('idContact', idSpan.textContent);
                    contactData.append('firstNameContact', firstNameSpan.textContent);
                    contactData.append('lastNameContact', lastNameSpan.textContent);

                    xhr.onreadystatechange = function() {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            var response = xhr.responseText;
                            var ok = JSON.parse(response);

                            if (ok == 'ok') {
                                console.log('oui');
                                var validMessage = document.createElement('p');
                                validMessage.innerText = 'Demande d\'ajout envoyée !'

                                popupUser.appendChild(validMessage);

                                validMessage.innerText = 'Demande d\'ajout envoyée !'
                            };
                        };
                    };

                    xhr.send(contactData);
                });
            }
        };
        xhr.send();
    }
});






overlay2.addEventListener('click', function() {
    userIdPopup.forEach(function(idPopup) {
        idPopup.classList.remove('open')
    });
    popupUser.classList.remove('open');
    overlay2.classList.remove('active');
});