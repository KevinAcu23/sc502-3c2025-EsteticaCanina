<?php
// Asegurarnos de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body style="background-color: #fffaf7;">

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

          <!-- Mis Citas (lista de citas del usuario) -->
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="?url=citas/misCitas" style="color: #4b2e83;">
              Mis Citas
            </a>
          </li>

          <!-- Productos -->
          <li class="nav-item"><a class="nav-link fw-semibold"href="index.php?url=productos/index"style="color: #4b2e83;">
               Productos
            </a>
           </li>

          <!-- Carrito -->
          <li class="nav-item">
            <a class="nav-link fw-semibold" href="Carrito.php" style="color: #4b2e83;">
              Carrito
            </a>
          </li>

          <!-- Hola, Usuario -->
          <?php if (isset($_SESSION['user_name'])): ?>
            <li class="nav-item ms-3">
              <span class="navbar-text fw-semibold" style="color: #4b2e83;">
                Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
              </span>
            </li>
          <?php endif; ?>

          <!-- Logout -->
          <li class="nav-item ms-3">
            <a href="?url=auth/logout" class="btn btn-sm btn-outline-light fw-semibold">
              Cerrar sesión
            </a>
          </li>

        </ul>
      </div>
    </div>
  </nav>

  <section
    class="position-relative min-vh-100 d-flex align-items-center justify-content-center text-center"
    style="
      background:
        linear-gradient(rgba(255,255,255,0.5), rgba(255,255,255,0.5)),
        url('https://kingsvet.com.au/wp-content/uploads/2024/10/why-is-pet-grooming-important.jpg')
        center/cover no-repeat fixed;
    "
  >
    <div class="container px-4 position-relative">
      <div class="p-4 rounded-4 shadow-lg mx-auto"
           style="max-width: 600px; background-color: rgba(255, 250, 247, 0.8);">
        <h1 class="fw-bold" style="color: #4b2e83;">¡Porque tu peludo merece lo mejor!</h1>
        <p class="lead mt-2" style="color: #503a76;">Baños, cortes y cuidados con amor 🐕✨</p>

        <!-- Botón: va a la página para AGENDAR (citas/index) -->
        <a href="?url=citas/index"
           class="btn fw-bold rounded-pill px-4 py-2 mt-3"
           style="background-color: #ffb6c1; color: #4b2e83;">
          Agendar Cita
        </a>
      </div>
    </div>
  </section>

  <footer class="text-center py-4" style="background-color: #ffeef3; color: #4b2e83;">
    <p class="mb-1 fw-semibold">🐩 Síguenos en redes</p>
    <div class="d-flex justify-content-center gap-3">
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">Facebook</a>
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">Instagram</a>
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">WhatsApp</a>
    </div>
    <p class="mt-3 mb-0 small">
      © 2025 Estética Canina y Spa Guapos. Todos los derechos reservados.
    </p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
