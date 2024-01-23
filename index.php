<?php
require_once "model/db.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if($_POST['form_id'] == "login"){
    $user = $_POST["userLogin"];
    $pass = $_POST["passLogin"];
    $result = loginUser($user, $pass);
    if($result != false){
      session_start();
      $_SESSION['mail'] = $result['mail'];
      $_SESSION['username'] = $result['username'];
      $_SESSION['userFirstName'] = $result['userFirstName'];
      $_SESSION['userLastName'] = $result['userLastName'];
      
      updateLastSignIn($user);
      
      header('Location: ./view/home.php');
    }else{
      //TODO: Mostrar mensaje pop up de login incorrecto
      echo "Login incorrecte";
      
    } 
  }else if ($_POST['form_id'] == "register"){

    $email = $_POST["email"];
    $username = $_POST["user"];
    $firstName = $_POST["firstname"];
    $lastName = $_POST["lastname"];
    $pass = $_POST["pass"];
    $passVerify = $_POST["verifpass"];
    if($pass == $passVerify){
      $user = [
        'mail' => $email,
        'username' => $username,
        'userFirstName' => $firstName,
        'userLastName' => $lastName,
        'passHash' => password_hash($pass, PASSWORD_BCRYPT)
      ];
      if(insertUser($user)){
        echo "Registre correcte";
      }else{
        echo "Registre incorrecte";
      }
    }else {
      echo "La contrasenya no coincideix";
    }
  }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>#</title>
  <meta charset="utf-8">
  <meta name="author" content="author">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="./css/common.css">
</head>

<body>
  <section class="container" id="container">
    <div class="form-container sign-up-container">
      <form class="sign-up-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
        <h2>Sign up</h2>
        <div class="sign-up-grid">
          <div class="input-group">
            <input class="data-input" name="email" type="email" placeholder="" />
            <label class="data-label" for="Email">Email</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="user" type="text" placeholder="" />
            <label class="data-label" for="user">Username</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="firstname" type="text" placeholder="" />
            <label class="data-label" for="firstname">First Name</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="lastname" type="text" placeholder="" />
            <label class="data-label" for="lastname">Last Name</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="pass" type="password" placeholder="" />
            <label class="data-label" for="pass">Password</label>
          </div>
          <div class="input-group">
            <input class="data-input" name="verifpass" type="password" placeholder="" />
            <label class="data-label" for="verifpass">Verify Password</label>
          </div>
        </div>
        <button class="form-button">Sign Up</button>
      </form>
    </div>
    <div class="form-container sign-in-container" id="sign-in-container">
      <form class="login-form" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="POST">
        <h2>Login</h2>
        <div class="input-group">
          <input class="data-input" name="userLogin" type="text" placeholder="" />
          <label class="data-label" for="user">User / email</label>
        </div>
        <div class="input-group">
          <input class="data-input" name="pass" type="text" placeholder="" />
          <label class="data-label" for="pass">Password</label>
        </div>
        <button class="form-button">Sign In</button>
      </form>
    </div>
    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
        <img src="./img/logo.png" alt="">
          <h1>Welcome Back!</h1>
          <p>To keep connected with us please login with your personal info</p>
          <button class="ghost" id="signIn">Sign In</button>
        </div>
        <div class="overlay-panel overlay-right">
        <img src="./img/logo.png" alt="">
          <h1>Don't have an account yet?</h1>
          <p>Enter your personal details and start journey with us</p>
          <button class="ghost" id="signUp">Sign Up</button>
        </div>
      </div>
      <button class="button-86">Sign In</button>
    </form>
    <div class="change-form">
      <p>Don't have an account?</p>
      <a href="./view/register.php">Sign Up</a>
    </div>
  </section>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
  <script src="./js/typing.js"></script>
</body>

</html>