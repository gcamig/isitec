<?php
chdir("..");
require "controller/controller.php";
$msgError = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (!empty($_GET)) {
    isset($_GET["code"]) ? $resetPassCode = $_GET["code"] : $resetPassCode = '';
    isset($_GET["mail"]) ? $mail = $_GET["mail"] : $mail = '';

    if (!verifyResetPassCode($mail, $resetPassCode) || !verifyTimeLeft($mail, $resetPassCode)) {
      //todo: meter en la url una variable get para luego en el indice mostrar el error
      header('Location: /index.php?resetPass=error');
      exit();
    } else {
      $firstPass = $_POST["firstPassword"];
      $scndPass = $_POST["scndPassword"];

      if ($firstPass != $scndPass)
        $msgError = "<div class=' text-red-600 font-semibold'>Las contraseñas no coinciden</div>";
      else if (updatePassword($mail, $firstPass)) {
        sendConfirmationEmail($mail);
        header('Location: ../index.php?resetPass=success');
        exit();
      } else {
        header('Location: ../index.php?resetPass=error');
        exit();
      }
    }
  } else {
    header('Location: ../index.php?resetPass=error');
    exit();
  }
}

?>


<!-- TODO: VERIFICAR QUE LAS 2 CONTRAS IGUALES-->
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Reset Password | Isitec</title>
  <meta charset="utf-8">
  <meta name="author" content="author">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="/img/logo-white.png">
  <link rel="stylesheet" type="text/css" href="/css/output.css">
  <link rel="stylesheet" href="/css/common.css">
</head>

<body id="screen">
  <section class="text-animation-box">
    <div>
      <h1 class="typeHeader"></h1>
      <p class="typeText"></p>
    </div>
  </section>
  <section class="form-box">
    <div class="flex justify-center items-center flex-col logo">
      <img src="/img/logo-name.png" alt="logo">
    </div>
    <form class="login-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
      <?= $msgError ?>
      <div class="input-box" id="input-lstPwd">
        <label for="firstPassword"><ion-icon name="lock-closed-outline"></ion-icon></label>
        <input type="password" id="firstPassword" name="firstPassword" required="true" placeholder="">
        <span>Nueva contraseña</span>
        <p id="userError" class="inactive"></p>
      </div>

      <div class="input-box" id="input-newPwd">
        <label for="scndPassword"><ion-icon name="lock-closed-outline"></ion-icon></label>
        <input type="password" id="scndPassword" name="scndPassword" required placeholder="">
        <span>Repetir contraseña</span>
        <p id="error" class="inactive"></p>
      </div>

      <button class="button-86" id="form-button">Cambiar</button>
    </form>
    <div class="change-form">
      <p>Volver al inicio</p>
      <a href="/index.php">Iniciar sesión</a>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="/js/typing.js"></script>
  <script src="/js/inputValidation.js"></script>
  <script src="/js/background.js"></script>
</body>

</html>