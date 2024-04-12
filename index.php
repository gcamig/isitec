<?php
require_once "controller/controller.php";

$msgError = "";
$errorBox = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { {
    if (!isset($_POST["resetPassMail"])) {
      $user = $_POST["user"];
      $pass = $_POST["password"];
      $result = loginUser($user, $pass);
      if (is_string($result)) {
        $msgError = '<div class=" text-red-600 font-semibold">' . $result . '</div>';
      } else if ($result != false) {
        //TODO: CAMBIAR EN FUNCION DE LO QUE NECESITE EL HOME
        session_start();
        $_SESSION['username'] = $result['username'];
        header('Location: ./view/home.php');
        exit();
      }
    } else {
      if (verifyExistentUser($_POST["resetPassMail"]) == true) {
        $user = [
          'email' => $_POST["resetPassMail"],
          'resetPassCode' => generateResetPassCode($_POST["resetPassMail"])
        ];
        sendEmail($user, "password");
      }
      // verifyExistentUser($user['email']) == true ? sendEmail($user, "password") : $msgError = 'The email does not match with any account';
    }
  }
} else if ($_SERVER["REQUEST_METHOD"] == "GET") {

  if (isset($_COOKIE['PHPSESSID'])) {
    header('Location: ./view/home.php');
    exit();
  }
  // si el $_Get es empty sabem que hem entrar per primera vegada sino vol dir que venim desde el registre
  if (!empty($_GET)) {
    //mirem si el registre s'ha completat correctament
    if (isset($_GET["register"]))
      $_GET["register"] == "success" ? $msgError = "<div class='error-box text-green-500 font-semibold'>Registro correcto</div>" : "<div class='error-box text-red-600 font-semibold'>Ha habido un error en el registro</div>";
    if (isset($_GET["verificationMail"]))
      $_GET["verificationMail"] == "success" ? $msgError = "<div class='error-box text-green-500 font-semibold'>Correo verificado correctamente</div>" : "<div class='error-box text-red-600 font-semibold'>No se ha podido verificar el correo</div>";
    if (isset($_GET["resetPass"]))
      $_GET["resetPass"] == "success" ? $msgError = "<div class='error-box text-green-500 font-semibold'>Contraseña modificada correctamente</div>" : "<div class='error-box text-red-600 font-semibold'>Error al cambiar la contraseña</div>";
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Iniciar sesión | Cetisi</title>
  <meta charset="utf-8">
  <meta name="author" content="Cetisi">
  <meta name="description" content="Programming courses website by Cetisi">
  <meta name="keywords" content="programming, courses, learn, education, web, development">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/logo-white.png">
  <link rel="stylesheet" href="./css/output.css">
  <link rel="stylesheet" href="./css/common.css">
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
    <!-- Reset password -->
    <form class="reset-password-form inactive" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>"
      method="POST">
      <?= $msgError ?> 
      <div class="input-box" id="input-email">
        <label for="email"><ion-icon name="mail-outline"></ion-icon></label>
        <input type="text" id="resetPassMail" name="resetPassMail" required="true" placeholder="">
        <span>Email</span>
        <p id="userError" class="inactive"></p>
      </div>
      <button class="button-86" id="reset-pass-form-button">Enviar</button>
    </form>

    <!-- Fi reset password -->
    <form class="login-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
      <?= $msgError ?>  
      <div class="input-box" id="input-usr">
        <label for="usr"><ion-icon name="person-outline"></ion-icon></label>
        <input type="text" id="usr" name="user" required="true" placeholder="">
        <span>Usuario / Email</span>
        <p id="userError" class="inactive"></p>
      </div>

      <div class="input-box" id="input-pwd">
        <label for="pswd"><ion-icon name="lock-closed-outline"></ion-icon></label>
        <input type="password" id="pswd" name="password" required placeholder="">
        <span>Contraseña</span>
        <p id="error" class="inactive"></p>
      </div>
      <button class="button-86" id="login-form-button">Iniciar sesión</button>
    </form>
    <section class="flex flex-col gap-4">
      <div class="forgot-password">
        <p id="toggle-area-text">¿Has olvidado la contraseña?</p>
        <strong id="toggle-form">Recuperar.</strong>
      </div>

      <div class="change-form">
        <p>¿Todavía no tienes una cuenta?</p>
        <a href="./view/register.php">Registrarme</a>
      </div>
    </section>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="./js/typing.js"></script>
  <script src="./js/modal.js"></script>
</body>
</html>