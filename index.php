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
        $msgError = $result;
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
      $_GET["register"] == "success" ? $msgError = "<div class='error-box'>Registre correcte</div>" : '';
    if (isset($_GET["verificationMail"]))
      $_GET["verificationMail"] == "success" ? $msgError = "<div class='error-box'>Correu verificat correctament</div>" : '';
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Login | Cetisi</title>
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
      <h1 class="typeHeader">Welcome back!</h1>
      <p class="typeText"></p>
    </div>
  </section>
  <section class="form-box">
    <h1>Login</h1>
    <?= $msgError ?>
    <!-- Reset password -->
    <form class="reset-password-form inactive" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>"
      method="POST">
      <div class="input-box" id="input-email">
        <label for="email"><ion-icon name="person-outline"></ion-icon></label>
        <input type="text" id="resetPassMail" name="resetPassMail" required="true" placeholder="">
        <span>Email</span>
        <p id="userError" class="inactive"></p>
      </div>
      <button class="button-86" id="reset-pass-form-button">Submit</button>
    </form>

    <!-- Fi reset password -->
    <form class="login-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
      <div class="input-box" id="input-usr">
        <label for="usr"><ion-icon name="person-outline"></ion-icon></label>
        <input type="text" id="usr" name="user" required="true" placeholder="">
        <span>User / Email</span>
        <p id="userError" class="inactive"></p>
      </div>

      <div class="input-box" id="input-pwd">
        <label for="pswd"><ion-icon name="lock-closed-outline"></ion-icon></label>
        <input type="password" id="pswd" name="password" required placeholder="">
        <span>Password</span>
        <p id="error" class="inactive"></p>
      </div>
      <button class="button-86" id="login-form-button">Sign In</button>
    </form>
    <div class="forgot-password">
      <p id="toggle-area-text">Forgot password?</p>
      <strong id="toggle-form">Click here.</strong>
    </div>

    <div class="change-form">
      <p>Don't have an account?</p>
      <a href="./view/register.php">Sign Up</a>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="./js/typing.js"></script>
  <script src="./js/background.js"></script>
  <script src="./js/modal.js"></script>
</body>

</html>