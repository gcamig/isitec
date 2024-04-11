<?php
chdir("..");
require "controller/controller.php";
session_start();
$profilePic = $_SESSION['user']['profilePic'] != null ? $_SESSION['user']['profilePic'] : "img/user.jpg";
$errorMsg = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (isset($_POST['submit'])) {
    $newUser = [
      'firstName' => $_POST['first_name'],
      'lastName' => $_POST['last_name'],
      'email' => $_POST['email'],
      'password' => $_POST['password'],
      'img' => $_SESSION['user']['profilePic']
    ];

    if ($_FILES["img"]["tmp_name"] != "") {
      //tratamiento de la imagen
      $img_name_hash = hash('sha256', $_FILES["img"]["name"] . rand(0, 1000));
      $img_extension = pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
      $img_destino = "media/" . $img_name_hash . "." . $img_extension;
      //significa que le hemos dado a guardar cambios
      $newUser['img'] = $img_destino;
      move_uploaded_file($_FILES["img"]["tmp_name"], $img_destino);
    }
    if($newUser['firstName']=='' || $newUser['lastName']=='' || $newUser['email']==''){
      $errorMsg = '<div class=" text-red-600 font-semibold">No puedes dejar los campos del perfil bacios</div>';
    }else
    {    
      $_SESSION['user'] = updateUser($_SESSION['user']['username'], $newUser);
      header("Location: /view/profile.php");
      exit();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Perfil | Cetisi</title>
  <meta charset="utf-8">
  <meta name="author" content="Cetisi">
  <meta name="description" content="Programming courses website by Cetisi">
  <meta name="keywords" content="programming, courses, learn, education, web, development">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/icon-white.png">
  <link rel="stylesheet" type="text/css" href="/css/output.css">
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" href="/css/profile.css" />
</head>

<body class="academia" id="screen">
  <?php include "components/header.php"; ?>
  <main class="container">
    <div id="home" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade p-4 show active shadow">
      <form class="w-full" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
        enctype="multipart/form-data">
        <div class="w-full">
          <div class="text-2xl my-2">
            <p class="mb-3">Imagen de perfil</p>
            <hr>
          </div>
          <div class="my-4 flex flex-row ">
            <?php echo '<img class=" size-40 rounded-full" src="/' . $profilePic . '">' ?>
            <div class="slctImg">
              <button type="button" class="w-40 h-14" onclick="document.getElementById('myFiles').click()">Cambiar
                Imagen</button>
              <input type="file" accept="*.jpg, *.jpeg, *.png" id="myFiles" name="img" hidden>
            </div>
          </div>
          <div class="text-2xl mt-5 mb-3">
            <p class="mb-3">Informacion Personal</p>
            <hr>
          </div>
          <div class="user-info-container w-full">
            <div class="info-area">
              <label>Nombre</label>
              <input type="text" name="first_name" placeholder="Escribe aquí tu nombre"
                value="<?php echo $_SESSION['user']['userFirstName'] ?>">
            </div>
            <div class="info-area">
              <label>Apellidos</label>
              <input type="text" name="last_name" placeholder="Escribe aquí tus apellidos"
                value="<?php echo $_SESSION['user']['userLastName'] ?>">
            </div>
            <div class="info-area">
              <label>Email</label>
              <input type="email" name="email" placeholder="Escribe aquí tu email"
                value="<?php echo $_SESSION['user']['mail'] ?>">
            </div>
            <div class="info-area">
              <label>Contraseña</label>
              <input type="password" name="password" placeholder="Escribe aquí tu contraseña">
            </div>
            <div class="info-area">
              <label>Repetir Contraseña</label>
              <input type="password" name="repeatPassword" placeholder="Escribe aquí tu contraseña">
            </div>
        </div>
    </div>
    <div class="flex flex-col mt-5">
      <?php echo $errorMsg; ?>
      <input type="submit" name="submit" value="Guardar Cambios" class="button">
    </div>
    </form>
    </div>
  </main>
  <footer>
    <div class="footer-container">
      <div class="footer-logo">
        <img src="/img/logo-black.png" alt="Cetisi logo">
      </div>
      <div class="footer-info">
        <p>© 2021 Cetisi, Inc. All rights reserved</p>
      </div>
    </div>
  </footer>
  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>