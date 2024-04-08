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
<html lang="es">

<head>
  <title>Crear curso | Cetisi</title>
  <meta charset="utf-8">
  <meta name="author" content="Cetisi">
  <meta name="description" content="Programming courses website by Cetisi">
  <meta name="keywords" content="programming, courses, learn, education, web, development">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/icon-white.png">
  <link rel="stylesheet" type="text/css" href="/css/output.css">
  <link rel="stylesheet" type="text/css" href="/css/home.css">
  <link rel="stylesheet" type="text/css" href="/css/course_creation.css">
</head>

<body class="overflow-y-hidden">
  <?php include "/components/header.php"; ?>
  <main>
    <div class="contenido-central flex items-center">
      <form class="w-full flex gap-4 flex-col" action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"]) ?>"
        method="post" enctype="multipart/form-data">

        <div class="form-group active">
          <label for="titulo">Título del Curso</label>
          <input type="text" id="titulo" required name="title">
        </div>

        <div class="form-group hidden">
          <label for="descripcion">Descripción del Curso</label>
          <textarea id="descripcion" name="description" required rows="4"></textarea>
        </div>

        <div>
          <!-- Tags selection -->
          <label for="etiquetas">Etiquetas</label>
          <div class="tags-container flex flex-wrap gap-2">
            <?php
            $tags = getTags();
            foreach ($tags as $tag) {
              echo "<div class='tag' data-tag='$tag'>$tag</div>";
            }
            ?>
        </div>

        <div class="form-group hidden">
          <label for="caratula">Portada</label>
          <input type="file" id="caratula" name="caratula" required accept="image/*">
        </div>

        <div class="form-group flex flex-row justify-center gap-3">
          <div id="btn-prev" class="px-4 py-1 text-white">Anterior</div>
          <div id="btn-next" class="px-4 py-1 text-white">Siguiente</div>

          <button id="btn-submit" class="px-4 py-1 text-white hidden">Crear</button>
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