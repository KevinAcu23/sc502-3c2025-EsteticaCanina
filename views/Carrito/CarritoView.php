<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$esAdmin       = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
$carrito       = $carrito ?? [];
$mensaje_exito = $mensaje_exito ?? null;
$error         = $error ?? null;
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carrito | Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column min-vh-100" style="background-color: #fffaf7;">

  <?php include __DIR__ . '/../layout/navbar.php'; ?>

  <main class="flex-grow-1" style="padding-top: 100px;">
    <div class="container">
      <h2 class="fw-bold text-center mb-4" style="color: #4b2e83;">🛒 Carrito de compras</h2>

      <?php if (!empty($mensaje_exito)): ?>
        <div class="alert alert-success">
          <?php echo $mensaje_exito; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>

      <?php if (!empty($carrito) && is_array($carrito)): ?>
        <?php
          $total = 0;
          foreach ($carrito as $item) {
            $total += ($item['precio'] * $item['cantidad']);
          }
        ?>

        <div class="card border-0 shadow-sm rounded-4 mb-4">
          <div class="card-header border-0 rounded-top-4 py-3 px-4"
               style="background: linear-gradient(90deg, #ffb6c1, #f7c6ff);">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <h5 class="mb-0 fw-bold" style="color:#4b2e83;">Tus productos</h5>
                <small class="text-muted">Revisa la cantidad antes de confirmar tu compra.</small>
              </div>
              <span class="badge rounded-pill px-3 py-2 fw-semibold"
                    style="background-color:#4b2e83; color:#fff;">
                <?php echo count($carrito); ?> ítem(s)
              </span>
            </div>
          </div>

          <div class="table-responsive px-3 pb-3">
            <table class="table align-middle mb-0 text-center">
              <thead>
                <tr style="background-color:#ffeef3; color:#4b2e83;">
                  <th class="small text-uppercase text-muted">Producto</th>
                  <th class="small text-uppercase text-muted">Precio</th>
                  <th class="small text-uppercase text-muted">Cantidad</th>
                  <th class="small text-uppercase text-muted">Subtotal</th>
                  <th class="small text-uppercase text-muted">Acción</th>
                </tr>
              </thead>
              <tbody id="carrito-body">
                <?php foreach ($carrito as $item): ?>
                  <?php
                    $subtotal = $item['precio'] * $item['cantidad'];
                  ?>
                  <tr id="item-row-<?php echo (int)$item['id']; ?>"
                      data-producto-id="<?php echo (int)$item['id']; ?>">
                    <td class="text-start">
                      <div class="fw-semibold" style="color:#4b2e83;">
                        <?php echo htmlspecialchars($item['nombre']); ?>
                      </div>
                    </td>
                    <td>
                      ₡<span class="precio"><?php echo number_format($item['precio'], 2, '.', ''); ?></span>
                    </td>
                    <td style="max-width: 120px;">
                      <input
                        type="number"
                        min="1"
                        class="form-control text-center cantidad"
                        value="<?php echo (int)$item['cantidad']; ?>"
                      >
                    </td>
                    <td>
                      ₡<span class="subtotal"><?php echo $subtotal; ?></span>
                    </td>
                    <td>
                      <button
                        type="button"
                        class="btn btn-sm btn-outline-danger eliminar"
                      >
                        Eliminar
                      </button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-3">
          <a href="?url=productos/index" class="btn btn-outline-secondary">
            ← Seguir comprando
          </a>
          <div class="text-end">
            <h5 class="fw-semibold mb-1" style="color: #4b2e83;">
              Total: <span id="total">₡<?php echo $total; ?></span>
            </h5>
            <form id="form-finalizar" action="?url=carrito/finalizar" method="POST" class="d-inline">
              <button type="submit"
                      class="btn fw-bold mt-2"
                      style="background-color: #ffb6c1; color: #4b2e83;">
                Finalizar compra
              </button>
            </form>
          </div>
        </div>

      <?php else: ?>
        <div class="text-center my-5">
          <p class="mb-3 fs-5" style="color:#4b2e83;">
            Tu carrito está vacío 🐶
          </p>
          <a href="?url=productos/index" class="btn fw-semibold"
             style="background-color:#4b2e83; color:#fff;">
            Ver productos
          </a>
        </div>
      <?php endif; ?>
    </div>
  </main>

  <?php include __DIR__ . '/../layout/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- JS específico del carrito -->
  <script src="public/js/carrito.js"></script>
</body>
</html>
