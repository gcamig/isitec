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
        'founder' => $_SESSION['username'],
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
</head>

<body>
  <?php include "model/header.php"; ?>
  <main>
    <div class="form-container">
      <form action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>" method="post" enctype="multipart/form-data">

        <div class="form-group">
          <label for="titulo">Título del Curso:</label>
          <input type="text" id="titulo" name="title" required>
        </div>

        <div class="form-group">
          <label for="descripcion">Descripción del Curso:</label>
          <textarea id="descripcion" name="description" rows="4" required></textarea>
        </div>

        <div class="form-group">
          <label for="etiquetas">Etiquetas:</label>
          <input type="text" id="etiquetas" name="etiquetas" placeholder="#etiqueta1 #etiqueta2 #etiqueta3">
        </div>

        <div class="form-group">
          <label for="caratula">Carátula de Portada:</label>
          <input type="file" id="caratula" name="caratula" accept="image/*" required>
        </div>

        <div class="form-group">
          <input type="submit" value="Enviar">
        </div>

      </form>
    </div>
  </main>
</body>
<script src="/js/user-dropdown.js"></script>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>