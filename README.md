# BookManager

Sistema web para gestionar el inventario de una librería, desarrollado como proyecto final individual de **Programación IV**.

La aplicación permite administrar tiendas y títulos mediante operaciones CRUD: crear, consultar, actualizar y eliminar registros. También relaciona cada título con una editorial registrada en la base de datos.

## Datos del estudiante

- **Estudiante:** Joel Barrientos Jiménez
- **Matricula:** 100235966
- **Asignatura:** Programación IV
- **Universidad:** Universidad Autónoma de Santo Domingo (UASD)
- **Proyecto:** Sistema de Gestión de Librería
- **Fecha:** Noviembre de 2026

## Sitio publicado

- **URL pública:** https://bookmanagerjoel.rf.gd
- **Repositorio:** https://github.com/jimenezjoel2025-hub/bookmanager-joel

## Tecnologías utilizadas

- PHP 8
- Programación Orientada a Objetos
- PDO
- MySQL y MariaDB
- Bootstrap 5
- HTML5
- CSS3
- Git y GitHub
- InfinityFree

## Funcionalidades

### Panel principal

El panel muestra un resumen de los registros almacenados en la base de datos:

- Cantidad de tiendas registradas.
- Cantidad de títulos disponibles.
- Cantidad de editoriales registradas.
- Menú lateral para navegar entre los módulos.

### Gestión de tiendas

El módulo de tiendas permite:

- Consultar las tiendas registradas.
- Registrar una tienda nueva.
- Editar los datos de una tienda.
- Eliminar una tienda.
- Validar que el nombre y los campos obligatorios no estén vacíos.
- Mostrar mensajes de confirmación después de cada operación.

### Gestión de títulos

El módulo de títulos permite:

- Consultar los libros registrados.
- Registrar un título nuevo.
- Editar los datos de un título.
- Eliminar un título.
- Seleccionar una editorial desde la tabla `publicadores`.
- Validar que el precio y el stock no sean negativos.
- Mostrar el precio en pesos dominicanos.
- Mostrar mensajes de confirmación después de cada operación.

## Arquitectura del proyecto

El proyecto está organizado separando la conexión, los modelos, las vistas y los archivos comunes de la interfaz.

```text
bookmanager-joel/
├── assets/
│   └── css/
│       └── styles.css
├── config/
│   └── database.php
├── database/
│   ├── dblibreria.sql
│   └── dblibreria_infinityfree.sql
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
├── .gitignore
├── index.php
└── README.md