CREATE DATABASE IF NOT EXISTS board;
GRANT SELECT, INSERT, UPDATE, DELETE ON board.* TO board_root@localhost IDENTIFIED BY 'board_root';
FLUSH PRIVILEGES;


                    
USE board;
                    
CREATE TABLE IF NOT EXISTS thread (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
title                   VARCHAR(30) NOT NULL,
created                 TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
rating                  SMALLINT NOT NULL,
PRIMARY KEY (id)
)ENGINE=InnoDB;

                    
CREATE TABLE IF NOT EXISTS comment (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
thread_id               INT UNSIGNED NOT NULL,
username                VARCHAR(15) NOT NULL,
body                    TEXT NOT NULL,
created                 TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
INDEX (thread_id, created)
)ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS userinfo (
id                      INT UNSIGNED NOT NULL AUTO_INCREMENT,
username                VARCHAR(15) NOT NULL,
password                VARCHAR(16) NOT NULL,
name                    VARCHAR(15) NOT NULL,
email                   VARCHAR(30) NOT NULL,
PRIMARY KEY (id)
)ENGINE=InnoDB;