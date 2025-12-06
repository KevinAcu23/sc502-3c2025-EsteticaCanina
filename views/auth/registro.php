<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario - Estética Canina y Spa Guapos</title>

   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

  
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="login-body">

<div class="login-card">
    <div class="login-header">
        <div class="brand-icon">🐾</div>
        <div>
            <p class="brand-title">Estética Canina y Spa Guapos</p>
            <p class="brand-subtitle">Crear cuenta para tu peludo</p>
        </div>
    </div>

    <div class="login-body-inner">
        <h5 class="login-title">Registro de usuario</h5>
        <p class="login-text">Crea tu cuenta para agendar citas y llevar control de los mimos 🐶✨</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger py-2 mb-3">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        
        <form action="?url=auth/registro" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input
                    type="text"
                    class="form-control"
                    name="nombre"
                    id="nombre"
                    placeholder="Tu nombre"
                    required
                >
            </div>

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
                    placeholder="Elige una contraseña segura"
                    required
                >
            </div>

            <button type="submit" class="btn btn-login w-100 mt-2">
                Registrarme
            </button>
        </form>

        <p class="text-center mt-3 mb-1 small-link">
            ¿Ya tienes una cuenta?
            <a href="?url=auth/login">Inicia sesión aquí</a>
        </p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
