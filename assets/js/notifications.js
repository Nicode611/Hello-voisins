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