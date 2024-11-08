CREATE DATABASE Colegio;
--tabla danielJay
CREATE TABLE Salon (
    nombre VARCHAR(50) PRIMARY KEY,
    capacidad INT NOT NULL,
    ubicacion VARCHAR(100),
    tipo VARCHAR(50)
);


--taba Juan Arias--
create table docente (

    cedula int PRIMARY KEY,
    nombre varchar(100) not NULL,
    asignatura varchar(30) not NULL,
    horas int
);