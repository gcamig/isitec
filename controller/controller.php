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

function verificationEmail($user)
{
  $mail = new PHPMailer();
  $mail->IsSMTP();
  //Configuració del servidor de Correu
  //Modificar a 0 per eliminar msg error
  $mail->SMTPDebug = 2;
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
  $mail->MsgHTML('Prova');

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