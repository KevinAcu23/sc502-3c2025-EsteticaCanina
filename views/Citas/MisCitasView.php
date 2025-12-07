<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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

          <li class="nav-item">
            <a class="nav-link fw-semibold" href="?url=citas/misCitas" style="color: #4b2e83;">
              Mis Citas
            </a>
          </li>

        <li class="nav-item">
           <a class="nav-link fw-semibold"href="index.php?url=productos/index"style="color: #4b2e83;">Productos
           </a>
          </li>

          <li class="nav-item">
            <a class="nav-link fw-semibold" href="#" style="color: #4b2e83;">
              Carrito
            </a>
          </li>

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

      <h2 class="text-center fw-bold mb-3" style="color: #4b2e83;">Mis Citas</h2>

      <div class="d-flex justify-content-start mb-4">
        <a href="?url=citas/index"
           class="btn fw-semibold"
           style="background-color:#4b2e83; color:#fff;">
          Agendar una nueva cita
        </a>
      </div>

      <?php if (!empty($citasUsuario)): ?>
        <div class="row g-4 mb-4 justify-content-center">
          <?php foreach ($citasUsuario as $cita): ?>
            <?php
              $fechaFmt = date('d/m/Y', strtotime($cita['fecha_cita']));
              $horaFmt  = date('H:i', strtotime($cita['hora_cita']));
            ?>

            <div class="col-12 col-md-8 col-lg-6 cita-card">
              <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden"
                   style="background-color: #fffdfd;">

                <div style="
                      position:absolute;
                      left:0;
                      top:0;
                      bottom:0;
                      width:6px;
                      background: linear-gradient(180deg, #ffb6c1, #f7c6ff);
                    "></div>

                <div class="card-header border-0 rounded-top-4 d-flex justify-content-between align-items-center ps-4"
                     style="background-color: #ffe6ef;">
                  <div>
                    <div class="text-muted small text-uppercase mb-1">
                      Servicio
                    </div>
                    <div class="fw-bold" style="color:#4b2e83;">
                      <?php echo htmlspecialchars($cita['servicio']); ?>
                    </div>
                  </div>
                </div>

                <div class="card-body ps-4">
                  <div class="mb-3">
                    <span class="text-muted small text-uppercase d-block mb-1">Mascota</span>
                    <span class="fw-semibold">
                      <?php echo htmlspecialchars($cita['nombre_mascota']); ?>
                    </span>
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
                    <span class="fw-semibold">
                      <?php echo htmlspecialchars($cita['telefono'] ?? 'No registrado'); ?>
                    </span>
                  </div>

                  <?php if (!empty($cita['notas'])): ?>
                    <div class="mt-2 mb-2">
                      <span class="text-muted small text-uppercase d-block mb-1">Notas</span>
                      <div class="p-2 rounded-3" style="background-color:#fff5f7;">
                        <span class="small">
                          <?php echo nl2br(htmlspecialchars($cita['notas'])); ?>
                        </span>
                      </div>
                    </div>
                  <?php endif; ?>

                  <div class="d-flex justify-content-end mt-3">
                    <button type="button"
                            class="btn btn-sm btn-outline-danger fw-semibold btn-cancelar-cita"
                            data-cita-id="<?php echo (int)$cita['id']; ?>">
                      Cancelar cita
                    </button>
                  </div>

                </div>
              </div>
            </div>

          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <p class="text-center mb-4">
          Aún no tienes citas agendadas.
        </p>
      <?php endif; ?>

    </div>
  </main>

  <?php include __DIR__ . '/../layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const botones = document.querySelectorAll('.btn-cancelar-cita');

      botones.forEach(btn => {
        btn.addEventListener('click', function () {
          const citaId = this.dataset.citaId;
          const cardWrapper = this.closest('.cita-card');

          Swal.fire({
            title: '¿Cancelar esta cita?',
            text: 'Esta acción no se puede deshacer.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, volver',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d'
          }).then((result) => {
            if (!result.isConfirmed) return;

            const formData = new FormData();
            formData.append('cita_id', citaId);
            formData.append('ajax', '1');

            fetch('?url=citas/cancelar', {
              method: 'POST',
              body: formData
            })
            .then(res => res.json())
            .then(data => {
              if (data.success) {
                if (cardWrapper) {
                  cardWrapper.remove();
                }

                Swal.fire({
                  icon: 'success',
                  title: 'Cita cancelada',
                  text: data.message || 'La cita se canceló correctamente.'
                });
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: data.message || 'No se pudo cancelar la cita. Intenta de nuevo.'
                });
              }
            })
            .catch(() => {
              Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Ocurrió un problema al cancelar la cita.'
              });
            });
          });
        });
      });
    });
  </script>

</body>
</html>
