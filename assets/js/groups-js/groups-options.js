const plusBtns = document.querySelectorAll('.plus');
const groupsOverlay = document.querySelector('.overlay');

plusBtns.forEach(plusBtn => {
    plusBtn.addEventListener('click', function() {
        let groupActionsContainer = plusBtn.closest(".group-actions");
        let plusContainer = groupActionsContainer.querySelector(".popup-group-options");
        plusContainer.classList.toggle('open');
        groupsOverlay.classList.toggle('active');

        groupsOverlay.addEventListener('click', function() {
            plusContainer.classList.remove('open');
            groupsOverlay.classList.remove('active');
        });
    });
});