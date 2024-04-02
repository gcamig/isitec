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
        <a class="" href="/index.html">
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
              <li><ion-icon name="notifications-sharp"></ion-icon></li>
              <li class="nav-item-divider p-2"></li>
              <li><ion-icon name="person"></ion-icon></li>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <main class="container">
    <div class="contenido-central flex-col">
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
    </div>
  </main>

  <!-- <script src="script.js"></script> -->
  <!-- <script src="background.js"></script> -->
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>