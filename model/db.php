<?php

function getDBConnection()
{
    $connString = 'mysql:host=localhost;port=3306;dbname=isitec;charset=utf8';
    $user = 'root';
    $pass = '';
    $db = null;
    try {
        $db = new PDO($connString, $user, $pass, [PDO::ATTR_PERSISTENT => True]);
    } catch (PDOException $e) {
        echo "<p style=\"color:red;\">Error " . $e->getMessage() . "</p>";
    } finally {
        return $db;
    }
}

function verificarUsuariBD($mail, $pass){
    $result = false;
    $conn   = getDBConnection();
    $sql    = "SELECT `mail`,`passHash` FROM `users` WHERE `mail`=:mail";
    try{
        $usuaris = $conn->prepare($sql);
        $usuaris->execute([':mail'=>$mail]);
        if($usuaris->rowCount()==1){
            $dadesUsuari = $usuaris->fetch(PDO::FETCH_ASSOC);
            if(password_verify($pass,$dadesUsuari['password'])){
                $result = true;
                // $result = $dadesUsuari;
            }
        }
    }catch(PDOException $e){
        echo "<p style=\"color:red;\">Error " . $e->getMessage() . "</p>";
    }finally{
        return $result;
    }    
}

function insertUsers($user)
{
    $inserit = false;
    $conn = getConnection();
    $sql = "INSERT INTO users (mail, passHash, userFirstName, userLastName, creationDate, removeDate, lastSignIn) VALUES (:mail, :passHash, :userFirstName, :userLastName, now(), null, now())";
    $mail = $user['mail'];
    $pass = $user['passHash'];
    $userFirstName = $user['userFirstName'];
    $userLastName = $user['userLastName'];
    try {
        $resultat = $conn->prepare($sql);
        $resultat->execute([':mail' => $mail, ':passHash' => $pass, ':userFirstName' => $userFirstName, ':userLastName' => $userLastName]);
        
        if ($resultat) {
            $inserit = true;
        }
    } catch (PDOException $e) {
        echo "<p style=\"color:red;\">Error " . $e->getMessage() . "</p>";
    } finally {
        return $inserit;
    }
}
