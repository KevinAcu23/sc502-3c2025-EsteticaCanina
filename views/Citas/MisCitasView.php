<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Mis Citas - Estética Canina y Spa Guapos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #fffaf7;">
    <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgba(255, 182, 193, 0.9);">
        <div class="container-fluid px-4">
            <a class="navbar-brand fw-bold" href="?url=home/index" style="color: #4b2e83;">
                Estética Canina y Spa Guapos
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav align-items-center">

                    <!-- Mis Citas / Agenda segun rol -->
                    <li class="nav-item">
                        <a class="nav-link fw-semibold"
                           href="index.php?url=citas/misCitas"
                           style="color: #4b2e83;">
                            <?php echo $esAdmin ? 'Agenda' : 'Mis Citas'; ?>
                        </a>
                    </li>

                    <!-- Productos -->
                    <li class="nav-item">
                        <a class="nav-link fw-semibold"
                           href="index.php?url=productos/index"
                           style="color: #4b2e83;">
                            Productos
                        </a>
                    </li>

                    <!-- Pedidos (admin) / Carrito (cliente) -->
                    <?php if ($esAdmin): ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold"
                               href="index.php?url=pedidos/admin"
                               style="color: #4b2e83;">
                                Pedidos
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link fw-semibold"
                               href="index.php?url=carrito/index"
                               style="color: #4b2e83;">
                                Carrito
                            </a>
                        </li>
                    <?php endif; ?>

                    <!-- Hola, usuario -->
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li class="nav-item ms-3">
                            <span class="navbar-text fw-semibold" style="color: #4b2e83;">
                                Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </span>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item ms-3">
                        <a href="?url=auth/logout" class="btn btn-sm btn-outline-light fw-semibold">
                            Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-5 mt-5 flex-grow-1">
        <div class="container">
            <?php if (!$esAdmin): ?>
                <h2 class="text-center fw-bold mb-3" style="color: #4b2e83;">Mis Citas</h2>
            <?php else: ?>
                <h2 class="text-center fw-bold mb-3" style="color: #4b2e83;">Citas Agendadas (Administración)</h2>
            <?php endif; ?>

            <div class="d-flex justify-content-start mb-4">
                <?php if (!$esAdmin): ?>
                    <a href="?url=citas/index" class="btn fw-semibold" style="background-color:#4b2e83; color:#fff;">
                        Agendar una nueva cita
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($esAdmin): ?>

                <?php if (!empty($citasAll) && is_array($citasAll)): ?>
                    <div class="card border-0 shadow-sm rounded-4 mb-4">
                        <div class="card-header border-0 rounded-top-4 py-3 px-4"
                             style="background: linear-gradient(90deg, #ffb6c1, #f7c6ff);">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0 fw-bold" style="color:#4b2e83;">
                                        Agenda de citas
                                    </h5>
                                    <small class="text-muted">
                                        Vista administrativa de todas las citas agendadas.
                                    </small>
                                </div>
                                <span class="badge rounded-pill px-3 py-2 fw-semibold"
                                      style="background-color:#4b2e83; color:#fff;">
                                    Total: <?php echo count($citasAll); ?>
                                </span>
                            </div>
                        </div>

                        <div class="table-responsive px-3 pb-3">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr style="background-color:#fff5f8;">
                                        <th class="small text-uppercase text-muted">ID</th>
                                        <th class="small text-uppercase text-muted">Usuario</th>
                                        <th class="small text-uppercase text-muted">Mascota</th>
                                        <th class="small text-uppercase text-muted">Servicio</th>
                                        <th class="small text-uppercase text-muted">Fecha</th>
                                        <th class="small text-uppercase text-muted">Hora</th>
                                        <th class="small text-uppercase text-muted">Teléfono</th>
                                        <th class="small text-uppercase text-muted" style="width:260px;">Notas</th>
                                        <th class="small text-uppercase text-muted text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($citasAll as $cita): ?>
                                        <?php
                                            $fechaFmt = isset($cita['fecha_cita']) ? date('d/m/Y', strtotime($cita['fecha_cita'])) : '-';
                                            $horaFmt  = isset($cita['hora_cita']) ? date('H:i', strtotime($cita['hora_cita'])) : '-';
                                            $usuario  = $cita['nombre_usuario'] ?? '—';
                                            $telefono = $cita['telefono'] ?? 'No registrado';

                                            $notasRaw = !empty($cita['notas']) ? $cita['notas'] : '-';
                                            if ($notasRaw !== '-' && strlen($notasRaw) > 140) {
                                                $notasTrim = substr($notasRaw, 0, 140) . '...';
                                            } else {
                                                $notasTrim = $notasRaw;
                                            }
                                            $notas = nl2br(htmlspecialchars($notasTrim));
                                        ?>
                                        <tr id="cita-row-<?php echo (int)$cita['id']; ?>">
                                            <td class="fw-semibold" style="color:#4b2e83;">
                                                #<?php echo (int)$cita['id']; ?>
                                            </td>
                                            <td>
                                                <div class="fw-semibold"><?php echo htmlspecialchars($usuario); ?></div>
                                            </td>
                                            <td class="fw-semibold">
                                                <?php echo htmlspecialchars($cita['nombre_mascota'] ?? '-'); ?>
                                            </td>
                                            <td>
                                                <span class="badge rounded-pill px-3 py-2"
                                                      style="background-color:#ffe6ef; color:#4b2e83;">
                                                    <?php echo htmlspecialchars($cita['servicio'] ?? '-'); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-semibold"><?php echo $fechaFmt; ?></span>
                                            </td>
                                            <td class="fw-semibold">
                                                <?php echo $horaFmt; ?>
                                            </td>
                                            <td>
                                                <span class="d-block fw-semibold">
                                                    <?php echo htmlspecialchars($telefono); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="small p-2 rounded-3 border"
                                                     style="background-color:#fffafc; border-color:#ffe1f0;">
                                                    <?php echo $notas; ?>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <button
                                                    type="button"
                                                    class="btn btn-sm fw-semibold btn-cancelar-cita rounded-pill px-3"
                                                    style="border-color:#ff6b81; color:#ff6b81;"
                                                    data-cita-id="<?php echo (int)$cita['id']; ?>">
                                                    Cancelar
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php else: ?>
                    <p class="text-center mb-4">No hay citas registradas.</p>
                <?php endif; ?>

            <?php else: ?>
                <?php if (!empty($citasUsuario) && is_array($citasUsuario)): ?>
                    <div class="row g-4 mb-4 justify-content-center">
                        <?php foreach ($citasUsuario as $cita): ?>
                            <?php
                                $fechaFmt = isset($cita['fecha_cita']) ? date('d/m/Y', strtotime($cita['fecha_cita'])) : '-';
                                $horaFmt  = isset($cita['hora_cita']) ? date('H:i', strtotime($cita['hora_cita'])) : '-';
                            ?>
                            <div class="col-12 col-md-8 col-lg-6 cita-card">
                                <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="background-color: #fffdfd;">
                                    <div style=" position:absolute; left:0; top:0; bottom:0; width:6px; background: linear-gradient(180deg, #ffb6c1, #f7c6ff); "></div>
                                    <div class="card-header border-0 rounded-top-4 d-flex justify-content-between align-items-center ps-4" style="background-color: #ffe6ef;">
                                        <div>
                                            <div class="text-muted small text-uppercase mb-1">Servicio</div>
                                            <div class="fw-bold" style="color:#4b2e83;"><?php echo htmlspecialchars($cita['servicio'] ?? '-'); ?></div>
                                        </div>
                                    </div>
                                    <div class="card-body ps-4">
                                        <div class="mb-3">
                                            <span class="text-muted small text-uppercase d-block mb-1">Mascota</span>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($cita['nombre_mascota'] ?? '-'); ?></span>
                                        </div>
                                        <div class="row g-3 mb-2">
                                            <div class="col-6">
                                                <span class="text-muted small text-uppercase d-block mb-1">Fecha</span>
                                                <span class="fw-semibold"><?php echo $fechaFmt; ?></span>
                                            </div>
                                            <div class="col-6">
                                                <span class="text-muted small text-uppercase d-block mb-1">Hora</span>
                                                <span class="fw-semibold"><?php echo $horaFmt; ?></span>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <span class="text-muted small text-uppercase d-block mb-1">Teléfono</span>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($cita['telefono'] ?? 'No registrado'); ?></span>
                                        </div>
                                        <?php if (!empty($cita['notas'])): ?>
                                            <div class="mt-2 mb-2">
                                                <span class="text-muted small text-uppercase d-block mb-1">Notas</span>
                                                <div class="p-2 rounded-3" style="background-color:#fff5f7;">
                                                    <span class="small"><?php echo nl2br(htmlspecialchars($cita['notas'])); ?></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <div class="d-flex justify-content-end mt-3">
                                            <button type="button" class="btn btn-sm btn-outline-danger fw-semibold btn-cancelar-cita" data-cita-id="<?php echo (int)$cita['id']; ?>">Cancelar cita</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <p class="text-center mb-4">Aún no tienes citas agendadas.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </main>

    <?php include __DIR__ . '/../layout/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JS específico para Mis Citas / Agenda -->
    <script src="public/js/misCitas.js"></script>
</body>
</html>
