<?php

if (isset($_SESSION['user_id']) && !isset($_SESSION['login_time'])) {
    $_SESSION['login_time'] = date('H:i:s');
    $_SESSION['user_name'] = 'Nombre de Usuario'; 
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Encuestas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="/encuestas/app/public/css/style.css">
    
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

</head>
<body class="d-flex flex-column min-vh-100"> <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/encuestas/encuestas/index">EncuestasAPP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/encuestas/encuestas/index">Inicio</a>
                        </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-text me-3 text-white">
                                <i class="fas fa-user-circle me-1"></i> Hola, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
                            </span>
                        </li>
                        <li class="nav-item d-flex align-items-center">
                            <span class="navbar-text me-3 text-secondary">
                                <i class="fas fa-clock me-1"></i> Logueado a las: <?php echo htmlspecialchars($_SESSION['login_time']); ?>
                            </span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-outline-danger" href="/encuestas/auth/logout">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="btn btn-outline-light me-2" href="/encuestas/auth/login">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-light" href="/encuestas/auth/registro">
                                <i class="fas fa-user-plus"></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <main class="flex-grow-1">