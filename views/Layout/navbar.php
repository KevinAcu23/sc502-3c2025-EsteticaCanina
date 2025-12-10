<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$currentPage = $currentPage ?? '';
?>
<nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgba(255, 182, 193, 0.9);">
  <div class="container-fluid px-4">
    <a class="navbar-brand fw-bold" href="index.php?url=home/index" style="color: #4b2e83;">
      Estética Canina y Spa Guapos
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav align-items-center">

        <!-- Mis Citas -->
       <?php if ($esAdmin): ?>
  <li class="nav-item">
    <a class="nav-link fw-semibold"
       href="index.php?url=citas/misCitas"
       style="color: #4b2e83;">
      Agenda
    </a>
  </li>
<?php else: ?>
  <li class="nav-item">
    <a class="nav-link fw-semibold"
       href="index.php?url=citas/misCitas"
       style="color: #4b2e83;">
      Mis Citas
    </a>
  </li>
<?php endif; ?>

        <!-- Productos -->
        <li class="nav-item">
          <a class="nav-link fw-semibold <?php echo $currentPage === 'productos' ? 'active' : ''; ?>"
             href="index.php?url=productos/index"
             style="color: #4b2e83;">
            Productos
          </a>
        </li>

        <!-- Carrito -->
        <?php if ($esAdmin): ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold <?php echo $currentPage === 'pedidos_admin' ? 'active' : ''; ?>"
               href="index.php?url=pedidos/admin"
               style="color: #4b2e83;">
              Pedidos
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link fw-semibold <?php echo $currentPage === 'carrito' ? 'active' : ''; ?>"
               href="index.php?url=carrito/index"
               style="color: #4b2e83;">
              Carrito
            </a>
          </li>
        <?php endif; ?>

        <?php if (isset($_SESSION['user_name'])): ?>
          <li class="nav-item ms-3">
            <span class="navbar-text fw-semibold" style="color: #4b2e83;">
              Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
            </span>
          </li>
        <?php endif; ?>

        <li class="nav-item ms-3">
          <a href="index.php?url=auth/logout" class="btn btn-sm btn-outline-light fw-semibold">
            Cerrar sesión
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>
