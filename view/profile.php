<?php
chdir("..");
session_start();
if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST['submit'])) {
    //significa que le hemos dado a guardar cambios
    $newUser = [
      'firstName' => $_POST['first_name'],
      'lastName' => $_POST['last_name'],
      'email' => $_POST['email'],
      'password' => $_POST['password']
    ];
  }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <title>Inicio | Cetisi</title>
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
  <?php include "components/header.php";?>
  <main class="container">
    <nav id="nav-academia" class="bg-transparent">
        <ul class="nav nav-pills d-flex justify-content-between">
            <li class="nav-item">
                <a class="nav-link active" href="">Mi perfil</a>
            </li>
        </ul>
    </nav>
    <div id="home" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade p-4 show active shadow">
        <form class="ow-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
          <div>
            <div class="text-2xl my-2">
              <p class="mb-3">Imagen de perfil</p>
              <hr>
            </div>
            <div class="my-4 flex flex-row ">
              <img class=" size-40 rounded-full" src="/media/6858de99d6d381ec14e99972108cc4ac33298513fd0140614265a950f39caac0.png">
              <div class="slctImg">
                <button type="button" class="w-40 h-14" onclick="document.getElementById('myFiles').click()">Seleccionar Imagen</button>
                <input type="file" accept="*.jpg, *.jpeg, *.png" id="myFiles" name="img" hidden>
              </div>
            </div>
            <div class="text-2xl mt-5 mb-3">
              <p class="mb-3">Informacion Personal</p>
              <hr>
            </div>
            <div>
              <div class="flex flex-row">
                <div class="flex flex-col">
                  <label>Nombre</label>
                  <input type="text"   name="first_name" placeholder="Escribe aquí tu nombre" >
                </div>
                <div class="flex flex-col">
                <label>Apellidos</label>
                  <input type="text"  name="last_name" placeholder="Escribe aquí tus apellidos" >
                </div>
              </div>
              <div class="flex flex-row">
                <div class="flex flex-col">
                  <label>Email</label>
                  <input type="text"  name="email" placeholder="Escribe aquí tu email" >
                </div>
                <div class="flex flex-col">
                <label>Contraseña</label>
                  <input type="text"  name="password" placeholder="Escribe aquí tu contraseña" >
                </div>
              </div>
            </div>
          </div>
          <input type="submit" name="submit" value="Guardar Cambios" class="button">
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