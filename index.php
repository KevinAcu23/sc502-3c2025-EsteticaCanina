<?php
date_default_timezone_set('America/Costa_Rica');
session_start();

// Rutas correctas a los archivos de configuración
require_once __DIR__ . '/config/autoload.php';
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/logs.php';

// Obtener la URL y dividirla en partes
$url = isset($_GET['url']) ? $_GET['url'] : 'auth/login';

$url = explode('/', rtrim($url, '/'));

// Nombre del controlador y método
$controllerName = ucfirst($url[0]) . 'Controller';
$methodName     = isset($url[1]) ? $url[1] : 'index';
$params         = array_slice($url, 2);

// Instanciar el controlador y llamar al método
$controllerFile = __DIR__ . '/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;

    $controller = new $controllerName();

    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "Método no encontrado.";
    }
} else {
    // Redireccionar al login si no se encuentra el controlador y no hay sesión
    if (!isset($_SESSION['user_id'])) {
        header("Location: /EsteticaCanina/auth/login");
        exit();
    }

    // O mostrar un 404
    echo "Controlador no encontrado.";
}
