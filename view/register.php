<?php

chdir("..");
require "controller/controller.php";

$msgError = "";
$errorBox = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $username = $_POST["username"];
  $firstName = $_POST["firstname"];
  $lastName = $_POST["lastname"];
  $pass = $_POST["password"];
  $passVerify = $_POST["veri-pswd"];
  $user = [
    'email' => $email,
    'username' => $username,
    'userFirstName' => $firstName,
    'userLastName' => $lastName,
    'passHash' => password_hash($pass, PASSWORD_BCRYPT),
    'activationCode' => generateActivationCode()
  ];
  $rslt = insertUser($user);
  if ($rslt == true) {
    //el correo envia un enlace a otro php y este es el que luego redirige al index.php
    sendEmail($user, "verification");
    //TODO: mostrar un mensaje conforme se ha enviado un correo    
    header('Location: ../index.php?register=success&verificationMail=n');
    exit();
  } else {
    $msgError = $rslt;
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Sign Up | Cetisi</title>
  <meta charset="utf-8">
  <meta name="author" content="Cetisi">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/img/icon-white.png">
  <link rel="stylesheet" href="/css/output.css">
  <link rel="stylesheet" href="/css/common.css">
  <link rel="stylesheet" href="/css/register.css">

</head>

<body id="screen">
  <section class="text-animation-box">
    <div>
      <h1 class="typeHeader">Welcome back!</h1>
      <p class="typeText"></p>
    </div>
  </section>
  <section class="form-box">
    <h1>Sign Up</h1>
    <?= $errorBox ?>
    <form class="sign-up-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
      <div class="sign-up-grid">

        <div class="form-group">
          <div class="info-group" id="input-usr">
            <label for="usr"><ion-icon name="at-outline"></ion-icon></ion-icon></label>
            <input type="text" id="user" name="username" required placeholder="">
            <span>Username</span>
            <p id="userError" class="hidden"></p>
          </div>
        </div>

        <div class="form-group hidden">
          <div class="info-group" id="input-email">
            <label for="email"><ion-icon name="mail-outline"></ion-icon></label>
            <input type="text" id="email" name="email" required placeholder="">
            <span>Email</span>
            <p id="emailError" class="hidden"></p>
          </div>
        </div>
        <div class="form-group hidden">
          <div class="info-group">
            <label for="firstName"><ion-icon name="person"></ion-icon></label>
            <input type="text" id="firstname" name="firstname" required placeholder="">
            <span>First Name</span>
          </div>
          <div class="info-group">
            <label for="lastname"><ion-icon name="person"></ion-icon></label>
            <input type="text" id="lastname" name="lastname" required placeholder="">
            <span>Last Name</span>
          </div>
        </div>
        <div class="form-group hidden">
          <div class="info-group" id="input-pwd">
            <label for="pwd"><ion-icon name="lock-closed-outline"></ion-icon></label>
            <input type="password" id="pwd" name="password" required placeholder="">
            <span>Password</span>
            <p id="error" class="hidden"></p>
          </div>
          <div class="info-group" id="input-pwd-verif">
            <label for="veri-pswd"><ion-icon name="lock-closed-outline"></ion-icon></label>
            <input type="password" id="pswd-verif" name="veri-pswd" required placeholder="">
            <span>Verify Password</span>
            <p id="verifError" class="hidden"></p>
          </div>
        </div>
      </div>
      <div class="buttons flex flex-row justify-center gap-3">
        <div id="btn-prev" class="px-4 py-1 text-white hidden">Anterior</div>
        <div id="btn-next" class="px-4 py-1 text-white">Siguiente</div>

        <button id="btn-submit" class="px-4 py-1 text-white hidden button-86">Crear</button>
      </div>
    </form>
    <div class="change-form">
      <p>Already have an account?</p>
      <a href="/index.php">Sign In</a>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="/js/typing.js"></script>
  <script src="/js/inputValidation.js"></script>
  <!-- <script src="/js/background.js"></script> -->
  <script src="/js/form_steps.js"></script>
</body>

</html>