
CREATE DATABASE company
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

  
USE company;

CREATE TABLE department (
	id int(11) NOT NULL,
	name varchar(100) NOT NULL UNIQUE,
	PRIMARY KEY (id)
);

CREATE TABLE staff_member(
	id int(11) NOT NULL AUTO_INCREMENT,
	departament_id int(11) NOT NULL,
	member_name varchar(100) NOT NULL,
	date_hire date NULL,
	PRIMARY KEY (id),
	FOREIGN KEY (departament_id) REFERENCES department(id)
);

CREATE TABLE IF NOT EXISTS user (
  id int(11) NOT NULL AUTO_INCREMENT,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  authKey varchar(255) NOT NULL,
  accessToken varchar(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;
