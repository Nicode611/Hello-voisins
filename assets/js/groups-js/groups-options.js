const plusBtns = document.querySelectorAll('.plus');
const groupsOverlay = document.querySelector('.overlay');

plusBtns.forEach(plusBtn => {
    plusBtn.addEventListener('click', function() {
        var plusContainer = plusBtn.nextElementSibling;
        console.log("click")
        while (plusContainer) {
            console.log("détecté")
            if (plusContainer.classList.contains("popup-group-options")) {
                console.log("trouvé")
                plusContainer.classList.toggle('open');
                groupsOverlay.classList.toggle('active');
            }
        }
    });
});

groupsOverlay.addEventListener('click', function() {
    plusContainer.classList.remove('open');
    groupsOverlay.classList.remove('active');
});