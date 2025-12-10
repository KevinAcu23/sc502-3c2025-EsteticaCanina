<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$currentPage = 'pedidos_admin';
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Pedidos - Administración</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100" style="background-color:#fffaf7;">

<?php include __DIR__ . '/../layout/navbar.php'; ?>

<main class="container py-5 mt-5 flex-grow-1">

    <h2 class="text-center fw-bold mb-4" style="color:#4b2e83;">
        Pedidos realizados
    </h2>

    <?php if (empty($pedidos)): ?>
        <p class="text-center text-muted">No existen pedidos registrados.</p>

    <?php else: ?>

    <div class="table-responsive shadow-sm rounded-4">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total (₡)</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>

                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?php echo (int)$pedido['id']; ?></td>
                        <td><?php echo htmlspecialchars($pedido['usuario_nombre']); ?></td>

                        <td>
                            <?php echo date('d/m/Y H:i', strtotime($pedido['fecha'])); ?>
                        </td>

                        <td>
                            ₡<?php echo number_format($pedido['total'], 0, ',', '.'); ?>
                        </td>

                        <td>
                            <a href="index.php?url=pedidos/factura&id=<?php echo (int)$pedido['id']; ?>"
                               class="btn btn-sm btn-outline-primary fw-semibold">
                                Ver factura
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>

            </tbody>
        </table>
    </div>

    <?php endif; ?>

</main>

<?php include __DIR__ . '/../layout/footer.php'; ?>

</body>
</html>
