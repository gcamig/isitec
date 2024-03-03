<?php
use PHPMailer\PHPMailer\PHPMailer; 
require 'vendor/autoload.php';
require_once "model/db.php";

function loginUser($userOrEmail, $pass)
{
  return loginUserDB($userOrEmail, $pass);
}

function insertUser($user)
{
  return insertUserDB($user);
}

function generateActivationCode()
{
  return hash("sha256",rand(0, 9999));
}

function verificationEmail($user)
{
  $mail = new PHPMailer(true);
  $mail->IsSMTP();
  //Configuració del servidor de Correu
  //Modificar a 0 per eliminar msg error
  $mail->SMTPDebug = 0;
  $mail->SMTPAuth = true;
  $mail->SMTPSecure = 'tls';
  $mail->Host = 'smtp.dondominio.com';
  $mail->Port = 587;
  //Credencials del compte GMAIL
  $mail->Username = 'support@cetisi.cat';
  $mail->Password = 'Cetisi@1234';

  //Dades del correu electrònic
  $mail->SetFrom('support@cetisi.cat', 'Test');
  $mail->Subject = 'Correu de test';
  $mail->Body = mailBodyConstructor($user);
  //Destinatari
  $address = 'ferran.viaplanal@educem.net';
  $mail->AddAddress($address, 'Test');

  //Enviament
  $result = $mail->Send();
  if (!$result) {
    echo 'Error: ' . $mail->ErrorInfo;
  } else {
    echo "Correu enviat";
  }
}

function mailBodyConstructor($user)
{
  //TODO: CAMBIAR EL CUERPO COMO DICE EN EL WORD
  $verificationLink = 'http://localhost/controller/mailCheckAccount.php?code=' . $user['activationCode'] . '&mail=' . $user['mail'];
  $body = "
        <html>
        <head>
            <title>Verificación de Correo Electrónico</title>
        </head>
        <body>
            <p>Hola " . $user['username'] . ",</p>
            <p>Gracias por registrarte en nuestro sitio. Por favor haz clic en el siguiente botón para verificar tu correo electrónico:</p>
            <a href='" . $verificationLink . "' style='display:inline-block;background-color:#4CAF50;color:white;padding:14px 20px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;border-radius:10px;'>Verificar Correo</a>
            <p>Si el botón no funciona, también puedes copiar y pegar el siguiente enlace en tu navegador:</p>
            <p><a href='" . $verificationLink . "'>" . $verificationLink . "</a></p>
            <p>Gracias,<br>Tu equipo</p>
        </body>
        </html>
    ";

    return $body;
}

function verifyAccount($code, $mail)
{
  if($code == getActivationCode($mail)) return true;
  else return false;
}

function updateActive(){
  updateActiveDB();
}