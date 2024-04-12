document.addEventListener("DOMContentLoaded", function () {
  // Variables para la validación del usuario
  let user = document.querySelector("#user")
  let userContainer = document.querySelector("#input-usr")
  let userError = document.querySelector("#userError")
  
  // Variables para la validación del correo electrónico
  var email = document.querySelector("#email")
  var emailContainer = document.querySelector("#input-email")
  var emailError = document.querySelector("#emailError")

  // Variables para la validación de la contraseña
  let password = document.querySelector("#pwd")
  let pswdVerification = document.querySelector("#pswd-verif")
  let container = document.querySelector("#input-pwd")
  let containerVerification = document.querySelector("#input-pwd-verif")
  let errorText = document.querySelector("#error")
  let verifText = document.querySelector("#verifError")

  


  // Validación del correo electrónico
  email.onkeyup = function () {
    if (!validateEmail(/\S+@\S+\.\S+/, "Formato de correo electrónico incorrecto")) {
      emailContainer.classList.add("invalid")
      disableButton()
    } else if (!validateEmail(/^\S*$/, "El correo electrónico no puede contener espacios")) {
      emailContainer.classList.add("invalid")
      disableButton()
    } else {
      emailContainer.classList.remove("invalid")
      enableButton()
    }
  }

  // Validación de la contraseña
  password.onkeyup = function () {
    if (!validatePassword(/[A-Z]/, "Debe contener al menos una letra mayúscula")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[a-z]/, "Debe contener al menos una letra minúscula")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[0-9]/, "Debe contener al menos un número")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/, "Debe contener al menos un carácter especial")) {
      container.classList.add("invalid")
      disableButton()
    } else if (password.value.length < 8) {
      container.classList.add("invalid")
      errorText.classList.remove("inactive")
      errorText.classList.add("active")
      errorText.innerText = "Debe tener al menos 8 caracteres"
    }
    else {
      container.classList.remove("invalid")
      enableButton()
    }
  }

  // Validación de la verificación de la contraseña
  if (pswdVerification) {
    pswdVerification.onkeyup = function () {
      if (password.value !== pswdVerification.value) {
        containerVerification.classList.add("invalid")
        verifText.classList.remove("inactive")
        verifText.classList.add("active")
        verifText.innerText = "Las contraseñas no coinciden"
        disableButton()
      } else {
        verifText.classList.remove("active")
        verifText.classList.add("inactive")
        containerVerification.classList.remove("invalid")
        enableButton()
      }
    }
  }

  // Validación del usuario
  user.onkeyup = function () {
    if (!validateUser()) {
      userContainer.classList.add("invalid")
      disableButton()
    } else {
      userContainer.classList.remove("invalid")
      enableButton()
    }
  }


  function validatePassword(regex, text) {
    if (!regex.test(password.value)) {
      errorText.classList.remove("inactive")
      errorText.classList.add("active")
      errorText.innerText = text
      return false;
    } else {
      errorText.classList.remove("active")
      errorText.classList.add("inactive")
      return true;
    }
  }

  function validateUser() {
    var regex = /^\S*$/;
    if (!regex.test(user.value)) {
      userError.classList.remove("inactive")
      userError.classList.add("active")
      userError.innerText = "El nombre no puede contener espacios"
      return false;
    } else {
      userError.classList.remove("active")
      userError.classList.add("inactive")
      return true;
    }
  }

  function validateEmail(regex, text) {
    if (!regex.test(email.value)) {
      emailError.classList.remove("inactive")
      emailError.classList.add("active")
      emailError.innerText = text
      return false;
    } else {
      emailError.classList.remove("active")
      emailError.classList.add("inactive")
      return true;
    }
  }

  function disableButton() {
    document.getElementById("form-button").disabled = true;
  }

  function enableButton() {
    document.getElementById("form-button").disabled = false;
  }
})
