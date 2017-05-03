

DROP DATABASE IF EXISTS DINE;

CREATE DATABASE DINE;

USE DINE;

GRANT ALL PRIVILEGES ON DINE.* to root@localhost IDENTIFIED BY 'root';
-- stores email
CREATE TABLE EmailInfo(
	emailid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(256) NOT NULL
);

-- stores the cuisines
CREATE TABLE Cuisine(
	cid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(256) NOT NULL

);

-- stores the preference and uses the emailid and cid to bind the two
CREATE TABLE Preferences(
	emailid INT UNSIGNED NOT NULL,
	cid INT UNSIGNED NOT NULL,
	PRIMARY KEY (emailid,cid),
	FOREIGN KEY (emailid) REFERENCES EmailInfo (emailid),
	FOREIGN KEY (cid) REFERENCES Cuisine(cid)
	);


-- stores the ratings
CREATE TABLE RATINGS (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	hall VARCHAR(256) NOT NULL,
	rating INT UNSIGNED NOT NULL,
	meal VARCHAR(256) NOT NULL,
	timeDate DATETIME NOT NULL
);


-- the scores
CREATE TABLE Scores(
	sid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	dname VARCHAR(50),
	cid INT UNSIGNED NOT NULL,
	score INT,
	day DATE,
	meal VARCHAR(256),
	FOREIGN KEY (cid) REFERENCES Cuisine(cid)
);



-- add cuisine types 
INSERT INTO Cuisine (type) VALUES('mexican');
INSERT INTO Cuisine (type) VALUES('italian');
INSERT INTO Cuisine (type) VALUES('thai');
INSERT INTO Cuisine (type) VALUES('korean');
INSERT INTO Cuisine (type) VALUES('greek');
-- add emails
INSERT INTO EmailInfo (email) VALUES('ralitsa.racheva@pomona.edu');
INSERT INTO EmailInfo (email) VALUES('ad11rrac@uwcad.it');
-- add prefs
INSERT INTO Preferences (emailid,cid) VALUES(1,1);
INSERT INTO Preferences (emailid,cid) VALUES(1,2);
INSERT INTO Preferences (emailid,cid) VALUES(2,1);
INSERT INTO Preferences (emailid,cid) VALUES(2,2);



