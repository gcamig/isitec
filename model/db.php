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
    $db = new PDO($connString, $user, $pass, [PDO::ATTR_PERSISTENT => true]);
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
        } else {
          $result = "Wrong password";
        }

      } else {
        $result = "User not activated";
      }

    } else {
      $result = "User or email does not exists";
    }

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
  if ($userExists == true) {
    $result = "User or email already exist";
  } else if ($userExists == false) {
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
    if ($rslt) {
      $result = true;
    }

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
    if ($rslt) {
      $result = true;
    }

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
    if ($rslt) {
      $result = $resetPassCode;
    }

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
  if (verifyExistentCourse($course['title']) == true) {
    $result = "User or email already exist";
  } else {
    $sql = "INSERT INTO courses (title, description, publishDate, founder, caratula) VALUES (:title, :description, now(), :founder, :caratula);";
    try {
      $resultat = $conn->prepare($sql);
      $resultat->execute([
        'title' => $course['title'],
        ':description' => $course['description'],
        ':founder' => $course['founder'],
        ':caratula' => $course['caratula']
      ]);

      $courseId = $conn->lastInsertId();
      // $hashtags = explode('#', $course['hashtags']);
      // array_shift($hashtags);
      foreach ($course['hashtags'] as $tag) {
        if ($tag != "") {
          $tag = trim($tag);
          $sql = "SELECT idtag FROM tags WHERE tag = :tag";
          $resultat = $conn->prepare($sql);
          $resultat->execute([':tag' => $tag]);
          $row = $resultat->fetch(PDO::FETCH_ASSOC);
          if ($row) {
            $tagId = $row['idtag'];
          } else {
            $sql = "INSERT INTO tags (tag) VALUES (:tag)";
            $resultat = $conn->prepare($sql);
            $resultat->execute([':tag' => $tag]);

            $tagId = $conn->lastInsertId();
          }

          $sql = "INSERT INTO course_tags (idcourse, idtag) VALUES (:idcourse, :idtag)";
          $resultat = $conn->prepare($sql);
          $resultat->execute([':idcourse' => $courseId, ':idtag' => $tagId]);
        }
      }
      $result = true;
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
  $sql = "SELECT COUNT(*) as count FROM courses WHERE title = :title";
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

function getCoursesDB()
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT * FROM `courses`";
  try {
    $courses = $conn->prepare($sql);
    $courses->execute();
    if ($courses->rowCount() > 0) {
      $result = $courses->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function getTagsDB()
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT tag FROM tags";
  try {
    $tags = $conn->prepare($sql);
    $tags->execute();
    if ($tags->rowCount() > 0) {
      $result = $tags->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function getCourseByHashTagsDB($hashtags)
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT c.idcourse, c.title, c.description, c.publishDate, c.founder, c.caratula, c.nlikes, c.nDislikes, c.score,
                   (SELECT GROUP_CONCAT(t.tag)
                    FROM tags t
                    JOIN course_tags ct ON t.idtag = ct.idtag
                    WHERE ct.idcourse = c.idcourse) AS tags
            FROM courses c
            JOIN course_tags ct ON c.idcourse = ct.idcourse
            JOIN tags t ON ct.idtag = t.idtag
            WHERE t.tag IN ('" . implode("','", $hashtags) . "')
            GROUP BY c.idcourse, c.title, c.description, c.publishDate, c.founder, c.caratula, c.nlikes, c.nDislikes, c.score";
  try {
    $courses = $conn->prepare($sql);
    $courses->execute();
    if ($courses->rowCount() > 0) {
      $result = $courses->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }

}

function getCourseByIdBD($title)
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT * FROM `courses` WHERE title = :title";
  try {
    $usuaris = $conn->prepare($sql);
    $usuaris->execute([':title' => $title]);
    if ($usuaris->rowCount() == 1) {
      $result = $usuaris->fetch(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function isFounderDB($username, $title)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "SELECT count(*) FROM `courses` WHERE founder = :username AND title = :title";
  try {
    $stmp = $conn->prepare($sql);
    $stmp->execute([':username' => $username, ':title' => $title]);

    if ($stmp->fetchColumn() == 1) {
      $result = true;
    }
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  } finally {
    return $result;
  }
}

function insertVideoDB($video)
{
  $result = false;
  $conn = getDBConnection();
  $sql = "INSERT INTO `videos` (`video`, `videoName`, `idcourse`) VALUES ( :video, :videoName, :idcourse);";
  try {
    $stmp = $conn->prepare($sql);
    $rslt = $stmp->execute([
      ':video' => $video['video'],
      ':videoName' => $video['videoName'],
      ':idcourse' => $video['courseID']
    ]);
    if ($rslt)
      $result = true;
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function getVideosByCourseDB($courseID)
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT * FROM `videos` WHERE idcourse = :idcourse";
  try {
    $videos = $conn->prepare($sql);
    $videos->execute([':idcourse' => $courseID]);
    if ($videos->rowCount() > 0) {
      $result = $videos->fetchAll(PDO::FETCH_ASSOC);
    }
  } catch (PDOException $e) {
    echo "";
  } finally {
    return $result;
  }
}

function insertLikeDB($courseId)
{
  $conn = getDBConnection();
  $sql = "UPDATE `courses` SET nlikes = nlikes + 1, score = ROUND((nlikes / (nlikes + nDislikes)) * 5,1) WHERE idcourse = :idcourse";
  try {
    $stmp = $conn->prepare($sql);
    $res = $stmp->execute([':idcourse' => $courseId]);

  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function insertDislikeDB($courseId)
{
  $conn = getDBConnection();
  $sql = "UPDATE `courses` SET nDislikes = nDislikes + 1, score = ROUND((nlikes / (nlikes + nDislikes)) * 5,1) WHERE idcourse = :idcourse";
  try {
    $stmp = $conn->prepare($sql);
    $stmp->execute([':idcourse' => $courseId]);
  } catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
  }
}

function getCourseHashTagsDB($courseId)
{
  $result = [];
  $conn = getDBConnection();
  $sql = "SELECT idtag FROM `course_tags` WHERE idcourse = :idcourse";
  try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([':idcourse' => $courseId]);
    if ($stmt->rowCount() > 0) {
      $hashtags = $stmt->fetchAll(PDO::FETCH_ASSOC);
      foreach ($hashtags as $tag) {
        $result[] = getTagNameById($tag['idtag']);
      }
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  } finally {
    return $result;
  }
}

function getTagNameById($tagId)
{
  $result = '';
  $conn = getDBConnection();
  $sql = "SELECT tag FROM `tags` WHERE idtag = :idtag";
  try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([':idtag' => $tagId]);
    if ($stmt->rowCount() > 0) {
      $tag = $stmt->fetch(PDO::FETCH_ASSOC);
      $result = $tag['tag'];
    }
  } catch (PDOException $e) {
    echo $e->getMessage();
  } finally {
    return $result;
  }
}

function deleteCourseDB($courseId)
{
  $conn = getDBConnection();
  if(deleteCourseTagsDB($courseId) == true)
  {
    $sql = "DELETE FROM `courses` WHERE idcourse = :idcourse";
    try {
      $stmt = $conn->prepare($sql);
      $stmt->execute([':idcourse' => $courseId]);
    } catch (PDOException $e) {
      echo "";
    }
  }
}

function deleteCourseTagsDB($courseId)
{
  $conn = getDBConnection();
  $sql = "DELETE FROM `course_tags` WHERE idcourse = :idcourse";
  try {
    $stmt = $conn->prepare($sql);
    $stmt->execute([':idcourse' => $courseId]);
    if ($stmt->rowCount() > 0) {
      return true;
    }
  } catch (PDOException $e) {
    echo "";
  }
  return false;
}