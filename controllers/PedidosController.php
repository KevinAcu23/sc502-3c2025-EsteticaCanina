<?php

require_once __DIR__ . '/../models/Pedido.php';

class PedidosController
{
    private $pedidoModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->pedidoModel = new Pedido();
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=auth/login');
            exit();
        }
    }

    private function requireAdmin()
    {
        $this->requireLogin();

        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
            header('Location: ?url=home/index');
            exit();
        }
    }

  
    public function admin()
    {
        $this->requireAdmin(); 

        $currentPage = 'pedidos_admin';

        $pedidos = $this->pedidoModel->obtenerTodos();

        require_once __DIR__ . '/../views/pedidos/AdminPedidosView.php';
    }

  
    public function factura()
{
    $this->requireLogin();

    $pedidoId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($pedidoId <= 0) {
        header('Location: ?url=carrito/index');
        exit();
    }

    // Admin puede ver cualquier pedido
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
        list($pedido, $detalles) = $this->pedidoModel->obtenerPedidoConDetalles($pedidoId, null);
    } else {
        // Cliente solo sus pedidos
        list($pedido, $detalles) = $this->pedidoModel->obtenerPedidoConDetalles($pedidoId, $_SESSION['user_id']);
    }

    if (!$pedido) {
        header('Location: ?url=carrito/index');
        exit();
    }

    $currentPage = 'pedidos';

    require_once __DIR__ . '/../views/pedidos/FacturaView.php';
}
}
