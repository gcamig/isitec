// Variabels for email input validation
var email = document.querySelector("#email")
var emailVerificaion = document.querySelector("#pswd-verif")
var emailError = document.querySelector("#emailError")

// variables for password input validation
var pswd = document.querySelector("#pswd")
var pswdVerification = document.querySelector("#pswd-verif")
var container = document.querySelector("#input-pwd")
var containerVerification = document.querySelector("#input-pwd-verif")
var errorText = document.querySelector("#error")
var verifText = document.querySelector("#verifError")

// variables for user input validation
var user = document.querySelector("#usr")
var userContainer = document.querySelector("#input-usr")
var userError = document.querySelector("#userError")
document.addEventListener("DOMContentLoaded", function () {

  // email input validation
  email.onkeyup = function () {
    console.log("si")
    if (!validateEmail()) {
      email.classList.add("invalid")
      disableButton()
    } else {
      email.classList.remove("invalid")
      enableButton()
    }
  }
  
  // password input validation
  pswd.onkeyup = function () {
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
    } else if (pswd.value.length < 8) {
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
      if (pswd.value !== pswdVerification.value) {
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
})

function validatePassword(regex, text) {
  if (!regex.test(pswd.value)) {
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
    userError.innerText = "Username cannot contain whitespaces"
    return false;
  } else {
    userError.classList.remove("active")
    userError.classList.add("inactive")
    return true;
  }
}

function validateEmail() {
  var emailRegex = /\S+@\S+\.\S+/;
  if (!emailRegex.test(email.value)) {
    emailError.classList.remove("inactive")
    emailError.classList.add("active")
    emailError.innerText = "Invalid email"
    return false;
  } else {
    return true;
  }
}

function disableButton() {
  document.getElementById("form-button").disabled = true;
}

function enableButton() {
  document.getElementById("form-button").disabled = false;
}



