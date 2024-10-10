CREATE DATABASE auth;
	
CREATE TABLE auth.users (
id int not null primary key auto_increment,
username varchar(255),
password varchar(255),
active int
);


INSERT INTO auth.users (username,password,active) VALUES ('steve','boo',1);
INSERT INTO auth.users (username,password,active) VALUES ('bob','nightmare',1);
INSERT INTO auth.users (username,password,active) VALUES ('ernie','rattler',1);
