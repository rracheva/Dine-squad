DROP DATABASE IF EXISTS DINE;

CREATE DATABASE DINE;

USE DINE;


CREATE TABLE EmailPreferences(
	emailid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	email VARCHAR(256) NOT NULL,
	preferneces VARCHAR(256) --a string, possibly seperate prefs by commas/spaces
);

CREATE TABLE DiningRatings (
	drid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	dininghall VARCHAR(256) NOT NULL,
	rating INT UNSIGNED NOT NULL
)

-- ask rali for more info 
CREATE TABLE Preferences(
	pid INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,

)

-- check scheme
Describe EmailPreferences;
Describe DiningRatings;
Describe Preferneces;