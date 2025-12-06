<?php
class AuthController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = new Auth();
            if ($user->login($email, $password)) {
                header('Location: /encuestas/encuestas/index');
                exit();
            } else {
                $error = "Email o contraseña incorrectos.";
                require_once 'app/views/auth/login.php';
            }
        } else {
            if(isset($_SESSION['user_id'])) {
                
                header('Location: /encuestas/encuestas/index');
                exit();
            }
            require_once 'app/views/auth/login.php';
        }
    }

    public function registro() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $user = new Auth();
            if ($user->registrar($nombre, $email, $password)) {
                header('Location: /encuestas/auth/login');
                exit();
            } else {
                $error = "Error al registrar. Intente de nuevo.";
                require_once 'app/views/auth/registro.php';
            }
        } else {
            require_once 'app/views/auth/registro.php';
        }
    }

    public function logout() {
        session_unset(); 
        session_destroy(); 
        header('Location: /encuestas/auth/login'); 
        exit();
    }
}