const plusBtn = document.querySelector('.plus');
const plusContainer = document.querySelector('.popup-group-options');
const groupsOverlay = document.querySelector('.overlay');

plusBtn.addEventListener('click', function() {
    plusContainer.classList.toggle('open');
    groupsOverlay.classList.toggle('active');
    console.log('hello');
});

groupsOverlay.addEventListener('click', function() {
    plusContainer.classList.remove('open');
    groupsOverlay.classList.remove('active');
});