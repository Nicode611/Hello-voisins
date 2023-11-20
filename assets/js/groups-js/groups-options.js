function groupOptions() {

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
}

function groupMembers() {

    const membersBtns = document.querySelectorAll('.number-container');
    const groupsOverlay = document.querySelector('.overlay');

    membersBtns.forEach(membersBtn => {
        membersBtn.addEventListener('click', function() {
            let membersContainer = membersBtn.querySelector(".popup-group-members");
            membersContainer.classList.toggle('open');
            groupsOverlay.classList.toggle('active');

            groupsOverlay.addEventListener('click', function() {
                membersContainer.classList.remove('open');
                groupsOverlay.classList.remove('active');
            });
        });
    });
}

