document.addEventListener('DOMContentLoaded', function () {
  var steps = document.querySelectorAll('.form-group');
  var currentStep = 0;
  var nextBtn = document.getElementById('btn-next');
  var prevBtn = document.getElementById('btn-prev');
  var submitBtn = document.getElementById('btn-submit');

  nextBtn.addEventListener('click', function () {
    console.log('lenght', steps.length);
    showStep(currentStep + 1);

  });

  prevBtn.addEventListener('click', function () {
    showStep(currentStep - 1);
  });

  function showStep(step) {
    console.log('showStep', currentStep);
    steps[currentStep].classList.remove('active');
    steps[currentStep].classList.add('hidden');

    steps[step].classList.remove('hidden');
    steps[step].classList.add('active');
    currentStep = step;
    console.log('currentStep', currentStep);

    if (currentStep === 0) {
      prevBtn.classList.remove('active');
      prevBtn.classList.add('hidden');
    } else {
      prevBtn.classList.remove('hidden');
      prevBtn.classList.add('active');
    }

    if (currentStep === steps.length - 1) {
      nextBtn.classList.add('hidden');
      submitBtn.classList.remove('hidden');
    } else {
      nextBtn.classList.remove('hidden');
      submitBtn.classList.add('hidden');
    }
  }
});