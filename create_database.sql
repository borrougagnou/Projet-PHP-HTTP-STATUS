CREATE DATABASE IF NOT EXISTS garnier_rougagnou;
use garnier_rougagnou;

CREATE TABLE IF NOT EXISTS admins
(
	id INT NOT NULL AUTO_INCREMENT,
	users VARCHAR(255) NOT NULL,
	mail VARCHAR(1000) NOT NULL,
	password VARCHAR(255) NOT NULL,
	apikey VARCHAR(255) NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS websites
(
	id INT NOT NULL AUTO_INCREMENT,
	url TEXT NOT NULL,
	PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS logs
(
	id INT NOT NULL AUTO_INCREMENT,
	url TEXT NOT NULL,
	status INT(3),
	time DATETIME,
	PRIMARY KEY (id)
);


-- AJOUT ADMINS TABLE
INSERT INTO admins (users, mail, password, apikey) VALUES ("bernard", "deschaussettes@yopmail.com", "password", "abcdefghjaimelesapis");
INSERT INTO admins (users, mail, password, apikey) VALUES ("alex", "alex@yopmail.com", "pass", "alexapi");
INSERT INTO admins (users, mail, password, apikey) VALUES ("boris", "boris@yopmail.com", "pass", "borisapi");


-- AJOUT WEBSITES TABLE
INSERT INTO websites (url) VALUES ("https://google.com");
INSERT INTO websites (url) VALUES ("https://yahoo.com");
INSERT INTO websites (url) VALUES ("https://wikipedia.com");
INSERT INTO websites (url) VALUES ("http://185.163.125.75");


-- AJOUT LOGS TABLE
INSERT INTO logs (url, status, time) VALUES ("https://google.com", "200", '2004-01-01 23:59:59');
INSERT INTO logs (url, status, time) VALUES ("https://google.com", "200", '2005-03-11 11:30:26');
INSERT INTO logs (url, status, time) VALUES ("https://google.com", "200", '2006-12-06 05:23:34');
INSERT INTO logs (url, status, time) VALUES ("https://yahoo.com" , "404", '2012-01-01 11:11:11');
INSERT INTO logs (url, status, time) VALUES ("https://google.com", "200", now());

TRUNCATE TABLE websites;
TRUNCATE TABLE logs;
