const messagesContainerPopup = document.querySelector('.messages-container');
const userImgPopup = document.querySelectorAll('.other-users-img');
const popupUser = document.querySelector('.popup-user');
const overlay2 = document.querySelector('.overlay');

messagesContainerPopup.addEventListener('click', function(event) {
    if (event.target.classList.contains('other-users-img')) {
        const imgPopup = event.target;
        imgPopup.classList.toggle('open');
        popupUser.classList.toggle('open');
        overlay2.classList.toggle('active');
    }
});



overlay2.addEventListener('click', function() {
    userImgPopup.forEach(function(imgPopup) {
        imgPopup.classList.remove('open')
    });
    popupUser.classList.remove('open');
    overlay2.classList.remove('active');
});