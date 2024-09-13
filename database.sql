CREATE DATABASE users_biosina;
USE users_biosina;

-- TINYINT, porque la edad es un numero pequeño y no es necesario INT
CREATE TABLE users (
    id INT AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL, 
    age TINYINT UNSIGNED NOT NULL,
    gender ENUM('masculino', 'femenino') NOT NULL, 
    day_of_birth DATE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    PRIMARY KEY (id)
);