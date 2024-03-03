<?php
require_once "controller/controller.php";
if ($_SERVER["REQUEST_METHOD"]== "GET")
{
    if (!empty($_GET)) {
        $code = $_GET["code"];
        $mail = $_GET["mail"];
        if (verifyAccount($code, $mail) == true){
            updateActive($mail);
            header('Location: ../index.php?register=success');
            exit();
        }
        //posibilidad de gestionar si no se verifica el correo
      }
}