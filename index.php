<?php
require_once "controller/controller.php";

$msgError = "";
$errorBox = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") { {
    $user = $_POST["user"];
    $pass = $_POST["password"];
    if (!isset($_POST["resetpass"])) {
      $result = loginUser($user, $pass);
      if (is_string($result)) {
        $msgError = $result;
      } else if ($result != false) {
        session_start();
        $_SESSION['mail'] = $result['mail'];
        $_SESSION['username'] = $result['username'];
        $_SESSION['userFirstName'] = $result['userFirstName'];
        $_SESSION['userLastName'] = $result['userLastName'];
  
        header('Location: ./view/home.php');
        exit();
      }
    }else {
      $user = [
        'mail' => $_POST["resetpass"],
        'resetPassCode' => generateResetPassCode()
      ];
      sendEmail($user, "password");
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
    if ($_GET["register"] == "success") {
      $msgError = "<div class='error-box'>Registre correcte</div>";
    }
    if ($_GET["verificationMail"] == "success"){
      $msgError = "<div class='error-box'>Correu verificat correctament</div>";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Login | Isitec</title>
  <meta charset="utf-8">
  <meta name="author" content="author">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/common.css">
  <link rel="icon" href="./img/logo-white.png">
</head>

<body id="screen">
  <section class="text-animation-box">
    <div>
      <h1 class="typeHeader">Welcome back!</h1>
      <p class="typeText"></p>
    </div>
    <!-- Modal -->
    <section id="passModal" class="hide"  >
        <div class="modal-content">
          <span class="closeModal">close</span>
          <form action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>">
            <div class="input-box" id="input-usr">
              <label for="resetpass"><ion-icon name="person-outline"></ion-icon></label>
              <input type="text" id="resetpass" name="user" required="true" placeholder="">
              <span>Email</span>
            </div>
          </form>
        </div>
      </section>
      <!-- FI MODAL -->
  </section>
  <section class="form-box">
    <h1>Login</h1>
    <?= $msgError ?>
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
      <button class="button-86" id="form-button">Sign In</button>
    </form>
    <!-- LLAMADA MODAL -->
    <p id="openModal">Forgot password? Click here.</p>
      
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