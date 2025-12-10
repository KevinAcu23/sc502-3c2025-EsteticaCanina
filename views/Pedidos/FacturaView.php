<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$usuarioNombre = $pedido['nombre_usuario'] ?? ($_SESSION['user_name'] ?? 'Cliente');
$esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Factura #<?php echo (int)$pedido['id']; ?> - Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Para asegurar que html2canvas capture bien */
    #factura-contenido {
      background: #fff;
      padding: 20px;
      border-radius: 12px;
    }
  </style>
</head>

<body class="d-flex flex-column min-vh-100" style="background-color:#fffaf7;">

  <?php include __DIR__ . '/../layout/navbar.php'; ?>

  <main class="flex-grow-1" style="padding-top:100px;">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">

          <!-- TODO EL CONTENIDO DE LA FACTURA IRÁ AQUÍ -->
          <div id="factura-contenido">

            <div class="card border-0 shadow-sm rounded-4 mb-4">
              <div class="card-header border-0 rounded-top-4 py-3 px-4"
                  style="background: linear-gradient(90deg, #ffb6c1, #f7c6ff);">
                <div class="d-flex justify-content-between align-items-center">
                  <div>
                    <h5 class="mb-0 fw-bold" style="color:#4b2e83;">Factura de compra</h5>
                    <small class="text-muted">Gracias por confiar en Estética Canina y Spa Guapos 🐾</small>
                  </div>
                  <div class="text-end">
                    <div class="fw-semibold" style="color:#4b2e83;">
                      #<?php echo (int)$pedido['id']; ?>
                    </div>
                    <small class="text-muted">
                      Fecha: <?php echo htmlspecialchars($pedido['fecha']); ?>
                    </small>
                  </div>
                </div>
              </div>

              <div class="card-body px-4 py-4">
                <div class="mb-4">
                  <p class="mb-1"><strong>Cliente:</strong> <?php echo htmlspecialchars($usuarioNombre); ?></p>
                </div>

                <div class="table-responsive mb-3">
                  <table class="table table-sm align-middle">
                    <thead>
                      <tr style="background-color:#ffeef3; color:#4b2e83;">
                        <th>Producto</th>
                        <th class="text-center">Cantidad</th>
                        <th class="text-end">Precio</th>
                        <th class="text-end">Subtotal</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($detalles as $detalle): ?>
                        <tr>
                          <td><?php echo htmlspecialchars($detalle['nombre_producto']); ?></td>
                          <td class="text-center"><?php echo (int)$detalle['cantidad']; ?></td>
                          <td class="text-end">₡<?php echo number_format($detalle['precio_unitario'], 2, '.', ','); ?></td>
                          <td class="text-end">₡<?php echo number_format($detalle['subtotal'], 2, '.', ','); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>

                <h5 class="fw-bold text-end" style="color:#4b2e83;">
                  Total pagado: ₡<?php echo number_format($pedido['total'], 2, '.', ','); ?>
                </h5>
              </div>
            </div>

          </div> <!-- FIN DEL CONTENEDOR DE FACTURA -->

          <!-- BOTONES -->
          <div class="mt-4 d-flex justify-content-between">
    <?php
    $esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    ?>

    <?php if ($esAdmin): ?>
        <a href="?url=pedidos/admin" class="btn btn-outline-secondary">
          Volver a pedidos
        </a>
    <?php else: ?>
        <a href="?url=productos/index" class="btn btn-outline-secondary">
          Volver a productos
        </a>
    <?php endif; ?>

    <button onclick="descargarPDF();" class="btn fw-semibold"
            style="background-color:#4b2e83; color:#fff;">
      Descargar PDF
    </button>
</div>

        </div>
      </div>
    </div>
  </main>

  <?php include __DIR__ . '/../layout/footer.php'; ?>

  <!-- LIBRERÍAS PARA GENERAR PDF DESDE HTML -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

  <script>
    function descargarPDF() {
      const { jsPDF } = window.jspdf;
      const factura = document.getElementById('factura-contenido');

      html2canvas(factura, { scale: 3 }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF("p", "mm", "a4");

        const imgWidth = 210;
        const pageHeight = 297;
        const imgHeight = canvas.height * imgWidth / canvas.width;

        let heightLeft = imgHeight;
        let position = 0;

        pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;

        while (heightLeft > 0) {
          position = heightLeft - imgHeight;
          pdf.addPage();
          pdf.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
          heightLeft -= pageHeight;
        }

        pdf.save("Factura_<?php echo (int)$pedido['id']; ?>.pdf");
      });
    }
  </script>

</body>
</html>
