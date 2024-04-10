<?php
chdir("..");
session_start();
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
  <link rel="stylesheet" type="text/css" href="/css/output.css" />
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
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
    <div id="home" role="tabpanel" aria-labelledby="home-tab" class="tab-pane fade p-4 show active">
        <form class="ow-form">
          <div>
            <div>
              <p>Imagen de perfil</p>
              <hr>
            </div>
            <div>
              <img src="">
              <div>
                <button onclick="document.getElementById('myFiles').click()">Añadir archivos</button>
                <input type="file" accept="*.jpg, *.jpeg, *.png" id="myFiles" name="" hidden>
              </div>
            </div>
            <div>
              <p>Informacion Personal</p>
              <hr>
            </div>
            <div>
              <div>
                <div>
                  <label>Nombre</label>
                  <input type="text" required="required" id="profile.owner.first_name" name="profile.owner.first_name" placeholder="Escribe aquí tu nombre" class="form-control">
                </div>
                <div>
                <label>Apellidos</label>
                  <input type="text" required="required" id="profile.owner.first_name" name="profile.owner.first_name" placeholder="Escribe aquí tu nombre" class="form-control">
                </div>
              </div>
              <div>
                <div>
                  <label>Email</label>
                  <input type="text" required="required" id="profile.owner.first_name" name="profile.owner.first_name" placeholder="Escribe aquí tu nombre" class="form-control">
                </div>
                <div>
                <label>Contraseña</label>
                  <input type="text" required="required" id="profile.owner.first_name" name="profile.owner.first_name" placeholder="Escribe aquí tu nombre" class="form-control">
                </div>
              </div>
            </div>
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