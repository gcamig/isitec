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
    isset($_GET['title']) ? $course = getCourseById($_GET['title']) : header('Location: /view/home.php');

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
  <style>
        .file-upload-panel {
            border: 2px dashed #ccc;
            padding: 20px;
            text-align: center;
            cursor: pointer;
        }

        .file-upload-panel:hover {
            background-color: #f0f0f0;
        }

        .file-upload-input {
            display: none;
        }
    </style>
  <link rel="stylesheet" type="text/css" href="/css/output.css" />
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" href="/css/course_detail.css" />
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
                    <a style="color: #6938ef;" href="">Cerrar Sesión</a>
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
    <div class="contenido-central flex flex-col">
      <section class="course-title flex flex-row w-full h">
        <div class="flex flex-col w-full">
          <div class="flex flex-row w-3/5">
            <h1><?php echo $course['title'] ?></h1>
            <div><?php echo $course['score'] ?></div>
          </div>
          <div>
            <p><?php echo $course['description'] ?></p>
          </div>
        </div>
        <?php echo $img = '<div class="course-image w-2/5"
        style="background-image: url(/' . $course['caratula'] . ');"></div>';
        ?>
        <!-- BOTON DE LIKE DISLIKE Y BOTON DE AÑADIR CURSOS -->
        <?php
        if(!isFounder($_SESSION['username'], $course['title']))
        {
          echo '<button class="btn-position">👍</button>';
          echo '<button class="btn-position">👎</button>';
        }else echo '<button class="btn-position">Afegir Videos</button>';

        

        ?>   
      </section>
      <div class="file-upload-panel" onclick="document.getElementById('fileInput').click();">
          Arrastra y suelta imágenes o haz clic para seleccionar archivos
          <input type="file" id="fileInput" class="file-upload-input" multiple>
      </div>

      <script>
          document.getElementById('fileInput').addEventListener('change', function() {
              // Aquí puedes añadir la lógica para manejar los archivos seleccionados
              console.log(this.files);
          });
      </script>
      <section class="course-content">

      </section>
  </main>

  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>