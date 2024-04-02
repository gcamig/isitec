document.addEventListener('DOMContentLoaded', function () {
  var trig = document.querySelector('#dropdown-trigger');
  var dropdown = document.querySelector('.user-dropdown');

  trig.addEventListener('click', function () {
    dropdown.classList.toggle('hidden');
  });



});