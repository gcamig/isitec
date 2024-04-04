<?php
chdir("..");
require_once "controller/controller.php";

if (!isset($_COOKIE['PHPSESSID'])) {
  header('Location: /controller/logout.php');
  exit();
} else {
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check = getimagesize($_FILES["caratula"]["tmp_name"]);
    if ($check !== false) {
      //tratamiento de la imagen
      $caratula_name_hash = hash('sha256', $_FILES["caratula"]["name"] . rand(0, 1000));
      $caratula_extension = pathinfo($_FILES["caratula"]["name"], PATHINFO_EXTENSION);
      $caratula_destino = "media/" . $caratula_name_hash . "." . $caratula_extension;
      //inserimos el curso   
      $course = [
        'title' => $_POST["title"],
        'description' => $_POST["description"],
        'hashtags' => $_POST["etiquetas"],
        'founder' => $_SESSION['user']['username'],
        'caratula' => $caratula_destino
      ];
      $rslt = insertCourse($course);
      if ($rslt == true) {
        move_uploaded_file($_FILES["caratula"]["tmp_name"], $caratula_destino);
        header('Location: /view/home.php?createCourse=success');
        exit();
      } else
        $msgError = $rslt;
      // insertCourse($course) == true ? header('Location: /view/home.php?createCourse=success') : header('Location: /view/course_creation.php?createCourse=fail');
    }
  } else {
    //entramos por get
    if (isset($_GET["createCourse"]))
      $_GET["createCourse"] == "fail" ? $msgError = "<div class='error-box'>Course creation failed</div>" : '';
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="/css/output.css">
  <link rel="stylesheet" type="text/css" href="/css/home.css">
  <link rel="stylesheet" type="text/css" href="/css/course_creation.css">
</head>

<body class="academia">
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
    <div class="contenido-central">
      <form class="w-full flex flex-col justify-center items-center"
        action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="post" enctype="multipart/form-data">
        <div class="form-group flex flex-col">
          <label for="titulo">Título del Curso:</label>
          <input type="text" id="titulo" name="title" required>
        </div>

        <div class="form-group flex flex-col hidden">
          <label for="descripcion">Descripción del Curso:</label>
          <textarea id="descripcion" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group hidden">
          <label for="etiquetas">Etiquetas:</label>
          <input type="text" id="etiquetas" name="etiquetas" placeholder="#etiqueta1 #etiqueta2 #etiqueta3">
        </div>

        <div class="form-group hidden">
          <label for="caratula">Carátula de Portada:</label>
          <input type="file" id="caratula" name="caratula" accept="image/*" required>
        </div>

        <div class="form-group">
          <button id="submit-button">Siguiente</button>
        </div>
      </form>
    </div>
  </main>
</body>
<script src="/js/user-dropdown.js"></script>
<script src="/js/form_steps.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>