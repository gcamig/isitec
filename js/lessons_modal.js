document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.add-lesson-button').forEach(function (button) {
    button.addEventListener('click', function () {
      var buttonId = this.getAttribute('id');
      var modalContainer = document.getElementById('modal-container');
      modalContainer.removeAttribute('class');
      modalContainer.classList.add(buttonId);
      document.body.classList.add('modal-active');
    });
  });

  document.getElementById('modal-container').addEventListener('click', function () {
    this.classList.add('out');
    document.body.classList.remove('modal-active');
  });
});