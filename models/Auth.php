<?php
class Auth {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDOConnection();
    }

    public function registrar($nombre, $email, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        return $stmt->execute([$nombre, $email, $password]);
    }

    public function login($email, $password) {
        $stmt = $this->pdo->prepare("SELECT id, nombre, password FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['nombre']; 
            $_SESSION['login_time'] = date('H:i:s'); 
            return true;
        }
        return false;
    }
}