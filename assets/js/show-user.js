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
    }
});



overlay2.addEventListener('click', function() {
    userIdPopup.forEach(function(idPopup) {
        idPopup.classList.remove('open')
    });
    popupUser.classList.remove('open');
    overlay2.classList.remove('active');
});