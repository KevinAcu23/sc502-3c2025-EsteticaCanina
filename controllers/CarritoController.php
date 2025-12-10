<?php

require_once __DIR__ . '/../models/Carrito.php';
require_once __DIR__ . '/../models/Pedido.php';


class CarritoController
{
    private $carritoModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->carritoModel = new Carrito();
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=auth/login');
            exit();
        }
    }

    // Mostrar carrito
    public function index()
    {
        $this->requireLogin();

        $currentPage = 'carrito';

        // Traer items desde el modelo (usa $_SESSION['carrito'])
        $carrito = $this->carritoModel->obtenerItems();

        // Por si querés mostrar mensajes con SweetAlert
        $mensaje_exito = $_SESSION['mensaje_exito'] ?? null;
        $error         = $_SESSION['error'] ?? null;
        unset($_SESSION['mensaje_exito'], $_SESSION['error']);

        require_once __DIR__ . '/../views/carrito/CarritoView.php';
    }

    // Agregar producto al carrito
    public function agregar()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=productos/index');
            exit();
        }

        $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
        $cantidad   = isset($_POST['cantidad']) ? (int)$_POST['cantidad'] : 1;
        $esAjax     = isset($_POST['ajax']) && $_POST['ajax'] === '1';

        if ($cantidad <= 0) $cantidad = 1;

        $ok = $this->carritoModel->agregarProducto($productoId, $cantidad);

        if ($esAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $ok,
                'message' => $ok
                    ? 'Producto agregado al carrito.'
                    : 'No se pudo agregar el producto al carrito.',
            ]);
            return;
        }

        if ($ok) {
            $_SESSION['mensaje_exito'] = 'Producto agregado al carrito.';
        } else {
            $_SESSION['error'] = 'No se pudo agregar el producto al carrito.';
        }

        header('Location: ?url=carrito/index');
        exit();
    }

    // Eliminar producto del carrito
    public function eliminar()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=carrito/index');
            exit();
        }

        $productoId = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
        $esAjax     = isset($_POST['ajax']) && $_POST['ajax'] === '1';

        $ok = $this->carritoModel->eliminarProducto($productoId);

        if ($esAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $ok,
                'message' => $ok
                    ? 'Producto eliminado del carrito.'
                    : 'No se pudo eliminar el producto del carrito.',
            ]);
            return;
        }

        if ($ok) {
            $_SESSION['mensaje_exito'] = 'Producto eliminado del carrito.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el producto del carrito.';
        }

        header('Location: ?url=carrito/index');
        exit();
    }
    // Finalizar compra: crear pedido y redirigir a la "factura"
    public function finalizar()
    {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=carrito/index');
            exit();
        }

        $items = $this->carritoModel->obtenerItems();

        if (empty($items)) {
            $_SESSION['error'] = 'Tu carrito está vacío.';
            header('Location: ?url=carrito/index');
            exit();
        }

        $pedidoModel = new Pedido();
        $pedidoId = $pedidoModel->crearPedido($_SESSION['user_id'], $items);

        if (!$pedidoId) {
            $_SESSION['error'] = 'No se pudo procesar la compra. Inténtalo de nuevo.';
            header('Location: ?url=carrito/index');
            exit();
        }

        // Vaciar carrito
        $this->carritoModel->vaciar();

        // Redirigir a la "factura" del pedido
        header('Location: ?url=pedidos/factura&id=' . $pedidoId);
        exit();
    }


}
