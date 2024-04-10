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
    $videos = getVideosByCourse($course['idcourse']);
  } else {
    //entramos por post(entramos al añadir video o dar like)
    $course = getCourseById($_POST['courseID']);
    $videos = getVideosByCourse($course['idcourse']);
    if (isset($_POST["submit"]) && $_POST["submit"] == "Añadir") {
      $videoName = $_FILES["video"]["name"];
      $videoHashName = hash('sha256', $_FILES["video"]["name"] . rand(0, 1000)) . '.' . strtolower(pathinfo($videoName, PATHINFO_EXTENSION));
      $target_file = "media/" . $videoHashName;
      $uploadOk = 1;
      $videoFileType = strtolower(pathinfo($videoName, PATHINFO_EXTENSION));

      // Comprobar si es un archivo de video
      $allowedTypes = array('mp4', 'avi', 'mov', 'flv', 'wmv', 'mpeg');
      if (!in_array($videoFileType, $allowedTypes)) {
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

      $video = [
        'videoName' => $videoName,
        'video' => $target_file,
        'courseID' => $course['idcourse']
      ];

      $video['videoName'] == "" ? $insert = false : $insert = insertVideo($video);
      // Si $uploadOk es 0, significa que ocurrió un error
      if ($uploadOk == 0 && $insert == false) {
        //mensaje de error de archivo no valido
        echo "Lo siento, tu archivo no fue subido.";
      } else {
        //todo: modificar esto no hacen falta los echo
        move_uploaded_file($_FILES["video"]["tmp_name"], $target_file);
        $videos = getVideosByCourse($course['idcourse']);
      }
    } else if (isset($_POST["rating"])) {
      $_POST["rating"] == "👍" ? insertLike($course['idcourse']) : insertDislike($course['idcourse']);
      $course = getCourseById($_POST['courseID']);
    } else if (isset($_POST["delete"])) {
      deleteCourse($course['idcourse']);
      header('Location: /view/home.php');
      exit();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <title>Detalle | Cetisi</title>
  <meta charset="utf-8">
  <meta name="author" content="Cetisi">
  <meta name="description" content="Programming courses website by Cetisi">
  <meta name="keywords" content="programming, courses, learn, education, web, development">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="./img/icon-white.png">
  <link rel="stylesheet" type="text/css" href="/css/output.css" />
  <link rel="stylesheet" type="text/css" href="/css/home.css" />
  <link rel="stylesheet" type="text/css" href="/css/course_detail.css" />
  <link rel="stylesheet" type="text/css" href="/css/selectFile.css" />
</head>

<body class="academia" id="screen">
  <?php include "components/header.php"; ?>
  <main class="container">
    <div class="contenido-central flex flex-col">
      <section class="course-title flex flex-row w-full mb-5">
        <div class="flex flex-col w-3/5 p-4">
          <h1 class="text-lg">
            <?php echo $course['title'] ?>
          </h1>
          <p>
            <?php echo $course['description'] ?>
          </p>
          <div>
            <?php echo '<ion-icon name="star"></ion-icon>' . ' ' . $course['score'] ?>
          </div>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <?php
            if (isFounder($_SESSION['username'], $course['title'])) {
              echo '<input type="submit" name="rating" value=""><ion-icon name="thumbs-up"></ion-icon></input>';
              echo '<input type="submit" name="rating" value=""><ion-icon name="thumbs-down"></ion-icon></input>';
              echo '<input type="hidden" name="courseID" value ="' . $course['title'] . '">';
            };
            ?>
          </form>
        </div>
        <?php echo '<div class="course-image w-2/5"
        style="background-size: cover; background-image: url(/' . $course['caratula'] . ');"></div>';
        ?>
      </section>
    </div>
  </main>
  <script src="/js/course_detail.js"></script>
  <script src="/js/user-dropdown.js"></script>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>