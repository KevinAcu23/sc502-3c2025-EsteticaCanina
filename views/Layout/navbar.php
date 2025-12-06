<?php
// views/layout/navbar.php

// Asegurarse de que la sesión esté iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Página actual (si no se definió, será cadena vacía)
$currentPage = $currentPage ?? '';
?>
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


          <!-- Mis Citas -->
          <li class="nav-item">
            <a class="nav-link fw-semibold <?php echo $currentPage === 'misCitas' ? 'active' : ''; ?>"
               href="?url=citas/misCitas"
               style="color: #4b2e83;">
              Mis Citas
            </a>
          </li>

          <!-- Productos -->
          <li class="nav-item">
            <a class="nav-link fw-semibold <?php echo $currentPage === 'productos' ? 'active' : ''; ?>"
               href="Productos.php"
               style="color: #4b2e83;">
              Productos
            </a>
          </li>

          <!-- Carrito -->
          <li class="nav-item">
            <a class="nav-link fw-semibold <?php echo $currentPage === 'carrito' ? 'active' : ''; ?>"
               href="Carrito.php"
               style="color: #4b2e83;">
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
