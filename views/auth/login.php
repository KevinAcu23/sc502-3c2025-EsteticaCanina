<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Estética Canina y Spa Guapos</title>

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-body">

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">🐾</div>
        <div>
            <p class="brand-title">Estética Canina y Spa Guapos</p>
            <p class="brand-subtitle">Login para clientes mimados</p>
        </div>
    </div>

    <div class="login-body-inner">
        <h5 class="login-title">Iniciar sesión</h5>
        <p class="login-text">Accede para agendar citas y consentir a tu peludo ✨</p>

        <form action="?url=auth/login" method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    placeholder="ejemplo@correo.com"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input
                    type="password"
                    class="form-control"
                    name="password"
                    id="password"
                    placeholder="••••••••"
                    required
                >
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2">
                Entrar
            </button>
        </form>

        <p class="text-center mt-3 mb-1 small-link">
            ¿No tienes cuenta?
            <a href="?url=auth/registro">Regístrate aquí</a>
        </p>
    </div>
</div>

<?php

    $registered = isset($_GET['registered']) && $_GET['registered'] == '1';
    $hasError   = isset($error);
?>


<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    <?php if ($registered): ?>
        <div class="toast align-items-center text-bg-success border-0 show mb-2" role="alert" aria-live="assertive" aria-atomic="true" id="toast-registered">
            <div class="d-flex">
                <div class="toast-body">
                    Registro completado 🎉 Ahora puedes iniciar sesión.
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($hasError): ?>
        <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true" id="toast-error">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo $error; ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
            </div>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    
    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.map(function (toastEl) {
            var t = new bootstrap.Toast(toastEl);
            t.show();
            return t;
        });
    });
</script>
</body>
</html>
