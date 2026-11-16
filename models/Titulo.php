<?php

class Titulo
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAll(): array
    {
        $sql = "
            SELECT
                t.id_titulo,
                t.titulo,
                t.tipo,
                t.id_pub,
                t.precio,
                t.stock,
                t.fecha_publicacion,
                t.descripcion,
                p.nombre AS nombre_publicador
            FROM titulos AS t
            LEFT JOIN publicadores AS p
                ON t.id_pub = p.id_pub
            ORDER BY t.id_titulo DESC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "
            SELECT
                id_titulo,
                titulo,
                tipo,
                id_pub,
                precio,
                stock,
                fecha_publicacion,
                descripcion
            FROM titulos
            WHERE id_titulo = :id_titulo
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'id_titulo' => $id
        ]);

        return $stmt->fetch();
    }

    public function getPublicadores(): array
    {
        $sql = "
            SELECT
                id_pub,
                nombre,
                ciudad,
                pais
            FROM publicadores
            ORDER BY nombre ASC
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(array $datos): bool
    {
        $sql = "
            INSERT INTO titulos (
                titulo,
                tipo,
                id_pub,
                precio,
                stock,
                fecha_publicacion,
                descripcion
            ) VALUES (
                :titulo,
                :tipo,
                :id_pub,
                :precio,
                :stock,
                :fecha_publicacion,
                :descripcion
            )
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'titulo' => $datos['titulo'],
            'tipo' => $datos['tipo'],
            'id_pub' => $datos['id_pub'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
            'fecha_publicacion' => $datos['fecha_publicacion'],
            'descripcion' => $datos['descripcion'],
        ]);
    }

    public function update(int $id, array $datos): bool
    {
        $sql = "
            UPDATE titulos
            SET
                titulo = :titulo,
                tipo = :tipo,
                id_pub = :id_pub,
                precio = :precio,
                stock = :stock,
                fecha_publicacion = :fecha_publicacion,
                descripcion = :descripcion
            WHERE id_titulo = :id_titulo
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'titulo' => $datos['titulo'],
            'tipo' => $datos['tipo'],
            'id_pub' => $datos['id_pub'],
            'precio' => $datos['precio'],
            'stock' => $datos['stock'],
            'fecha_publicacion' => $datos['fecha_publicacion'],
            'descripcion' => $datos['descripcion'],
            'id_titulo' => $id,
        ]);
    }

    public function delete(int $id): bool
    {
        $sql = "
            DELETE FROM titulos
            WHERE id_titulo = :id_titulo
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id_titulo' => $id
        ]);
    }
}