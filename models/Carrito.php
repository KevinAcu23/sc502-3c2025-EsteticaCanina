<?php

require_once __DIR__ . '/Producto.php';

class Carrito
{
    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
    }

  
    public function obtenerItems(): array
    {
        return $_SESSION['carrito'];
    }

    public function agregarProducto(int $productoId, int $cantidad = 1): bool
    {
        if ($productoId <= 0 || $cantidad <= 0) {
            return false;
        }

        $productoModel = new Producto();
      
        $producto = $productoModel->obtenerPorId($productoId);

        if (!$producto) {
            return false;
        }

        if (!isset($_SESSION['carrito'][$productoId])) {
            $_SESSION['carrito'][$productoId] = [
                'id'       => (int)$producto['id'],
                'nombre'   => $producto['nombre'],
                'precio'   => (float)$producto['precio'],
                'cantidad' => $cantidad,
            ];
        } else {
            $_SESSION['carrito'][$productoId]['cantidad'] += $cantidad;
        }

        return true;
    }

   
    public function actualizarCantidad(int $productoId, int $cantidad): bool
    {
        if (!isset($_SESSION['carrito'][$productoId])) {
            return false;
        }

        if ($cantidad <= 0) {
            unset($_SESSION['carrito'][$productoId]);
            return true;
        }

        $_SESSION['carrito'][$productoId]['cantidad'] = $cantidad;
        return true;
    }

   
    public function eliminarProducto(int $productoId): bool
    {
        if (isset($_SESSION['carrito'][$productoId])) {
            unset($_SESSION['carrito'][$productoId]);
            return true;
        }
        return false;
    }

    
    public function vaciar(): void
    {
        $_SESSION['carrito'] = [];
    }
}
