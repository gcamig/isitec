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

function generateResetPassCode()
{
  return hash("sha256",rand(0, 9999));
}

function sendEmail($user, $type)
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
  $mail->SetFrom('support@cetisi.cat', 'Soporte Cetisi');
  $mail->Subject = ($type == "verification") ? 'Verificación de correo' : 'Restablecer contraseña';
  $mail->isHTML(true);
  $mail->Body = mailBodyConstructor($user,$type);
  //Destinatari
  $address = $email;
  $mail->AddAddress($address, 'Test');

  //Enviament
  $result = $mail->Send();
  if (!$result) {
    echo 'Error: ' . $mail->ErrorInfo;
  } else {
    echo "Correu enviat";
  }
}

function mailBodyConstructor($user,$type)
{
  if($type == "verification"){
  //TODO: CAMBIAR EL CUERPO COMO DICE EN EL WORD
    $verificationLink = 'http://localhost/controller/mailCheckAccount.php?code=' . $user['activationCode'] . '&mail=' . $user['mail'];
    $body = "
          <html>
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
  }else if($type == "password"){
    $passwordLink = 'http://localhost/controller/mailCheckAccount.php?code=' . $user['resetPassCode'] . '&mail=' . $user['mail'];
      $body = "
      <html>
      <body>
        <p>Hola,</p>
        <p>Recibiste este correo porque solicitaste restablecer tu contraseña en nuestro sitio web.</p>
        <p>Si no hiciste esta solicitud, puedes ignorar este mensaje.</p>
        <p>Para restablecer tu contraseña, haz clic en el siguiente botón:</p>
        <a href='" . $passwordLink . "' style='display:inline-block;background-color:#4CAF50;color:white;padding:14px 20px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;border-radius:10px;'>Restablecer Contraseña</a>
        <p>Si el botón no funciona, puedes copiar y pegar el siguiente enlace en tu navegador:</p>
        <p><a href='" . $passwordLink . "'>" . $passwordLink . "</a></p>
        <p>Gracias,</p>
        <p>Tu equipo de soporte</p>
      </body>
      </html>";
  }
    return $body;
}

function verifyAccount($code, $mail)
{
  //TODO:añadir en el if para comprobar que no este validado ya.
  if($code == getActivationCode($mail)) return true;
  else return false;
}

function updateActive($mail){
  updateActiveDB($mail);
}