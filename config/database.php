<?php

class Database
{
    private string $host = '127.0.0.1';
    private string $dbname = 'dblibreria';
    private string $username = 'root';
    private string $password = '';
    private string $charset = 'utf8mb4';

    public function __construct()
    {
        $archivoLocal = __DIR__ . '/database.local.php';

        if (file_exists($archivoLocal)) {
            $config = require $archivoLocal;

            $this->host = $config['host'] ?? $this->host;
            $this->dbname = $config['dbname'] ?? $this->dbname;
            $this->username = $config['username'] ?? $this->username;
            $this->password = $config['password'] ?? $this->password;
        }
    }

    public function connect(): PDO
    {
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset={$this->charset}";

        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        return new PDO(
            $dsn,
            $this->username,
            $this->password,
            $opciones
        );
    }
}