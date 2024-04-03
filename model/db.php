<?php
function getDBConnection()
{
  /* $connString = 'mysql:host=172.21.0.222;port=3306;dbname=ddb218593;charset=utf8';
  $user = 'ddb218593';
  $pass = 'Cetisi1234';
  $db = null; */
  $connString = 'mysql:host=localhost;port=3306;dbname=isitec;charset=utf8';
  $user = 'root';
  $pass = '';
  $db = null;
  try {
    $db = new PDO($connString, $user, $pass, [PDO::ATTR_PERSISTENT => True]);
  } catch (PDOException $e) {
    echo $e;
  } finally {
    return $db;
  }
}

function loginUserDB($userOrEmail, $pass)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `users` WHERE `mail`=:userOrEmail OR `username`=:userOrEmail";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userOrEmail' => $userOrEmail]);
    if ($usuaris->rowCount() == 1) {
      $dadesUsuari = $usuaris->fetch(PDO::FETCH_ASSOC);
      if ($dadesUsuari['active'] == 1) {
        if (password_verify($pass, $dadesUsuari['passHash'])) {
          $result = $dadesUsuari;
          updateLastSignIn($userOrEmail);
        } else
          $result = "Wrong password";
      } else
        $result = "User not activated";
    } else
      $result = "User or email does not exists";
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}


function insertUserDB($user)
{
  $result = false;
  $conn = getDBConnection();
  $userExists = verifyExistentUserDB($user);
  if ($userExists == true)
    $result = "User or email already exist";
  else if ($userExists == false) {
    $sql = "INSERT INTO users (mail, username, passHash, userFirstName, userLastName, creationDate, removeDate, lastSignIn, active, activationCode) VALUES (:mail, :username ,:passHash, :userFirstName, :userLastName, now(), null, null,0,:activationCode)";
    $mail = $user['email'];
    $pass = $user['passHash'];
    $username = $user['username'];
    $userFirstName = $user['userFirstName'];
    $userLastName = $user['userLastName'];
    $activationCode = $user['activationCode'];
    try {
      $resultat = $conn->prepare($sql);
      $resultat->execute([':mail' => $mail, ':username' => $username, ':passHash' => $pass, ':userFirstName' => $userFirstName, ':userLastName' => $userLastName, ':activationCode' => $activationCode]);

      if ($resultat) {
        $result = true;
      }
    } catch (PDOException $e) {
      echo "";
    } finally {
      return $result;
    }
  }
}
function verifyExistentUserDB($user)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `users` WHERE `mail`=:userMail OR `username`=:userName";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userMail' => $user['email'], ':userName' => $user['username']]);
    if ($usuaris->rowCount() == 1) {
      $result = true;
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function updateLastSignIn($userOrEmail)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "UPDATE `users` SET `lastSignIn`=now() WHERE `mail`=:userOrEmail OR `username`=:userOrEmail";
  try {
    $usuaris = $conn->prepare($sql);
    $rslt = $usuaris->execute([':userOrEmail' => $userOrEmail]);
    if ($rslt)
      $result = true;
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }

}

function getActivationCode($mail)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT activationCode FROM `users` WHERE `mail`=:userMail";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userMail' => $mail]);
    if ($usuaris->rowCount() == 1) {
      $result = $usuaris->fetchColumn();
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function updateActiveDB($mail)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "UPDATE `users` SET `active`=1, `activationDate`=now() WHERE `mail`=:mail";
  try {
    $usuaris = $conn->prepare($sql);
    $rslt = $usuaris->execute([':mail' => $mail]);
    if ($rslt)
      $result = true;
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function generateResetPassCodeDB($mail)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "UPDATE `users` SET `resetPassCode`= :resetPassCode, `resetPassExpiry`=DATE_ADD(NOW(), INTERVAL 30 MINUTE) WHERE `mail`=:mail";
  try {
    $resetPassCode = hash("sha256", rand(0, 9999));
    $usuaris = $conn->prepare($sql);
    $rslt = $usuaris->execute([':mail' => $mail, ':resetPassCode' => $resetPassCode]);
    if ($rslt)
      $result = $resetPassCode;
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function verifyResetPassCodeDB($mail, $resetPassCode)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT resetPassCode FROM `users` WHERE `mail`=:userMail";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userMail' => $mail]);
    if ($usuaris->fetchColumn() == $resetPassCode) {
      $result = true;
    }
  } catch (PDOException $e) {
  } finally {
    return $result;
  }
}

function verifyTimeLeftDB($mail, $resetPassCode)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT resetPassExpiry FROM `users` WHERE `mail`=:userMail AND `resetPassCode`=:resetPassCode";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userMail' => $mail, ':resetPassCode' => $resetPassCode]);
    if ($usuaris->fetchColumn() > time()) {
      $result = true;
    }
  } catch (PDOException $e) {
  } finally {
    return $result;
  }
}

function updatePasswordDB($mail, $firstPass)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "UPDATE `users` SET `passHash`= :resetPass WHERE `mail`=:mail";
  $passHash = password_hash($firstPass, PASSWORD_BCRYPT);
  try {
    $usuaris = $conn->prepare($sql);
    $rslt = $usuaris->execute([':mail' => $mail, ':resetPass' => $passHash]);
    isset($rslt) ? $result = true : $result = false;
    // if ($rslt)
    //   $result = $true;
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function getUserInfoDB($username)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `users` WHERE `username`=:username";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':username' => $username]);
    if ($usuaris->rowCount() == 1) {
      $result = $usuaris->fetch(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function insertCourseDB($course)
{
  $result = false;
  $conn = getDBConnection();
  if (verifyExistentCourse($course['title']) == true)
    $result = "User or email already exist";
  else {
    $sql = "INSERT INTO courses (title, description, hashtags, publishDate,founder, caratula) VALUES (:title, :description ,:hashtags, now(), :founder, :caratula);";
    try {
      $resultat = $conn->prepare($sql);
      $resultat->execute(['title' => $course['title'], ':description' => $course['description'], ':hashtags' => $course['hashtags'], ':founder' => $course['founder'], ':caratula' => $course['caratula']]);
      if ($resultat) {
        $result = true;
      }
    } catch (PDOException $e) {
      echo "";
    } finally {
      return $result;
    }
  }
}

function verifyExistentCourse($courseTitle)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `courses` WHERE `title`=:courseTitle";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':courseTitle' => $courseTitle]);
    if ($usuaris->rowCount() == 1) {
      $result = true;
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function getCoursesDB() /* TODO: Podría devolver null en lugar de false, ya que si no hay cursos y intentas mostrarlos sale error del php */
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `courses`";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute();
    if ($usuaris->rowCount() > 0) {
      $result = $usuaris->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}