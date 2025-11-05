<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carrito | Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body style="background-color: #fffaf7;">

  <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgba(255, 182, 193, 0.9);">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold" href="#" style="color: #4b2e83;">
        🐾 Estética Canina y Spa Guapos
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link fw-semibold" href="Citas.php" style="color: #4b2e83;">Citas</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="Productos.php" style="color: #4b2e83;">Productos</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="#" style="color: #4b2e83;">Carrito</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container" style="margin-top: 120px;">
    <h2 class="fw-bold text-center mb-4" style="color: #4b2e83;">🛒 Tu Carrito de Compras</h2>

    <div class="table-responsive">
      <table class="table table-bordered align-middle text-center">
        <thead style="background-color: #ffeef3; color: #4b2e83;">
          <tr>
            <th>Producto</th>
            <th>Precio</th>
            <th>Cantidad</th>
            <th>Subtotal</th>
            <th>Acción</th>
          </tr>
        </thead>
        <tbody id="carrito-body">

          <tr>
            <td>Shampoo Antipulgas</td>
            <td>₡4500</td>
            <td><input type="number" value="1" min="1" class="form-control text-center cantidad"></td>
            <td class="subtotal">₡4500</td>
            <td><button class="btn btn-sm btn-outline-danger eliminar">Eliminar</button></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4">
      <a href="Productos.php" class="btn btn-outline-secondary">← Seguir Comprando</a>
      <div>
        <h5 class="fw-semibold" style="color: #4b2e83;">Total: <span id="total">₡4500</span></h5>
        <button class="btn fw-bold mt-2" style="background-color: #ffb6c1; color: #4b2e83;">Finalizar Compra</button>
      </div>
    </div>
  </div>

  <footer class="text-center py-4 mt-5" style="background-color: #ffeef3; color: #4b2e83;">
    <p class="mb-1 fw-semibold">🐩 Síguenos en redes</p>
    <div class="d-flex justify-content-center gap-3">
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">Facebook</a>
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">Instagram</a>
      <a href="#" class="text-decoration-none" style="color: #4b2e83;">WhatsApp</a>
    </div>
    <p class="mt-3 mb-0 small">© 2025 Estética Canina y Spa Guapos. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    const actualizarTotal = () => {
      let total = 0;
      document.querySelectorAll("#carrito-body tr").forEach(fila => {
        const precio = parseFloat(fila.children[1].textContent.replace("₡", ""));
        const cantidad = parseInt(fila.querySelector(".cantidad").value);
        const subtotal = precio * cantidad;
        fila.querySelector(".subtotal").textContent = "₡" + subtotal;
        total += subtotal;
      });
      document.getElementById("total").textContent = "₡" + total;
    };

    document.querySelectorAll(".cantidad").forEach(input => {
      input.addEventListener("change", actualizarTotal);
    });

    document.querySelectorAll(".eliminar").forEach(btn => {
      btn.addEventListener("click", e => {
        e.target.closest("tr").remove();
        actualizarTotal();
      });
    });
  </script>
</body>
</html>
