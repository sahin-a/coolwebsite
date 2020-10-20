CREATE DATABASE SMJ_DB;
USE SMJ_DB;

CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(32) NOT NULL,
    password VARCHAR(255) NOT NULL,
    is_banned TINYINT(1) NOT NULL DEFAULT 0,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    register_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(username),
    PRIMARY KEY(id)
);

CREATE TABLE youtubeVideos (
    id INT NOT NULL AUTO_INCREMENT,
    videoId VARCHAR(11) NOT NULL,
    uid INT NOT NULL,
    message VARCHAR(64),
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    submit_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    FOREIGN KEY (uid) REFERENCES users(id)
);

CREATE TABLE commentSections (
    id INT NOT NULL,
    username VARCHAR(32) NOT NULL,
    comment VARCHAR(255) NOT NULL,
    is_deleted TINYINT(1) NOT NULL DEFAULT 0,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id) REFERENCES youtubeVideos(id)
);

CREATE TABLE invites (
    invite_code VARCHAR(255),
    uid INT,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    is_used TINYINT(1) NOT NULL DEFAULT 0,
    UNIQUE(invite_code),
    FOREIGN KEY (uid) REFERENCES users(id)
);

CREATE TABLE tokens (
    token VARCHAR(255),
    uid INT,
    creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(token),
    FOREIGN KEY (uid) REFERENCES users(id)
);

CREATE USER 'cooluser'@'localhost' IDENTIFIED BY '';
GRANT ALL PRIVILEGES ON SMJ_DB.* TO 'cooluser'@'localhost';