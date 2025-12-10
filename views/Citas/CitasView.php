<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();

$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Citas - Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #fffaf7;">

  <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgba(255, 182, 193, 0.9);">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold" href="?url=home/index" style="color: #4b2e83;">
        🐾 Estética Canina y Spa Guapos
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
            <a class="nav-link fw-semibold" href="index.php?url=productos/index" style="color: #4b2e83;">Productos</a>
          </li>
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="Carrito.php" style="color: #4b2e83;">Carrito</a>
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
      <h2 class="text-center fw-bold mb-4" style="color: #4b2e83;">Agenda una nueva cita</h2>
      <p class="text-center mb-4">
        Selecciona el servicio que deseas. Luego elige la fecha y uno de los 4 horarios disponibles.
      </p>

      <div class="row g-4">

        <!-- Baño Canino -->
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://escuelaversailles.com/wp-content/uploads/shutterstock_1569883195.jpg" class="card-img-top" alt="Baño Canino">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Baño Canino</h5>
              <p class="card-text">
                Baño completo con productos dermatológicamente aprobados, incluye secado y cepillado.
              </p>
              <p class="fw-bold" style="color: #4b2e83;">₡10,000</p>

              <button type="button"
                      class="btn mt-auto fw-semibold"
                      style="background-color: #4b2e83; color: #fff;"
                      data-bs-toggle="modal"
                      data-bs-target="#modalCita"
                      data-servicio="Baño Canino">
                Agendar cita
              </button>
            </div>
          </div>
        </div>

        <!-- Corte de Pelo -->
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://bloggroomer.es/wp-content/uploads/2023/12/haircut-of-a-maltipoo-dog-from-a-grooming-salon-2023-11-27-04-52-18-utc-1024x683.webp" class="card-img-top" alt="Corte de Pelo">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Corte de Pelo</h5>
              <p class="card-text">
                Corte profesional según la raza y estilo del perro. Incluye retoque en orejas y patas.
              </p>
              <p class="fw-bold" style="color: #4b2e83;">₡12,000</p>

              <button type="button"
                      class="btn mt-auto fw-semibold"
                      style="background-color: #4b2e83; color: #fff;"
                      data-bs-toggle="modal"
                      data-bs-target="#modalCita"
                      data-servicio="Corte de Pelo">
                Agendar cita
              </button>
            </div>
          </div>
        </div>

        <!-- Grooming Completo -->
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://www.woofies.com/images/articles/rsz_1brittany_grooming_photo_3.2206141322138.jpg" class="card-img-top" alt="Grooming Completo">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title">Grooming Completo</h5>
              <p class="card-text">
                Incluye baño, corte de pelo, limpieza de oídos y corte de uñas. Servicio estrella del spa.
              </p>
              <p class="fw-bold" style="color: #4b2e83;">₡18,000</p>

              <button type="button"
                      class="btn mt-auto fw-semibold"
                      style="background-color: #4b2e83; color: #fff;"
                      data-bs-toggle="modal"
                      data-bs-target="#modalCita"
                      data-servicio="Grooming Completo">
                Agendar cita
              </button>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <!-- Modal para agendar cita -->
  <div class="modal fade" id="modalCita" tabindex="-1" aria-labelledby="modalCitaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 1rem;">
        <div class="modal-header" style="background-color: #ffb6c1; border-bottom: none;">
          <h5 class="modal-title fw-bold" id="modalCitaLabel" style="color: #4b2e83;">
            Agendar cita
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body" style="background-color: #fffaf7;">
          <form action="?url=citas/index" method="POST" id="formCita">
            <div class="mb-3">
              <label class="form-label fw-semibold">Servicio</label>
              <input type="text"
                     class="form-control"
                     name="servicio"
                     id="campoServicio"
                     readonly>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Nombre de la mascota</label>
              <input type="text" class="form-control" name="nombre_mascota" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Teléfono de contacto</label>
              <input type="tel" class="form-control" name="telefono"
                     placeholder="Ej: 8888-8888" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Fecha</label>
              <input type="date" class="form-control" name="fecha_cita" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Horario</label>
              <select class="form-select" name="hora_cita" required>
                <option value="" selected disabled>Elige una hora</option>
                <option value="08:00:00">8:00 a.m.</option>
                <option value="10:00:00">10:00 a.m.</option>
                <option value="13:00:00">1:00 p.m.</option>
                <option value="15:00:00">3:00 p.m.</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Notas (opcional)</label>
              <textarea class="form-control" name="notas" rows="3"
                        placeholder="Ej: perro nervioso, trae su propio shampoo, etc."></textarea>
            </div>

            <button type="submit"
                    class="btn w-100 fw-semibold"
                    style="background-color: #4b2e83; color: #fff;">
              Confirmar cita
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>

  <?php include __DIR__ . '/../layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>

    const modalCita = document.getElementById('modalCita');
    modalCita.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const servicio = button.getAttribute('data-servicio');

      const campoServicio = modalCita.querySelector('#campoServicio');
      campoServicio.value = servicio;

      const tituloModal = modalCita.querySelector('#modalCitaLabel');
      tituloModal.textContent = 'Agendar cita - ' + servicio;
    });

    document.addEventListener('DOMContentLoaded', function () {
      <?php if (!empty($mensaje_exito)): ?>
        Swal.fire({
          icon: 'success',
          title: 'Cita creada',
          text: <?php echo json_encode($mensaje_exito); ?>
        });
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        Swal.fire({
          icon: 'error',
          title: 'Ups...',
          html: <?php echo json_encode($error); ?>
        });
      <?php endif; ?>
    });
  </script>

</body>
</html>
