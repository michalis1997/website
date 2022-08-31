DROP DATABASE IF EXISTS web_project;
CREATE DATABASE IF NOT EXISTS web_project;

DROP DATABASE IF EXISTS web_project;
CREATE DATABASE IF NOT EXISTS web_project;

USE web_project;

DROP TABLE IF EXISTS registration;
CREATE TABLE registration (
	id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    user_type VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY(id)
);

DROP TABLE IF EXISTS UploadUserHistory;
CREATE TABLE UploadUserHistory(
	user_id int NOT NULL,
    har_id INT NOT NULL AUTO_INCREMENT,
    upload_date DATE NOT NULL,
	num_records INT NOT NULL,
    userIPAddress VARCHAR(32) NOT NULL,
    ISP varchar(255) NOT NULL,
    latitude float NOT NULL,
    longitude float NOT NULL,
    PRIMARY KEY(user_id, har_id),
    FOREIGN KEY(user_id) REFERENCES registration(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS entries;
CREATE TABLE entries (
	id INT NOT NULL AUTO_INCREMENT,
    har_id INT NOT NULL,
    startedDateTime varchar(100) NOT NULL,
    serverIPAddress varchar(100) NOT NULL,
    timings_wait FLOAT NOT NULL,
    PRIMARY KEY(id, har_id),
    FOREIGN KEY(har_id) REFERENCES UploadUserHistory(har_id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS responseIP;
CREATE TABLE responseIP(
	id INT NOT NULL AUTO_INCREMENT,
    harIPAddress varchar(32) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL,
    PRIMARY KEY(id),
    FOREIGN KEY (harIPAddress) REFERENCES entries(serverIPAddess)
    ON UPDATE CASCADE ON DELETE CASCADE
);

DROP TABLE IF EXISTS req_res_head;
CREATE TABLE req_res_head(
	id INT NOT NULL AUTO_INCREMENT,
    entry_id int NOT NULL ,
    req_method VARCHAR(10),
    req_url VARCHAR(40),
    req_h_name VARCHAR(255),
    req_h_value VARCHAR(255),
    res_status VARCHAR(255),
    res_status_text VARCHAR(255),
    res_h_name VARCHAR(255),
    res_h_value VARCHAR(255),
    PRIMARY KEY(id),
	FOREIGN KEY (entry_id) REFERENCES entries(id)
    ON UPDATE CASCADE ON DELETE CASCADE
);

INSERT INTO registration values
(NULL,"Antreas","antreashadh@gmail.com","user","Antreashadh25@"),
(NULL,"Orestis" ,"orestispa@gmail.com","user","Orestispa25@"),
(NULL,"Mixalis","mixalisni@gmail.com","admin","Mixalisni25@");

SHOW TABLES;