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
  return hash("sha256", rand(0, 9999));
}

function generateResetPassCode($mail)
{
  return generateResetPassCodeDB($mail);
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
  $mail->Body = mailBodyConstructor($user, $type);
  //Destinatari
  $address = $user['email'];
  $mail->AddAddress($address);

  //Enviament
  $result = $mail->Send();
  if (!$result) {
    echo 'Error: ' . $mail->ErrorInfo;
  } else {
    echo "Correu enviat";
  }
}

function mailBodyConstructor($user, $type)
{
  if ($type == "verification") {
    //TODO: CAMBIAR EL CUERPO COMO DICE EN EL WORD
    $verificationLink = 'http://localhost/controller/mailCheckAccount.php?code=' . $user['activationCode'] . '&mail=' . $user['email'];
    $body = "
          <html>
          <body style='font-size: 1.5em; font-family: Arial, Helvetica, sans-serif;'>
              <p>Hola " . $user['username'] . ",</p>
              <p>Gracias por registrarte en nuestro sitio. Por favor haz clic en el siguiente botón para verificar tu correo electrónico:</p>
              <a href='" . $verificationLink . "' style='display:inline-block;background-color:#4CAF50;color:white;padding:14px 20px;text-align:center;text-decoration:none;display:inline-block;font-size:16px;margin:4px 2px;cursor:pointer;border-radius:10px;'>Verificar Correo</a>
              <p>Gracias,<br>Equipo Cetisi</p>
          </body>
          </html>
      ";
  } else if ($type == "password") {
    $passwordLink = 'http://localhost/view/resetPassword.php?code=' . $user['resetPassCode'] . '&mail=' . $user['email'];
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
  if ($code == getActivationCode($mail))
    return true;
  else
    return false;
}

function updateActive($mail)
{
  updateActiveDB($mail);
}

function verifyExistentUser($mail)
{
  $user = [
    'email' => $mail,
    'username' => '',
  ];
  return verifyExistentUserDB($user);
}
function verifyResetPassCode($mail, $resetPassCode)
{
  return verifyResetPassCodeDB($mail, $resetPassCode);
}

function verifyTimeLeft($mail, $resetPassCode)
{
  return verifyTimeLeftDB($mail, $resetPassCode);
}

function updatePassword($mail, $firstPass)
{
  return updatePasswordDB($mail, $firstPass);
}

function sendConfirmationEmail($email)
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
  $mail->Subject = 'Confirmation email';
  $mail->isHTML(true);
  $mail->Body = confirmationEmailBodyConstructor();

  //Destinatari
  $address = $email;
  $mail->AddAddress($address);

  //Enviament
  $result = $mail->Send();
  if (!$result) {
    echo 'Error: ' . $mail->ErrorInfo;
  } else {
    echo "Correu enviat";
  }
}

function confirmationEmailBodyConstructor()
{
  $body = '
  <html>
  <body>
    <div class="container">
        <div class="header">
            <h2>Cambio de Contraseña</h2>
        </div>
        <div class="content">
            <p>Su contraseña ha sido cambiada correctamente. Si usted no ha realizado este cambio, por favor póngase en contacto con nosotros de inmediato.</p>
        </div>
        <div class="footer">
            <p>Este es un mensaje automático. Por favor, no responda a este correo.</p>
        </div>
    </div>
  </body>
  </html>
  ';
  return $body;
}

function getUserInfo($username)
{
  return getUserInfoDB($username);
}

function insertCourse($course)
{
  return insertCourseDB($course);
}

function getCourses()
{
  return getCoursesDB();
}

function showCourseHTML($course)
{
  $tags = getCourseHashTags($course['idcourse']);
  $courseHTML = '<div class="swiper-slide" style="margin-right: 25px;">
                <a href="./course_detail.php?title=' . $course["title"] . '" class="c-card mb-6">
                  <div style="background-image: url(/' . $course["caratula"] . '); background-repeat: no-repeat;" alt="" name="" class="card-img flex justify- items-center"></div>
                  <div class="card-content">
                    <h3 class="card-title w-full px-3 pt-3">';
  $courseHTML .= $course["title"];
  $courseHTML .= '</h3>';
  // <div class="w-full p-2 overflow-hidden float-left" style="height: 50px">';
  // foreach ($tags as $tag) {
  //   $courseHTML .= '<div>#' . $tag . '</div>';
  // }
  // </div>
  $courseHTML .= '</div>
                  <div class="card-footer w-full p-3">
                    <div class="w-full course-rating px-2 flex">
                      <span class="cetisi-badge badge-aptitude_test" style="background-color: #46d4b8; font-size: 10px;">course</span>
                      <div class="w-full test-aptitude-info ml-2 flex items-center justify-between gap-2">
                        <small class="w-full flex gap-1 items-center"><ion-icon name="star"></ion-icon>
                        ' . $course['score'] . '                  
                        </small>                
                      </div>
                    </div>
                  </div>
                </a>
              </div>';
  return $courseHTML;
}

function getTags()
{
  return getTagsDB();
}

function getCourseHashTags($courseId)
{
  return getCourseHashTagsDB($courseId);
}

function showTagsHTML($tag, $tagsSeleccionados)
{
  $checked = in_array($tag["tag"], $tagsSeleccionados) ? 'checked' : '';
  $tagHTML = '<li><input type="checkbox" name="hashtags[]" value="';
  $tagHTML .= $tag["tag"] . '" ' . $checked;
  $tagHTML .= '> ';
  $tagHTML .= $tag["tag"];
  $tagHTML .= '</input></li>';
  return $tagHTML;
}

function getCourseByHashTags($hashtags)
{
  return getCourseByHashTagsDB($hashtags);
}

function getCourseById($title)
{
  return getCourseByIdBD($title);
}

function isFounder($username, $title)
{
  return isFounderDB($username, $title);
}

function insertVideo($video)
{
  return insertVideoDB($video);
}

function getVideosByCourse($courseID)
{
  return getVideosByCourseDB($courseID);
}

function showVideosHTML($video)
{
  return '<div class="lesson-card flex flex-col gap-4 p-5">
  <h2>' . $video['videoName'] . '</h2>
  <p>' . $video['descripcion'] . '</p>
  <dialog class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-10 backdrop:backdrop-blur-[3px]">
    <video controls src="/' . $video['video'] . '"></video>
  </dialog>
</div>';
}

function insertLike($courseId)
{
  insertLikeDB($courseId);
}

function insertDislike($courseId)
{
  insertDislikeDB($courseId);
}

function deleteCourse($courseId)
{
  deleteCourseDB($courseId);
}

function updateUser($actualUser, $newUser)
{
  return updateUserDB($actualUser, $newUser);
}