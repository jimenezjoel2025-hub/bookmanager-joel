<?php

class Tienda
{
    private PDO $db;

    private ?int $id_tienda = null;
    private string $nombre_tienda = '';
    private string $direccion = '';
    private string $ciudad = '';
    private string $telefono = '';
    private string $email = '';

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM tiendas ORDER BY id_tienda DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM tiendas WHERE id_tienda = :id_tienda";
        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            ':id_tienda' => $id
        ]);

        return $stmt->fetch();
    }

    public function create(array $datos): bool
    {
        $sql = "INSERT INTO tiendas
                    (nombre_tienda, direccion, ciudad, telefono, email)
                VALUES
                    (:nombre_tienda, :direccion, :ciudad, :telefono, :email)";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':nombre_tienda' => trim($datos['nombre_tienda']),
            ':direccion' => trim($datos['direccion']),
            ':ciudad' => trim($datos['ciudad']),
            ':telefono' => trim($datos['telefono'] ?? ''),
            ':email' => trim($datos['email'] ?? '')
        ]);
    }

    public function update(int $id, array $datos): bool
    {
        $sql = "UPDATE tiendas
                SET nombre_tienda = :nombre_tienda,
                    direccion = :direccion,
                    ciudad = :ciudad,
                    telefono = :telefono,
                    email = :email
                WHERE id_tienda = :id_tienda";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_tienda' => $id,
            ':nombre_tienda' => trim($datos['nombre_tienda']),
            ':direccion' => trim($datos['direccion']),
            ':ciudad' => trim($datos['ciudad']),
            ':telefono' => trim($datos['telefono'] ?? ''),
            ':email' => trim($datos['email'] ?? '')
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM tiendas WHERE id_tienda = :id_tienda";
        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            ':id_tienda' => $id
        ]);
    }
}