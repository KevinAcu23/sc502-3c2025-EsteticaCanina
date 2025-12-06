<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Citas - Estética Canina y Spa Guapos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body style="background-color: #fffaf7;">


  <nav class="navbar navbar-expand-lg fixed-top" style="background-color: rgba(255, 182, 193, 0.9);">
    <div class="container-fluid px-4">
      <a class="navbar-brand fw-bold" href="index.php" style="color: #4b2e83;">
        🐾 Estética Canina y Spa Guapos
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link fw-semibold" href="Citas.php" style="color: #4b2e83;">Citas</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="Productos.php" style="color: #4b2e83;">Productos</a></li>
          <li class="nav-item"><a class="nav-link fw-semibold" href="Carrito.php" style="color: #4b2e83;">Carrito</a></li>
        </ul>
      </div>
    </div>
  </nav>


  <section class="py-5 mt-5">
    <div class="container">
      <h2 class="text-center fw-bold mb-4" style="color: #4b2e83;">Agenda tu Cita</h2>
      <p class="text-center mb-5">Selecciona el servicio que deseas y el horario disponible. Solo hay 4 horarios por día (2 en la mañana y 2 en la tarde).</p>

      <div class="row g-4">

        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://cdn.pixabay.com/photo/2017/08/07/17/34/dog-2606759_1280.jpg" class="card-img-top" alt="Baño Canino">
            <div class="card-body">
              <h5 class="card-title">Baño Canino</h5>
              <p class="card-text">Baño completo con productos dermatológicamente aprobados, incluye secado y cepillado.</p>
              <p class="fw-bold" style="color: #4b2e83;">₡10,000</p>

              <form>
                <label class="fw-semibold">Selecciona horario:</label>
                <select class="form-select mb-3">
                  <option selected disabled>Elige una hora</option>
                  <option>8:00 a.m.</option>
                  <option>10:00 a.m.</option>
                  <option>1:00 p.m.</option>
                  <option>3:00 p.m.</option>
                </select>
                <button type="submit" class="btn w-100 fw-semibold" style="background-color: #4b2e83; color: #fff;">Agendar cita</button>
              </form>
            </div>
          </div>
        </div>

        
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://cdn.pixabay.com/photo/2017/02/16/19/22/dog-2071180_1280.jpg" class="card-img-top" alt="Corte de Pelo">
            <div class="card-body">
              <h5 class="card-title">Corte de Pelo</h5>
              <p class="card-text">Corte profesional según la raza y estilo del perro. Incluye retoque en orejas y patas.</p>
              <p class="fw-bold" style="color: #4b2e83;">₡12,000</p>

              <form>
                <label class="fw-semibold">Selecciona horario:</label>
                <select class="form-select mb-3">
                  <option selected disabled>Elige una hora</option>
                  <option>8:00 a.m.</option>
                  <option>10:00 a.m.</option>
                  <option>1:00 p.m.</option>
                  <option>3:00 p.m.</option>
                </select>
                <button type="submit" class="btn w-100 fw-semibold" style="background-color: #4b2e83; color: #fff;">Agendar cita</button>
              </form>
            </div>
          </div>
        </div>

    
        <div class="col-md-4">
          <div class="card h-100 shadow-sm">
            <img src="https://cdn.pixabay.com/photo/2021/04/02/16/29/dog-6145222_1280.jpg" class="card-img-top" alt="Grooming Completo">
            <div class="card-body">
              <h5 class="card-title">Grooming Completo</h5>
              <p class="card-text">Incluye baño, corte de pelo, limpieza de oídos y corte de uñas. Servicio estrella del spa.</p>
              <p class="fw-bold" style="color: #4b2e83;">₡18,000</p>

              <form>
                <label class="fw-semibold">Selecciona horario:</label>
                <select class="form-select mb-3">
                  <option selected disabled>Elige una hora</option>
                  <option>8:00 a.m.</option>
                  <option>10:00 a.m.</option>
                  <option>1:00 p.m.</option>
                  <option>3:00 p.m.</option>
                </select>
                <button type="submit" class="btn w-100 fw-semibold" style="background-color: #4b2e83; color: #fff;">Agendar cita</button>
              </form>
            </div>
          </div>
        </div>

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
    <p class="mt-3 mb-0 small">© 2025 Estética Canina y Spa Guapos. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
