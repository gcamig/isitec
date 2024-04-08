document.addEventListener('DOMContentLoaded', function () {
  var steps = document.querySelectorAll('.form-group');
  var currentStep = 0;
  var nextBtn = document.getElementById('btn-next');
  var prevBtn = document.getElementById('btn-prev');
  var submitBtn = document.getElementById('btn-submit');

  nextBtn.addEventListener('click', function () {
    console.log('next button clicked');
    showStep(currentStep + 1);

  });

  prevBtn.addEventListener('click', function () {
    showStep(currentStep - 1);
  });

  function showStep(step) {
    console.log('showStep', step);
    steps[currentStep].classList.remove('active');
    steps[currentStep].classList.add('hidden');

    steps[step].classList.remove('hidden');
    steps[step].classList.add('active');
    currentStep = step;

    if (currentStep === 0) {
      prevBtn.classList.remove('active');
      prevBtn.classList.add('hidden');
    } else {
      prevBtn.classList.remove('hidden');
    }

    if (currentStep === steps.length - 2) {
      
      nextBtn.classList.add('hidden');
      submitBtn.classList.remove('hidden');
    } else {
      nextBtn.classList.remove('hidden');
      nextBtn.classList.add('active');
      submitBtn.classList.add('hidden');
    }
  }
});