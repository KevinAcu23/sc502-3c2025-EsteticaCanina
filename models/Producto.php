<?php

class Producto
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function obtenerTodos()
    {
        $sql = "SELECT * FROM productos ORDER BY created_at DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crear($data)
    {
        $sql = "INSERT INTO productos (nombre, descripcion, precio, imagen_url)
                VALUES (:nombre, :descripcion, :precio, :imagen_url)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio'      => $data['precio'],
            ':imagen_url'  => $data['imagen_url'],
        ]);
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM productos WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM productos WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Para futuro: actualizar()
    public function actualizar($id, $data)
    {
        $sql = "UPDATE productos
                SET nombre = :nombre,
                    descripcion = :descripcion,
                    precio = :precio,
                    imagen_url = :imagen_url
                WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id'          => $id,
            ':nombre'      => $data['nombre'],
            ':descripcion' => $data['descripcion'],
            ':precio'      => $data['precio'],
            ':imagen_url'  => $data['imagen_url'],
        ]);
    }
}
