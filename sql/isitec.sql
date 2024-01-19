DROP DATABASE IF EXISTS isitec;

CREATE DATABASE isitec CHARACTER
SET
  utf8mb4 COLLATE utf8mb4_0900_as_cs;

create table
  users (
    iduser CHAR(8) PRIMARY KEY AUTO_INCREMENT,
    mail CHAR(40) UNIQUE,
    passHash VARCHAR(60),
    userFirstName VARCHAR(60),
    userLastName VARCHAR(120),
    creationDate DATETIME,
    removeDare DATETIME,
    lastSignIn DATETIME,
    active TINYINT (1)
  );