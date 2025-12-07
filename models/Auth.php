<?php

class Auth
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = getPDOConnection();
    }

    public function login(string $email, string $password): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $sql = "SELECT id, nombre, email, password, rol
                FROM usuarios
                WHERE email = :email
                LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            return false; // no existe el correo
        }

        // Verificar contraseña (guardada con password_hash)
        if (!password_verify($password, $user['password'])) {
            return false;
        }

        // Guardar datos en sesión
        $_SESSION['user_id']   = $user['id'];
        $_SESSION['user_name'] = $user['nombre'];
        $_SESSION['user_role'] = $user['rol'] ?? 'cliente';

        return true;
    }

    public function registrar(string $nombre, string $email, string $passwordHash): bool
    {
        $sql = "INSERT INTO usuarios (nombre, email, password, rol)
                VALUES (:nombre, :email, :password, :rol)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nombre'   => $nombre,
            ':email'    => $email,
            ':password' => $passwordHash,
            ':rol'      => 'cliente', // registro normal = cliente
        ]);
    }
}
