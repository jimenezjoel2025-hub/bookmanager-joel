
CREATE TABLE IF NOT EXISTS publicadores (
    id_pub INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(150) NOT NULL,
    ciudad VARCHAR(100),
    pais VARCHAR(100)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tiendas (
    id_tienda INT AUTO_INCREMENT PRIMARY KEY,
    nombre_tienda VARCHAR(150) NOT NULL,
    direccion VARCHAR(200) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    telefono VARCHAR(25),
    email VARCHAR(150),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS titulos (
    id_titulo INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(200) NOT NULL,
    tipo VARCHAR(100) NOT NULL,
    id_pub INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    stock INT NOT NULL DEFAULT 0,
    fecha_publicacion DATE,
    descripcion TEXT,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_titulos_publicadores
        FOREIGN KEY (id_pub)
        REFERENCES publicadores(id_pub)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO publicadores (nombre, ciudad, pais) VALUES
('Editorial Santillana', 'Santo Domingo', 'República Dominicana'),
('Editorial Planeta', 'Barcelona', 'España'),
('Penguin Random House', 'Nueva York', 'Estados Unidos');

INSERT INTO tiendas
(nombre_tienda, direccion, ciudad, telefono, email)
VALUES
('Librería Central', 'Avenida 27 de Febrero', 'Santo Domingo', '809-555-0101', 'central@bookmanager.com'),
('Librería del Norte', 'Avenida Manolo Tavárez Justo', 'Puerto Plata', '809-555-0102', 'norte@bookmanager.com');

INSERT INTO titulos
(titulo, tipo, id_pub, precio, stock, fecha_publicacion, descripcion)
VALUES
('Introducción a PHP', 'Programación', 1, 1250.00, 15, '2026-01-15', 'Libro introductorio sobre PHP y desarrollo web.'),
('Programación Orientada a Objetos', 'Informática', 2, 1750.00, 10, '2025-08-20', 'Fundamentos de programación orientada a objetos.'),
('Bases de Datos con MySQL', 'Base de datos', 3, 1500.00, 12, '2026-03-10', 'Diseño y administración de bases de datos MySQL.');