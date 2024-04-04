<?php
chdir("..");
require_once "controller/controller.php";
if (!isset($_COOKIE['PHPSESSID'])) {
  header('Location: /controller/logout.php');
  exit();
} else {
  session_start();
  $hashtags = [];
  $username = $_SESSION['user']['username'];
  $userfullname = $_SESSION['user']['userFirstName'] . " " . $_SESSION['user']['userLastName'];
  $_SESSION['user'] = getUserInfo($_SESSION['username']);
  if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $courses = getCourses();
    $tags = getTags();
  } else {
    //entramos por post(toca verificar los filtros)
    $tags = getTags();
    $hashtags = isset($_POST['hashtags']) ? $_POST['hashtags'] : [];
    $hashtags == [] ? $courses = getCourses() : $courses = getCourseByHashTags($hashtags);
    if(isset($_POST['reset']))
    {
      $courses = getCourses();
      $hashtags = [];
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
  <link rel="stylesheet" type="text/css" href="/css/catalog.css" />
</head>

<body class="academia" id="screen">
  <?php include "model/header.php"; ?>
  <main class="container">
    <div class="title-container flex justify-between items-start p-6">
      <?php echo "<h1>Hola, $firstName. ¿Que quieres aprender?</h1>"; ?>
      <a class="mr-6 px-4 py-1" href="./course_creation.php">Crear</a>
    </div>
    <hr>
    <div class="items-start contenido-central flex flex-row">
      <div class=" courses-container flex flex-wrap justify-items-baseline">
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
                      <?php foreach ($tags as $tag)
                        echo (showTagsHTML($tag, $hashtags)); ?>
                      <input type="submit" value="Filtrar">
                      <input type="submit" name="reset" value="Reiniciar filtro">
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