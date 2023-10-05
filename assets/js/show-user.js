
const userImg = document.querySelectorAll('.other-users-img');
const popupUser = document.querySelector('.popup-user');
const overlay2 = document.querySelector('.overlay');

userImg.forEach(function(img) {
    img.addEventListener('click', function() {
        img.classList.toggle('open');
        popupUser.classList.toggle('open');
        overlay2.classList.toggle('active');
        console.log('hello');
    });
});



overlay2.addEventListener('click', function() {
    userImg.forEach(function(img) {
        img.classList.remove('open')
    });
    popupUser.classList.remove('open');
    overlay2.classList.remove('active');
});