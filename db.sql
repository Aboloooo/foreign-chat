drop DATABASE if exists chat;
CREATE DATABASE chat;
USE chat;

CREATE TABLE users (
    userID INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE message (
    messageID INT PRIMARY KEY AUTO_INCREMENT,
    txt VARCHAR(999) NOT NULL,
    sentByUserID int,
     FOREIGN KEY (sentByUserID) REFERENCES users(userID) ON DELETE CASCADE
);
