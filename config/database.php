<?php

class Database
{
    private string $host;
    private string $dbname;
    private string $username;
    private string $password;

    public function __construct()
    {
        $archivoLocal = __DIR__ . '/database.local.php';
        $archivoProduccion = __DIR__ . '/database.production.php';

        if (file_exists($archivoLocal)) {
            $configuracion = require $archivoLocal;
        } elseif (file_exists($archivoProduccion)) {
            $configuracion = require $archivoProduccion;
        } else {
            throw new RuntimeException(
                'No se encontró un archivo de configuración de base de datos.'
            );
        }

        $this->host = $configuracion['host'];
        $this->dbname = $configuracion['dbname'];
        $this->username = $configuracion['username'];
        $this->password = $configuracion['password'];
    }

    public function connect(): PDO
    {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=utf8mb4',
            $this->host,
            $this->dbname
        );

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        return new PDO(
            $dsn,
            $this->username,
            $this->password,
            $opciones
        );
    }
}