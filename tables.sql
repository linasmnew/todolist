CREATE DATABASE todo;

CREATE TABLE user(id int auto_increment NOT NULL, username varchar(32) NOT NULL, email varchar(320) NOT NULL, password varchar(255) NOT NULL, PRIMARY KEY(id))

CREATE TABLE tasks(id int auto_increment NOT NULL, title varchar(300) NOT NULL, date_added timestamp, date_due datetime NOT NULL, category varchar(100) NOT NULL, user_id int NOT NULL, PRIMARY KEY(id))

CREATE TABLE completed(id int auto_increment NOT NULL, task_title varchar(300) NOT NULL,  user_id int NOT NULL, date_completed timestamp, category varchar(100), PRIMARY KEY(id))

CREATE TABLE category(id int auto_increment NOT NULL, name varchar(100) NOT NULL, user_id int NOT NULL, PRIMARY KEY(id))
