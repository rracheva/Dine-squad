DROP DATABASE IF EXISTS DINE;

CREATE DATABASE DINE;

USE DINE;


CREATE TABLE EmailInfo(
	emailid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(256) NOT NULL
)


CREATE TABLE Preferences(
	emailid INT UNSIGNED NOT NULL,
	cid INT UNSIGNED NOT NULL,
	FOREIGN KEY (emailid) REFERENCES EmailInfo (emailid),
	FOREIGN KEY (cid) REFERENCES Cuisine(cid)
	}



-- discuss with professor on approach
-- more rows or more columns
CREATE TABLE DiningRatings (
	drid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	dininghall VARCHAR(256) NOT NULL,
	rating INT UNSIGNED NOT NULL
);

-- ask rali for more info 
CREATE TABLE Cuisine(
	cid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	type VARCHAR(256) NOT NULL,

);

-- might switch to excel file
CREATE TABLE Scores(
	sid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	dname VARCHAR(50),
	cid INT UNSIGNED NOT NULL,
	score INT,
	day DATE,
	meal VARCHAR(256),
	FOREIGN KEY (cid) REFERENCES Cuisine(cid)
);
-- check scheme
Describe EmailPreferences;
Describe DiningRatings;
Describe Preferneces;