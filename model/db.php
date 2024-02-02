<?php
function getDBConnection()
{
  $connString = 'mysql:host=172.21.0.222;port=3306;dbname=ddb218593;charset=utf8';
  $user = 'ddb218593';
  $pass = 'Cetisi1234';
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
  $sql = "SELECT * FROM `users` WHERE `mail`=:userOrEmail OR `username`=:userOrEmail AND `active` = 1";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userOrEmail' => $userOrEmail]);
    if ($usuaris->rowCount() == 1) {
      $dadesUsuari = $usuaris->fetch(PDO::FETCH_ASSOC);
      if (password_verify($pass, $dadesUsuari['passHash'])) {
        $result = $dadesUsuari;
        updateLastSignIn($userOrEmail);
        // $result = $dadesUsuari;
      } else
        $result = "Wrong password";
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
  $userExists = verifyExistentUser($user);
  if ($userExists == true)
    $result = "User or email already exist";
  else if (is_string($userExists))
    $result = $userExists;
  else if ($userExists == false) {
    $sql = "INSERT INTO users (mail, username, passHash, userFirstName, userLastName, creationDate, removeDate, lastSignIn, active) VALUES (:mail, :username ,:passHash, :userFirstName, :userLastName, now(), null, null,1)";
    $mail = $user['mail'];
    $pass = $user['passHash'];
    $username = $user['username'];
    $userFirstName = $user['userFirstName'];
    $userLastName = $user['userLastName'];
    try {
      $resultat = $conn->prepare($sql);
      $resultat->execute([':mail' => $mail, ':username' => $username, ':passHash' => $pass, ':userFirstName' => $userFirstName, ':userLastName' => $userLastName]);

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
function verifyExistentUser($user)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT * FROM `users` WHERE `mail`=:userMail OR `username`=:userName";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':userMail' => $user['mail'], ':userName' => $user['username']]);
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