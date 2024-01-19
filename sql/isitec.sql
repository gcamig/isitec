DROP DATABASE IF EXISTS isitec;

CREATE DATABASE isitec CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE isitec;

CREATE TABLE users (
    iduser INT AUTO_INCREMENT PRIMARY KEY,
    mail VARCHAR(40) UNIQUE,
    passHash VARCHAR(60),
    userFirstName VARCHAR(60),
    userLastName VARCHAR(120),
    creationDate DATETIME,
    removeDate DATETIME,
    lastSignIn DATETIME,
    active TINYINT(1)
);
