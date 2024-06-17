CREATE DATABASE api_back_php;

USE api_back_php;

CREATE table registro_de_usuarios(
    id int auto_increment primary key,
    nombre varchar(50) NOT NULL,
    apellido varchar(50) NOT NULL, 
    correo varchar(100) NOT NULL,
    password varchar(100) NOT NULL,
    roll ENUM('Rol básico', 'Rol Medio', 'Rol medio alto', 'Rol alto medio', 'Rol alto') DEFAULT 'Rol básico',
    token varchar(100) NOT NULL,
    titulo VARCHAR(255) NOT NULL AFTER id,
    descripcion TEXT AFTER titulo,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER descripcion;
);

