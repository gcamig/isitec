<?php
chdir("..");
  require_once "controller/controller.php";
  if (!isset($_COOKIE['PHPSESSID'])) {
    header('Location: /controller/logout.php');
    exit();
  }
  else 
  {
    session_start();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false){
        //tratamiento de la imagen
        $caratula = $_FILES['caratula']['tmp_name'];         
        $course = [
          'title' => $_POST["title"],
          'description' => $_POST["description"],
          'etiquetas_array' => explode('#', $_POST["etiquetas"]),
          'caratula' => addslashes(file_get_contents($caratula)),
          'founder' => $_SESSION['user']['username']
        ];
        //TODO: MODIFICAR EL IF PARA HACER LO NECESARIO CON EL HOME DEFINITIVO
      insertCourse($course) == true ? header('Location: /view/home.php?createCourse=success') : header('Location: /view/course_creation.php?createCourse=fail');
      exit();
        }
    }else{
        //entramos por get
        if(isset($_GET["createCourse"])) $_GET["createCourse"] == "fail" ? $msgError = "<div class='error-box'>Course creation failed</div>" : '';
    }
  }
?>

<!DOCTYPE html>
<html>
<head>
  <title>Home Page</title>
  <link rel="stylesheet" type="text/css" href="/css/home.css">
  <style>
        /* Estilos opcionales para el formulario */
        .form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            font-weight: bold;
        }
        .form-group input[type="text"],
        .form-group input[type="file"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .form-group input[type="submit"] {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="form-container">
    <form action="<?php htmlspecialchars($_SERVER["REQUEST_METHOD"])?>" method="post" enctype="multipart/form-data">
        
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

</body>
  <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>