<?php

class Cita
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function crear($data)
    {
        $sql = "INSERT INTO citas (
                    usuario_id,
                    nombre_mascota,
                    telefono,
                    servicio,
                    fecha_cita,
                    hora_cita,
                    notas
                )
                VALUES (
                    :usuario_id,
                    :nombre_mascota,
                    :telefono,
                    :servicio,
                    :fecha_cita,
                    :hora_cita,
                    :notas
                )";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':usuario_id'     => $data['usuario_id'],
            ':nombre_mascota' => $data['nombre_mascota'],
            ':telefono'       => $data['telefono'],
            ':servicio'       => $data['servicio'],
            ':fecha_cita'     => $data['fecha_cita'],
            ':hora_cita'      => $data['hora_cita'],
            ':notas'          => $data['notas'] ?? null,
        ]);
    }

    public function obtenerPorUsuario($usuarioId)
    {
        $sql = "SELECT
                    id,
                    usuario_id,
                    nombre_mascota,
                    telefono,
                    servicio,
                    fecha_cita,
                    hora_cita,
                    notas,
                    created_at
                FROM citas
                WHERE usuario_id = :usuario_id
                ORDER BY fecha_cita DESC, hora_cita DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function horarioOcupado($fecha, $hora)
    {
        $sql = "SELECT COUNT(*) FROM citas
                WHERE fecha_cita = :fecha_cita
                  AND hora_cita  = :hora_cita";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':fecha_cita' => $fecha,
            ':hora_cita'  => $hora,
        ]);

        return $stmt->fetchColumn() > 0;
    }

    public function eliminar($citaId, $usuarioId)
    {
        $sql = "DELETE FROM citas
                WHERE id = :id
                  AND usuario_id = :usuario_id";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':id'         => $citaId,
            ':usuario_id' => $usuarioId,
        ]);
    }
}