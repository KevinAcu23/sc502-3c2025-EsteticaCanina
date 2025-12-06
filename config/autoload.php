<?php
spl_autoload_register(function ($class) {
    $baseDir = dirname(__DIR__) . DIRECTORY_SEPARATOR;
    // var_dump($baseDir);

    $modelsDir = $baseDir . 'models' . DIRECTORY_SEPARATOR;

    $controllersDir = $baseDir . 'controllers' . DIRECTORY_SEPARATOR;

    // Intenta cargar como un modelo
    $modelFile = $modelsDir . $class . '.php';
    if (file_exists($modelFile)) {
        require $modelFile;
        return;
    }

    // Intenta cargar como un controlador
    $controllerFile = $controllersDir . $class . '.php';
    if (file_exists($controllerFile)) {
        require $controllerFile;
        return;
    }
});