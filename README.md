# BookManager

BookManager es un sistema de gestión de librería desarrollado como proyecto final de Programación IV. Permite administrar las tiendas que distribuyen los libros y los títulos disponibles en el inventario.

## Autor

**Joel Barrientos Jiménez**  
Estudiante de Informática  
Universidad Autónoma de Santo Domingo (UASD)

## Funcionalidades

El sistema cuenta con las siguientes funciones:

- Panel principal con resumen de tiendas, títulos y editoriales.
- Registro, consulta, edición y eliminación de tiendas.
- Registro, consulta, edición y eliminación de títulos.
- Selección de la editorial correspondiente a cada libro.
- Validación de campos obligatorios.
- Validación para impedir precios y existencias negativas.
- Confirmación antes de eliminar registros.
- Interfaz adaptable creada con Bootstrap 5.

## Tecnologías utilizadas

- PHP 8.4
- Programación Orientada a Objetos
- PDO
- Sentencias preparadas
- MariaDB / MySQL
- HTML5
- CSS3
- Bootstrap 5
- Bootstrap Icons
- Git y GitHub

## Estructura del proyecto

```text
bookmanager-joel/
├── assets/
│   └── css/
│       └── styles.css
├── config/
│   └── database.php
├── database/
│   └── dblibreria.sql
├── includes/
│   ├── header.php
│   └── footer.php
├── models/
│   ├── Tienda.php
│   └── Titulo.php
├── views/
│   ├── tiendas/
│   │   ├── index.php
│   │   ├── crear.php
│   │   ├── editar.php
│   │   └── eliminar.php
│   └── titulos/
│       ├── index.php
│       ├── crear.php
│       ├── editar.php
│       └── eliminar.php
├── index.php
└── README.md
```

## Base de datos

La base de datos se llama `dblibreria` y contiene las tablas:

- `tiendas`
- `titulos`
- `publicadores`

El archivo para crear la base de datos se encuentra en:

```text
database/dblibreria.sql
```

## Instalación local

### 1. Clonar el repositorio

```bash
git clone https://github.com/jimenezjoel2025-hub/bookmanager-joel.git
cd bookmanager-joel
```

### 2. Crear la base de datos

Importa el archivo `database/dblibreria.sql` en MariaDB o MySQL.

También se puede importar desde la terminal:

```bash
mariadb -u root -p < database/dblibreria.sql
```

### 3. Configurar la conexión

Crea el archivo:

```text
config/database.local.php
```

El archivo debe retornar las credenciales locales:

```php
<?php

return [
    'host' => 'localhost',
    'dbname' => 'dblibreria',
    'username' => 'root',
    'password' => 'TU_CONTRASEÑA',
];
```

Este archivo está incluido en `.gitignore` para evitar que la contraseña sea publicada en GitHub.

### 4. Iniciar el servidor local

```bash
php -S localhost:8000
```

Después visita:

```text
http://localhost:8000
```

## Arquitectura

El proyecto utiliza Programación Orientada a Objetos. La clase `Database` se encarga de crear la conexión con la base de datos mediante PDO.

Las clases `Tienda` y `Titulo` funcionan como modelos. Cada una contiene métodos separados para consultar, crear, actualizar y eliminar registros.

Las consultas que reciben datos del usuario utilizan sentencias preparadas. Esto ayuda a proteger la aplicación contra ataques de inyección SQL.

Las vistas se encargan de presentar los formularios y las tablas del sistema. El encabezado, el menú lateral y el pie de página se reutilizan mediante los archivos de la carpeta `includes`.

## Seguridad

- Las consultas utilizan PDO y sentencias preparadas.
- Los datos mostrados se protegen con `htmlspecialchars`.
- Los identificadores se validan antes de consultar o eliminar.
- Las eliminaciones requieren confirmación.
- Las contraseñas locales no se almacenan en GitHub.

## Repositorio

[BookManager en GitHub](https://github.com/jimenezjoel2025-hub/bookmanager-joel)