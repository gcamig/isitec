
document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const formGroups = form.querySelectorAll(".form-group");
  const submitButton = form.querySelector("#submit-button");
  let currentStep = 0;

  function showStep(step) {
    formGroups[currentStep].classList.add("hidden");
    formGroups[step].classList.remove("hidden");
    currentStep = step;

    if (currentStep === formGroups.length - 1) {
      submitButton.textContent = "Crear";
    }
  }

  submitButton.addEventListener("click", function (e) {
    e.preventDefault();
    showStep(currentStep + 1);
  });
});