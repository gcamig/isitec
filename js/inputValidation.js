document.addEventListener("DOMContentLoaded", function () {
  // Variabels for email input validation
  var email = document.querySelector("#email")
  var emailContainer = document.querySelector("#input-email")
  var emailError = document.querySelector("#emailError")

  // variables for password input validation
  let password = document.querySelector("#pwd")
  let pswdVerification = document.querySelector("#pswd-verif")
  let container = document.querySelector("#input-pwd")
  let containerVerification = document.querySelector("#input-pwd-verif")
  let errorText = document.querySelector("#error")
  let verifText = document.querySelector("#verifError")

  // variables for user input validation
  let user = document.querySelector("#user")
  let userContainer = document.querySelector("#input-usr")
  let userError = document.querySelector("#userError")


  // email input validation
  email.onkeyup = function () {
    if (!validateEmail(/\S+@\S+\.\S+/, "Incorrect email format")) {
      emailContainer.classList.add("invalid")
      disableButton()
    } else if (!validateEmail(/^\S*$/, "Email cannot contain spaces")) {
      emailContainer.classList.add("invalid")
      disableButton()
    } else {
      emailContainer.classList.remove("invalid")
      enableButton()
    }
  }

  // password input validation
  password.onkeyup = function () {
    if (!validatePassword(/[A-Z]/, "Must contain at least one uppercase letter")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[a-z]/, "Must contain at least one lowercase letter")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[0-9]/, "Must contain at least one number")) {
      container.classList.add("invalid")
      disableButton()
    } else if (!validatePassword(/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/, "Must contain at least one special character")) {
      container.classList.add("invalid")
      disableButton()
    } else if (password.value.length < 8) {
      container.classList.add("invalid")
      errorText.classList.remove("inactive")
      errorText.classList.add("active")
      errorText.innerText = "Must be at least 8 characters"
    }
    else {
      container.classList.remove("invalid")
      enableButton()
    }
  }

  // password verification input validation
  if (pswdVerification) {
    pswdVerification.onkeyup = function () {
      if (password.value !== pswdVerification.value) {
        containerVerification.classList.add("invalid")
        verifText.classList.remove("inactive")
        verifText.classList.add("active")
        verifText.innerText = "Passwords do not match"
        disableButton()
      } else {
        verifText.classList.remove("active")
        verifText.classList.add("inactive")
        containerVerification.classList.remove("invalid")
        enableButton()
      }
    }
  }

  // user input validation
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
      userError.innerText = "Username cannot contain spaces"
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
