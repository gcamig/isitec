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
  <section class="text-animation-box">
    <div>
      <h1 class="typeHeader">Welcome back!</h1>
      <p class="typeText"></p>
    </div>
  </section>
  <section class="form-box">
    <h1>Login</h1>
    <form class="login-form">
      <div class="input-box">
        <label for="usr"><ion-icon name="person-outline"></ion-icon></label>
        <input type="text" id="usr" name="user" required="true" placeholder="">
        <span>User / Email</span>
      </div>
      <div class="input-box">
        <label for="pswd"><ion-icon name="lock-closed-outline"></ion-icon></label>
        <input type="password" id="pswd" name="password" required="" placeholder="">
        <span>Password</span>

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