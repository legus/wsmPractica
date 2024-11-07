CREATE DATABASE Colegio;
--tabla danielJay
CREATE TABLE Salon (
    nombre VARCHAR(50) PRIMARY KEY,
    capacidad INT NOT NULL,
    ubicacion VARCHAR(100),
    tipo VARCHAR(50)
);
--CREATE USER 'DaniJay10'@'localhost' IDENTIFIED BY 'git123';
--GRANT ALL PRIVILEGES ON Colegio.* TO 'DaniJay10'@'localhost';
--FLUSH PRIVILEGES;
