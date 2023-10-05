let modify = document.querySelector(".modify");
let form = document.querySelector('.self-infos');
let itemsToShow = form.querySelectorAll('input');

modify.addEventListener('click', function() {
    itemsToShow.forEach(function(input) {
        input.classList.remove('hide');
      });
    modify.classList.add('hide');
});



