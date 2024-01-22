<?php
require_once "model/db.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST["user"];
    $pass = $_POST["pass"];
    if(verificarUsuariBD($user, $pass)){
       console_log("login Works");
    }else {
        console_log("login Failed");
    }

    if($register){
        $usre = 
        $userIns = ['user' => $user, 'pass' => $pass];
        userInsert($userIns);
    }
}

?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Login | Isitec</title>
  <meta charset="utf-8">
  <meta name="author" content="author">
  <meta name="keywords" content="keywords">
  <meta name="description" content="description">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/logo.png">
  <link rel="stylesheet" href="./css/style.css">
</head>

<body>
  <form method="post" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
    <input name="user" type="email" placeholder="Introdueix el teu email" value="<?= isset($_POST["user"]) ? htmlspecialchars($_POST["user"]) : "" ?>" autofocus required>
    <input name="pass" type="password" placeholder="Introdueix el teu password" required>
    <input type="submit" value="Login">
  </form>
</body>

</html>