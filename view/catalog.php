<?php
chdir("..");
require_once "controller/controller.php";
if (!isset($_COOKIE['PHPSESSID'])) {
  header('Location: /controller/logout.php');
  exit();
} else {
  session_start();
  $_SESSION['user'] = getUserInfo($_SESSION['username']);
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courses = getCourses();
    $tags = getTags();
  } else {
    //entramos por post(entramos por el search)
    // $courses = getCourseByFilter();
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="/css/output.css" />
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
</head>

<body class="academia" id="screen">
  <header class="fixed z-10 w-full">
    <nav class="navbar navbar-top-academia">
      <div class="nav-container w-full">
        <a class="" href="./home.php">
          <figure>
            <img class="" src="/img/logo-name.png" alt="Cetisi" />
            <figcaption class="cetisi-community-badge">Academia</figcaption>
          </figure>
        </a>
        <div class="menu">
          <div class="mr-auto pl-3">
            <ul>
              <li class="nav-item-divider pr-1"></li>
              <li><a href="./home.php">Inicio</a></li>
              <li><a href="./user_space.php">Mi academia</a></li>
              <li><a href="./catalog.php">Cursos</a></li>
            </ul>
          </div>
          <div class="ml-auto">
            <ul>
              <li><ion-icon name="search-sharp"></ion-icon></li>
              <li class="nav-item-divider p-2"></li>
              <li><a href="./course_creation.php"><ion-icon name="notifications-sharp"></ion-icon></a></li>
              <li class="nav-item-divider p-2"></li>
              <li id="dropdown-trigger" class="relative">
                <ion-icon name="person"></ion-icon>
                <div class="user-dropdown absolute hidden" style="width: 200px; background: #fff;">
                  <div class="dropdown-arrow"></div>
                  <div class="flex flex-col p-5">
                    <h4>Username</h4>
                    <small><a style="color: #6938ef;" href="profile">Editar perfil</a></small>
                  </div>
                  <div class="px-5 py-3">
                    <a href="support">Centro de ayuda</a>
                  </div>
                  <div class="p-5">
                    <a style="color: #6938ef;" href="/controller/logout.php">Cerrar Sesión</a>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main class="container">
    <div class="contenido-central flex-col">
      <h1>Hola, User First Name. ¿Qué quieres aprender?</h1>
      <div class="row mb-4">
        <!-- TODO: Carousel -->
      </div>
      <section class="w-full">
        <!-- Seccion 1 -->
        <div class="row items-baseline mt-5">
          <div class="columns-md">
            <h3 class="title flex items-baseline">Descubre los últimos cursos
              <a class="ver-mas" href="#">
                <span>Ver más</span>
                <ion-icon class="ml-2" name="chevron-forward"></ion-icon>
              </a>
            </h3>
          </div>
        </div>
        <div class="w-full" style="min-height: 351px;">
          <div class="swiper swiper-horizontal swiper-backface-hidden">
            <!-- TODO: Carousel con "Tarjetas de los últimos cursos" -->
            <div class="swipe-wrapper flex"
              style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px); transition-delay: 0ms;">
              <!-- Swiper wrapper -->
              <div class="swiper-slide" style="width: 247.5px; margin-right: 50px;">
                <a href="#" class="c-card mb-3">
                  <figure alt="" name="" class="card-img flex justify- items-center"
                    style="background-image: url('https://cdn.openwebinars.net/static/academy/img/bg-card-test-aptitude.jpg');">
                    <img style="max-width: 60px; height:auto" class="img-fluid" data-pagespeed-url-hash="299358230"
                      src="https://cdn.openwebinars.net/media/academy/leveltest/php-logo.svg"
                      onerror="this.onerror=null;pagespeed.lazyLoadImages.loadIfVisibleAndMaybeBeacon(this);">
                  </figure>
                  <div class="card-content">
                    <h3 class="card-title w-full px-3 pt-3">Test de aptitud PHP</h3>
                  </div>
                  <div class="card-footer w-full p-3">
                    <div class="course-rating px-2 flex">
                      <span class="cetisi-badge badge-aptitude_test" style="background-color: #46d4b8;">test</span>
                      <div class="test-aptitude-info ml-2 flex gap-2">
                        <small class="flex gap-1">
                          <ion-icon name="time"></ion-icon>
                          <span>30m</span>
                        </small>
                        ·
                        <small class="total">30 preguntas</small>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="swiper-slide" style="width: 247.5px; margin-right: 50px;">
                <a href="#" class="c-card mb-3">
                  <figure alt="" name="" class="card-img flex justify- items-center"
                    style="background-image: url('https://cdn.openwebinars.net/static/academy/img/bg-card-test-aptitude.jpg');">
                    <img style="max-width: 60px; height:auto" class="img-fluid" data-pagespeed-url-hash="299358230"
                      src="https://cdn.openwebinars.net/media/academy/leveltest/php-logo.svg"
                      onerror="this.onerror=null;pagespeed.lazyLoadImages.loadIfVisibleAndMaybeBeacon(this);">
                  </figure>
                  <div class="card-content">
                    <h3 class="card-title w-full px-3 pt-3">Test de aptitud PHP</h3>
                  </div>
                  <div class="card-footer w-full p-3">
                    <div class="course-rating px-2 flex">
                      <span class="cetisi-badge badge-aptitude_test" style="background-color: #46d4b8;">test</span>
                      <div class="test-aptitude-info ml-2 flex gap-2">
                        <small class="flex gap-1">
                          <ion-icon name="time"></ion-icon>
                          <span>30m</span>
                        </small>
                        ·
                        <small class="total">30 preguntas</small>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div class="swiper-slide" style="width: 247.5px; margin-right: 50px;">
                <a href="#" class="c-card mb-3">
                  <figure alt="" name="" class="card-img flex justify- items-center" style="background-image: url();">
                    <img style="max-width: 60px; height:auto" class="img-fluid" data-pagespeed-url-hash="299358230"
                      src="https://cdn.openwebinars.net/media/academy/leveltest/php-logo.svg"
                      onerror="this.onerror=null;pagespeed.lazyLoadImages.loadIfVisibleAndMaybeBeacon(this);">
                  </figure>
                  <div class="card-content">
                    <h3 class="card-title w-full px-3 pt-3">Test de aptitud PHP</h3>
                  </div>
                  <div class="card-footer w-full p-3">
                    <div class="course-rating px-2 flex">
                      <span class="cetisi-badge badge-aptitude_test" style="background-color: #46d4b8;">test</span>
                      <div class="test-aptitude-info ml-2 flex gap-2">
                        <small class="flex gap-1">
                          <ion-icon name="time"></ion-icon>
                          <span>30m</span>
                        </small>
                        ·
                        <small class="total">30 preguntas</small>
                      </div>
                    </div>
                  </div>
                </a>
              </div>
              <div>
                <form action="">
                  <ul>
                    <li>
                    <?php foreach ($tags as $tag) echo (showTagsHTML($tag)); ?>
                    </li>
                  </ul>
                </form>
              </div>
            </div>
            <div>
              <!-- Swiper buttons -->
            </div>
            <div>
              <!-- Swiper pagination -->
            </div>
          </div>
        </div>
      </section>
    </div>
  </main>

  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>