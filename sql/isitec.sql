USE ddb218593;
-- USE isitec;

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

CREATE TABLE courses (
    idcourse INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(40) UNIQUE,
    description TEXT,
    hashtags TEXT,
    publishDate DATETIME,
    founder VARCHAR(16) NOT NULL,
    nlikes INT NOT NULL    DEFAULT 0,
    nDislikes INT NOT NULL DEFAULT 0,
    score FLOAT NOT NULL DEFAULT 0
);