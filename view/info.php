<?php
session_start();
chdir("..");
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
</head>

<body class="academia" id="screen">
  <?php include "components/header.php" ?>
  <main class="container">

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