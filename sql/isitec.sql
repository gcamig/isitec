USE ddb218593;

CREATE TABLE users (
    iduser INT AUTO_INCREMENT PRIMARY KEY,
    mail VARCHAR(40) UNIQUE,
    username VARCHAR(16) UNIQUE,
    passHash VARCHAR(60),
    userFirstName VARCHAR(60),
    userLastName VARCHAR(120),
    creationDate DATETIME,
    removeDate DATETIME,
    lastSignIn DATETIME,
    active TINYINT(1) DEFAULT 0,
    activationDate DATETIME,
    activationCode CHAR(64),
    resetPassExpiry DATETIME,
    resetPassCode CHAR(64)
);