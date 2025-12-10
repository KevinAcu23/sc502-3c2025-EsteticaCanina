<?php

class Pedido
{
    private $pdo;

    public function __construct()
    {
      
        $this->pdo = getPDOConnection();
    }

   
    public function crearPedido(int $usuarioId, array $items)
    {
        if (empty($items)) {
            return false;
        }

        try {
            $this->pdo->beginTransaction();

            // Calcular total
            $total = 0;
            foreach ($items as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }

            // Insertar pedido
            $sqlPedido = "INSERT INTO pedidos (usuario_id, total, fecha)
                          VALUES (:usuario_id, :total, NOW())";
            $stmtPedido = $this->pdo->prepare($sqlPedido);
            $stmtPedido->execute([
                ':usuario_id' => $usuarioId,
                ':total'      => $total,
            ]);

            $pedidoId = (int)$this->pdo->lastInsertId();

            // Insertar detalles
            $sqlDetalle = "INSERT INTO pedido_detalle
                           (pedido_id, producto_id, nombre_producto, precio_unitario, cantidad, subtotal)
                           VALUES (:pedido_id, :producto_id, :nombre_producto, :precio_unitario, :cantidad, :subtotal)";
            $stmtDetalle = $this->pdo->prepare($sqlDetalle);

            foreach ($items as $item) {
                $subtotal = $item['precio'] * $item['cantidad'];

                $stmtDetalle->execute([
                    ':pedido_id'       => $pedidoId,
                    ':producto_id'     => $item['id'],
                    ':nombre_producto' => $item['nombre'],
                    ':precio_unitario' => $item['precio'],
                    ':cantidad'        => $item['cantidad'],
                    ':subtotal'        => $subtotal,
                ]);
            }

            $this->pdo->commit();
            return $pedidoId;

        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    
    public function obtenerPedidoConDetalles(int $pedidoId, ?int $usuarioId = null)
{
    $sql = "SELECT 
                p.*,
                u.nombre AS nombre_usuario
            FROM pedidos p
            INNER JOIN usuarios u ON u.id = p.usuario_id
            WHERE p.id = :id";

    $params = [':id' => $pedidoId];

    if ($usuarioId !== null) {
        $sql .= " AND p.usuario_id = :usuario_id";
        $params[':usuario_id'] = $usuarioId;
    }

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($params);
    $pedido = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pedido) {
        return [null, []];
    }

    $sqlDetalle = "SELECT *
                   FROM pedido_detalle
                   WHERE pedido_id = :pedido_id";
    $stmtDet = $this->pdo->prepare($sqlDetalle);
    $stmtDet->execute([':pedido_id' => $pedidoId]);
    $detalles = $stmtDet->fetchAll(PDO::FETCH_ASSOC);

    return [$pedido, $detalles];
}


    public function obtenerTodos()
{
    $sql = "SELECT 
                p.id,
                p.usuario_id,
                u.nombre AS usuario_nombre,
                p.fecha,
                p.total
            FROM pedidos p
            INNER JOIN usuarios u ON u.id = p.usuario_id
            ORDER BY p.fecha DESC, p.id DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function obtenerPorUsuario(int $usuarioId)
    {
        $sql = "SELECT *
                FROM pedidos
                WHERE usuario_id = :usuario_id
                ORDER BY fecha DESC, id DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':usuario_id' => $usuarioId]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    




}
