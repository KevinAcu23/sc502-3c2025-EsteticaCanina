<?php

// por si no lo maneja tu autoload, puedes requerirlo a mano:
// require_once __DIR__ . '/../models/Auth.php';

class AuthController
{
    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Si ya está logueado y viene por GET → lo mando al home
        if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
            header('Location: ?url=home/index');
            exit();
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email    = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = new Auth();

            if ($user->login($email, $password)) {
                header('Location: ?url=home/index');
                exit();
            } else {
                $error = "Email o contraseña incorrectos.";
            }
        }

        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function registro()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre   = $_POST['nombre']   ?? '';
            $email    = $_POST['email']    ?? '';
            $password = $_POST['password'] ?? '';

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $user = new Auth();

            if ($user->registrar($nombre, $email, $passwordHash)) {
                header('Location: ?url=auth/login&registered=1');
                exit();
            } else {
                $error = "Error al registrar. Intente de nuevo.";
            }
        }

        require_once __DIR__ . '/../views/auth/registro.php';
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        session_unset();
        session_destroy();

        header('Location: ?url=auth/login');
        exit();
    }
}
