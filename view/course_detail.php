<?php
chdir("..");
require_once "controller/controller.php";
if (!isset($_COOKIE['PHPSESSID'])) {
  header('Location: /controller/logout.php');
  exit();
} else {
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    isset($_GET['title']) ? $course = getCourseById($_GET['title']) : header('Location: /view/home.php');

  } else {
    //entramos por post(entramos al añadir video o dar like)
    if (isset($_POST["submit"])) {
            $videoName = $_FILES["video"]["name"];
            $videoHashName = hash('sha256', $_FILES["video"]["name"] . rand(0, 1000)) . '.' . strtolower(pathinfo($videoName, PATHINFO_EXTENSION));
            $target_file = "media/". $videoHashName;
            $uploadOk = 1;
            $videoFileType = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

      // Comprobar si es un archivo de video
      $allowedTypes = array('mp4', 'avi', 'mov', 'flv', 'wmv', 'mpeg');
      if(!in_array($videoFileType, $allowedTypes)) {
          echo "Solo se permiten archivos de video: mp4, avi, mov, flv, wmv, mpeg.";
          $uploadOk = 0;
      }
      // Comprobar si el archivo ya existe
      // if (file_exists($target_file)) {
      //     echo "Lo siento, el archivo ya existe.";
      //     $uploadOk = 0;
      // }

      // Comprobar el tamaño del archivo (en este ejemplo, 100MB)
      if ($_FILES["video"]["size"] > 100000000) {
          echo "Lo siento, tu archivo es demasiado grande.";
          $uploadOk = 0;
      }

      // Si $uploadOk es 0, significa que ocurrió un error
      if ($uploadOk == 0) {
          echo "Lo siento, tu archivo no fue subido.";
      } else {
          if (move_uploaded_file($_FILES["video"]["tmp_name"], $target_file)) {
              echo "El archivo ". htmlspecialchars(basename($_FILES["video"]["name"])). " ha sido subido.";
          } else {
              echo "Lo siento, hubo un error al subir tu archivo.";
          }
      }
    } 
  }
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="/css/output.css" />
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" href="/css/course_detail.css" />
  <link rel="stylesheet" type="text/css" href="/css/selectFile.css" />
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
        };
        ?>  
      
        </section>
        <!-- subir archivos + boton  -->
        <?php if(isFounder($_SESSION['username'], $course['title'])): ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
              <div class="file-upload-panel" onclick="document.getElementById('fileInput').click();">
                  haz clic para seleccionar los videos a subir
                  <input type="file" name="video" id="fileInput" class="file-upload-input">
              </div>
              <input type="submit" name="submit" value="Añadir">
          </form>
        <?php endif; ?>
      <section class="course-content">

      </section>
  </main>
  <script src="/js/selectFile.js"></script>
  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>