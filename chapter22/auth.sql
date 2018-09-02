DROP DATABASE IF EXISTS auth;
CREATE DATABASE auth;

use auth;

CREATE TABLE authorized_users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(30),
    password VARCHAR(256)
);

INSERT INTO authorized_users(name, password) VALUES 
    ('admin', SHA1('admin123')),
    ('test', SHA1('test123'))
;

GRANT ALL PRIVILEGES
ON auth.*
TO webauth@localhost
IDENTIFIED BY 'webauth';