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
    $hashtags = isset($_POST['hashtags']) ? $_POST['hashtags'] : [];
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
  <link rel="stylesheet" type="text/css" href="/css/catalog.css" />
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
    <div class="contenido-central flex flex-row">
      <div class="courses-container flex flex-wrap">
        <!-- usar este div para los cursos -->
        <?php foreach ($courses as $course)
          echo (showCourseHTML($course)); ?>
      </div>

      <aside class="aside">
        <div>
          <!-- Borrar filtros -->
        </div>
        <form>
          <h3>Filtrar</h3>
          <div class="searchbox">
            <form action="search">
              <input class="ais-SearchBox-input" type="search" placeholder="Buscar por nombre" autocomplete="off"
                autocorrect="off" autocapitalize="off" spellcheck="false" maxlength="512" aria-label="Search">
            </form>
          </div>
        </form>
        <div class="dynamic-widgets-c">
          <div class="dynamic-widgets">
            <div class="widget">
              <div>
                <span>Categorías</span>
              </div>
              <div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                  <ul>
                    <li>
                      <?php foreach ($tags as $tag) echo (showTagsHTML($tag)); ?>
                      <input type="submit" value="Filtrar">
                    </li>
                  </ul>
                </form>
              </div>
            </div>
          </div>
        </div>
      </aside>
  </main>

  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>