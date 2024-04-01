<?php
chdir("..");
  require_once "controller/controller.php";
  if (!isset($_COOKIE['PHPSESSID'])) {
    header('Location: /controller/logout.php');
    exit();
  }
  else 
  {
    session_start();
    $user = getUserInfo($_SESSION['username']);
  }

?>

<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="/css/home.css">
</head>
<body id="screen">
  <section class="left-side-panel">
    <div class="nav-title">
      <img src="./img/white.jpeg" alt="Cetisi icon">
      <hr>
      <h2>Cetisi</h2>
    </div>
    <hr>
      <nav class="nav-content">
        <div>
          <ul>
            <li><a href="/view/home.php"><ion-icon name="home"></ion-icon></a></li>
            <li><a href="user-courses.html"><ion-icon name="school"></ion-icon></ion-icon></a></li>
            <li><a href="saved-courses.html"><ion-icon name="heart"></ion-icon></a></li>
            <li><a href="settings.html"><ion-icon name="settings"></ion-icon></a></li>
          </ul>
        </div>
        <div>
          <ul>
            <li><a href="contact.html"><ion-icon name="mail"></ion-icon></a></li>
            <li><a href="/controller/logout.php"><ion-icon name="log-out"></ion-icon></a></li>
          </ul>
        </div>
      </nav>
  </section>

  <main>
    <h1 class="col-12"><?= 'Hola, ' . $user['username'] .  '. ¡Elige tu siguiente reto!'?></h1>
    <section class="welcome-area col-12">
      <div class="col-5">
        <div class="slider-wrapper">
          <div class="slider">
            <img id src="https://images.unsplash.com/photo-1464013778555-8e723c2f01f8?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
            <img id src="https://images.unsplash.com/photo-1500073584060-670c36a703f1?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
            <img id src="https://images.unsplash.com/photo-1485470733090-0aae1788d5af?q=80&w=2117&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="">
          </div>
          <div class="slider-prev">
            <a class="prev" href="#"><ion-icon name="arrow-back-outline"></ion-icon></a>
          </div>
          <div class="slider-next">
            <a class="next" href="#"><ion-icon name="arrow-forward-outline"></ion-icon></a>
          </div>
        </div>
      </div>
      <div class="level-card col-2">
        
      </div>
    </section>
    
    <h2>Featured Courses</h2>
    <footer>
      <p>&copy; 2024 Cetisi. All rights reserved.</p>
    </footer>
  </main>
  <script src="/js/carousel.js"></script>
  <script src="/js/background.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>