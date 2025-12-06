<?php
class AuthController
{
    public function login()
    {
       
        if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'GET') {
            header('Location: ?url=home/index'); 
            exit();
        }

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
        session_unset();
        session_destroy();

        
        header('Location: ?url=auth/login');
        exit();
    }
}
