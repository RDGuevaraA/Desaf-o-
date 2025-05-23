DROP DATABASE IF EXISTS academia;
CREATE DATABASE academia;
USE academia;

CREATE TABLE usuarios (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    rol ENUM('admin', 'tutor') NOT NULL,
    email VARCHAR(100),
    estado ENUM('activo', 'inactivo') DEFAULT 'activo'
);

CREATE TABLE tutores (
    codigo_tutor VARCHAR(10) PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dui VARCHAR(10) UNIQUE NOT NULL,
    correo VARCHAR(100),
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    fecha_contratacion DATE,
    estado ENUM('contratado', 'despedido', 'renuncia') NOT NULL,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario)
);

CREATE TABLE estudiantes (
    codigo_estudiante VARCHAR(15) PRIMARY KEY,
    nombres VARCHAR(100) NOT NULL,
    apellidos VARCHAR(100) NOT NULL,
    dui VARCHAR(10) UNIQUE NOT NULL,
    correo VARCHAR(100),
    telefono VARCHAR(20),
    fecha_nacimiento DATE,
    fotografia VARCHAR(255),
    estado ENUM('activo', 'inactivo') NOT NULL,
    en_grupo ENUM('si', 'no') NOT NULL
);

CREATE TABLE cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nombre_curso VARCHAR(100) NOT NULL,
    codigo_tutor VARCHAR(10),
    FOREIGN KEY (codigo_tutor) REFERENCES tutores(codigo_tutor)
);

CREATE TABLE curso_estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_curso INT,
    codigo_estudiante VARCHAR(15),
    FOREIGN KEY (id_curso) REFERENCES cursos(id_curso),
    FOREIGN KEY (codigo_estudiante) REFERENCES estudiantes(codigo_estudiante)
);

CREATE TABLE asistencias (
    id_asistencia INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    tipo ENUM('A','I','J') NOT NULL,
    codigo_estudiante VARCHAR(15),
    codigo_tutor VARCHAR(10),
    FOREIGN KEY (codigo_estudiante) REFERENCES estudiantes(codigo_estudiante),
    FOREIGN KEY (codigo_tutor) REFERENCES tutores(codigo_tutor)
);

CREATE TABLE codigos (
    id_codigo INT AUTO_INCREMENT PRIMARY KEY,
    nombre TEXT NOT NULL,
    tipo ENUM('P','L','G','MG') NOT NULL
);

CREATE TABLE asignacion_codigos (
    id_asignacion INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    id_codigo INT,
    codigo_estudiante VARCHAR(15),
    codigo_tutor VARCHAR(10),
    FOREIGN KEY (id_codigo) REFERENCES codigos(id_codigo),
    FOREIGN KEY (codigo_estudiante) REFERENCES estudiantes(codigo_estudiante),
    FOREIGN KEY (codigo_tutor) REFERENCES tutores(codigo_tutor)
);
