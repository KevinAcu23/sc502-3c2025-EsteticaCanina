<?php

require_once __DIR__ . '/../models/Producto.php';

class ProductosController
{
    private $productoModel;

    public function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->productoModel = new Producto();
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

  
    private function guardarImagen(string $campo, ?string $imagenActual = null)
    {
        if (!isset($_FILES[$campo]) || $_FILES[$campo]['error'] === UPLOAD_ERR_NO_FILE) {
            
            return $imagenActual;
        }

        if ($_FILES[$campo]['error'] !== UPLOAD_ERR_OK) {
            return false;
        }

        $permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $nombreOriginal = $_FILES[$campo]['name'];
        $ext = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));

        if (!in_array($ext, $permitidas)) {
            return false;
        }

       
        $uploadDir = __DIR__ . '/../uploads/productos/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $nuevoNombre = uniqid('prod_', true) . '.' . $ext;
        $rutaFisica  = $uploadDir . $nuevoNombre;

        if (!move_uploaded_file($_FILES[$campo]['tmp_name'], $rutaFisica)) {
            return false;
        }

        $rutaRelativa = 'uploads/productos/' . $nuevoNombre;

      
        if ($imagenActual) {
            $rutaAnterior = __DIR__ . '/../' . $imagenActual;
            if (is_file($rutaAnterior)) {
                @unlink($rutaAnterior);
            }
        }

        return $rutaRelativa;
    }

    public function index()
    {
        $this->requireLogin();

        $currentPage = 'productos';

        $productos = $this->productoModel->obtenerTodos();

        $mensaje_exito = $_SESSION['mensaje_exito'] ?? null;
        $error         = $_SESSION['error'] ?? null;
        unset($_SESSION['mensaje_exito'], $_SESSION['error']);

        require_once __DIR__ . '/../views/productos/ProductosView.php';
    }

    // Crear producto (admin)
    public function crear()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=productos/index');
            exit();
        }

        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = trim($_POST['precio'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del producto es obligatorio.';
        }
        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria.';
        }
        if ($precio === '' || !is_numeric($precio) || $precio <= 0) {
            $errores[] = 'El precio debe ser un número mayor que 0.';
        }

        $imagenRuta = $this->guardarImagen('imagen');
        if ($imagenRuta === false) {
            $errores[] = 'Error al subir la imagen. Revisa el formato.';
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode('<br>', $errores);
            header('Location: ?url=productos/index');
            exit();
        }

        $data = [
            'nombre'      => $nombre,
            'descripcion' => $descripcion,
            'precio'      => $precio,
            'imagen_url'  => $imagenRuta,
        ];

        if ($this->productoModel->crear($data)) {
            $_SESSION['mensaje_exito'] = 'Producto creado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo crear el producto.';
        }

        header('Location: ?url=productos/index');
        exit();
    }

    // Eliminar producto (admin)
    public function eliminar()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=productos/index');
            exit();
        }

        $id     = isset($_POST['producto_id']) ? (int)$_POST['producto_id'] : 0;
        $esAjax = isset($_POST['ajax']) && $_POST['ajax'] === '1';

        if ($id <= 0) {
            if ($esAjax) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de producto inválido.'
                ]);
                return;
            }
            $_SESSION['error'] = 'Producto inválido.';
            header('Location: ?url=productos/index');
            exit();
        }

        // Para borrar la imagen del disco
        $producto = $this->productoModel->obtenerPorId($id);

        $ok = $this->productoModel->eliminar($id);

        if ($ok && $producto && !empty($producto['imagen_url'])) {
            $rutaFisica = __DIR__ . '/../' . $producto['imagen_url'];
            if (is_file($rutaFisica)) {
                @unlink($rutaFisica);
            }
        }

        if ($esAjax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => $ok,
                'message' => $ok
                    ? 'Producto eliminado correctamente.'
                    : 'No se pudo eliminar el producto.'
            ]);
            return;
        }

        if ($ok) {
            $_SESSION['mensaje_exito'] = 'Producto eliminado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo eliminar el producto.';
        }

        header('Location: ?url=productos/index');
        exit();
    }

    // EDITAR producto (admin)
    public function editar()
    {
        $this->requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ?url=productos/index');
            exit();
        }

        $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
        if ($id <= 0) {
            $_SESSION['error'] = 'Producto inválido.';
            header('Location: ?url=productos/index');
            exit();
        }

        $productoActual = $this->productoModel->obtenerPorId($id);
        if (!$productoActual) {
            $_SESSION['error'] = 'El producto no existe.';
            header('Location: ?url=productos/index');
            exit();
        }

        $nombre      = trim($_POST['nombre'] ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $precio      = trim($_POST['precio'] ?? '');

        $errores = [];

        if ($nombre === '') {
            $errores[] = 'El nombre del producto es obligatorio.';
        }
        if ($descripcion === '') {
            $errores[] = 'La descripción es obligatoria.';
        }
        if ($precio === '' || !is_numeric($precio) || $precio <= 0) {
            $errores[] = 'El precio debe ser un número mayor que 0.';
        }

        $imagenRuta = $this->guardarImagen('imagen', $productoActual['imagen_url']);
        if ($imagenRuta === false) {
            $errores[] = 'Error al subir la nueva imagen. Revisa el formato.';
        }

        if (!empty($errores)) {
            $_SESSION['error'] = implode('<br>', $errores);
            header('Location: ?url=productos/index');
            exit();
        }

        $data = [
            'nombre'      => $nombre,
            'descripcion' => $descripcion,
            'precio'      => $precio,
            'imagen_url'  => $imagenRuta,
        ];

        $ok = $this->productoModel->actualizar($id, $data);

        if ($ok) {
            $_SESSION['mensaje_exito'] = 'Producto actualizado correctamente.';
        } else {
            $_SESSION['error'] = 'No se pudo actualizar el producto.';
        }

        header('Location: ?url=productos/index');
        exit();
    }
}
