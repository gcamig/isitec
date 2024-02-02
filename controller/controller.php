<?php
require_once "../model/db.php";

function loginUser($userOrEmail, $pass){
    return loginUserDB($userOrEmail, $pass);
}

function insertUser($user){
    return insertUserDB($user);
}

