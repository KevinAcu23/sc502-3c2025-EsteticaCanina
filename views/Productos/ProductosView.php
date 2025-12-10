<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

$currentPage   = $currentPage   ?? 'productos';
$mensaje_exito = $mensaje_exito ?? null;
$error         = $error         ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Productos - Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    .producto-img {
      width: 100%;
      height: 220px;
      object-fit: contain;
      background-color: #f7f7f7;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #fffaf7;">

  <?php include __DIR__ . '/../layout/navbar.php'; ?>

  <main class="flex-grow-1">
    <section class="py-5 mt-5">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
          <h2 class="fw-bold m-0" style="color: #4b2e83;">Nuestros Productos</h2>

          <?php if ($esAdmin): ?>
            <button class="btn fw-semibold"
                    style="background-color:#4b2e83; color:#fff;"
                    data-bs-toggle="modal"
                    data-bs-target="#modalNuevoProducto">
              + Nuevo producto
            </button>
          <?php endif; ?>
        </div>

        <?php if (empty($productos)): ?>
          <p class="text-center text-muted mb-4">
            Aún no hay productos registrados.
          </p>
        <?php endif; ?>

        <div class="row g-4">
          <?php if (!empty($productos)): ?>
            <?php foreach ($productos as $producto): ?>
              <?php $precioFmt = number_format($producto['precio'], 0, ',', '.'); ?>
              <div class="col-md-4 producto-card" data-producto-id="<?php echo (int)$producto['id']; ?>">
                <div class="card h-100 shadow-sm">
                  <img src="<?php echo htmlspecialchars($producto['imagen_url']); ?>"
                       class="card-img-top producto-img"
                       alt="<?php echo htmlspecialchars($producto['nombre']); ?>">
                  <div class="card-body d-flex flex-column">
                    <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                    <p class="card-text">
                      <?php echo nl2br(htmlspecialchars($producto['descripcion'])); ?>
                    </p>
                    <p class="fw-bold mb-3" style="color: #4b2e83;">₡<?php echo $precioFmt; ?></p>

                    <div class="mt-auto d-flex flex-wrap gap-2 justify-content-between">
                      <?php if (!$esAdmin): ?>
                        <!-- SOLO CLIENTE: Agregar al carrito -->
                        <button class="btn fw-semibold btn-agregar-carrito"
                                style="background-color:#4b2e83; color:#fff;"
                                data-id="<?php echo (int)$producto['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES); ?>">
                          Agregar al carrito
                        </button>
                      <?php endif; ?>

                      <?php if ($esAdmin): ?>
                        <!-- ADMIN: Editar / Eliminar -->
                        <button type="button"
                                class="btn btn-sm btn-outline-primary fw-semibold btn-editar-producto"
                                data-id="<?php echo (int)$producto['id']; ?>"
                                data-nombre="<?php echo htmlspecialchars($producto['nombre'], ENT_QUOTES); ?>"
                                data-descripcion="<?php echo htmlspecialchars($producto['descripcion'], ENT_QUOTES); ?>"
                                data-precio="<?php echo htmlspecialchars($producto['precio']); ?>">
                          Editar
                        </button>

                        <button class="btn btn-sm btn-outline-danger fw-semibold btn-eliminar-producto"
                                data-id="<?php echo (int)$producto['id']; ?>">
                          Eliminar
                        </button>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <!-- MODAL NUEVO PRODUCTO (ADMIN) -->
  <?php if ($esAdmin): ?>
    <div class="modal fade" id="modalNuevoProducto" tabindex="-1" aria-labelledby="modalNuevoProductoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:1rem;">
          <div class="modal-header" style="background-color:#ffb6c1; border-bottom:none;">
            <h5 class="modal-title fw-bold" id="modalNuevoProductoLabel" style="color:#4b2e83;">
              Nuevo producto
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body" style="background-color:#fffaf7;">
            <form action="?url=productos/crear"
                  method="POST"
                  id="formNuevoProducto"
                  enctype="multipart/form-data">
              <div class="mb-3">
                <label class="form-label fw-semibold">Nombre del producto</label>
                <input type="text" class="form-control" name="nombre" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea class="form-control" name="descripcion" rows="3" required></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Precio (₡)</label>
                <input type="number" class="form-control" name="precio" min="0" step="100" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Imagen del producto</label>
                <input type="file" class="form-control" name="imagen" accept="image/*" required>
                <small class="text-muted">Formatos permitidos: JPG, PNG, GIF, WEBP.</small>
              </div>

              <button type="submit"
                      class="btn w-100 fw-semibold"
                      style="background-color:#4b2e83; color:#fff;">
                Guardar producto
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- MODAL EDITAR PRODUCTO (ADMIN) -->
    <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:1rem;">
          <div class="modal-header" style="background-color:#ffb6c1; border-bottom:none;">
            <h5 class="modal-title fw-bold" id="modalEditarProductoLabel" style="color:#4b2e83;">
              Editar producto
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body" style="background-color:#fffaf7;">
            <form action="?url=productos/editar"
                  method="POST"
                  id="formEditarProducto"
                  enctype="multipart/form-data">

              <input type="hidden" name="id" id="edit-id">

              <div class="mb-3">
                <label class="form-label fw-semibold">Nombre del producto</label>
                <input type="text" class="form-control" name="nombre" id="edit-nombre" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Descripción</label>
                <textarea class="form-control" name="descripcion" id="edit-descripcion" rows="3" required></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Precio (₡)</label>
                <input type="number" class="form-control" name="precio" id="edit-precio" min="0" step="100" required>
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">Imagen (opcional)</label>
                <input type="file" class="form-control" name="imagen" accept="image/*">
                <small class="text-muted">
                  Si no seleccionás nada, se mantendrá la imagen actual.
                </small>
              </div>

              <button type="submit"
                      class="btn w-100 fw-semibold"
                      style="background-color:#4b2e83; color:#fff;">
                Guardar cambios
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>

  <?php include __DIR__ . '/../layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Pasar mensajes PHP a JS -->
  <script>
    window.mensajeExitoProductos = <?php echo json_encode($mensaje_exito); ?>;
    window.errorProductos        = <?php echo json_encode($error); ?>;
  </script>

  <!-- JS específico de productos -->
  <script src="public/js/productos.js"></script>

</body>
</html>
