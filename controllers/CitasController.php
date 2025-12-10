<?php

require_once __DIR__ . '/../models/Cita.php';

class CitasController
{
    public function __construct()
    {
        // Asegurarnos de que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function index()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=auth/login');
            exit();
        }

        $citaModel = new Cita();

        $mensaje_exito = null;
        $error = null;
        $lastServicio = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'usuario_id'     => $_SESSION['user_id'],
                'nombre_mascota' => trim($_POST['nombre_mascota'] ?? ''),
                'telefono'       => trim($_POST['telefono'] ?? ''),
                'servicio'       => trim($_POST['servicio'] ?? ''),
                'fecha_cita'     => trim($_POST['fecha_cita'] ?? ''),
                'hora_cita'      => trim($_POST['hora_cita'] ?? ''),
                'notas'          => trim($_POST['notas'] ?? ''),
            ];

            $lastServicio = $data['servicio'];
            $errores = [];

            if ($data['nombre_mascota'] === '') {
                $errores[] = "El nombre de la mascota es obligatorio.";
            }

            if ($data['telefono'] === '') {
                $errores[] = "El teléfono de contacto es obligatorio.";
            } elseif (!preg_match('/^[0-9+\-\s]{8,20}$/', $data['telefono'])) {
                $errores[] = "El teléfono no tiene un formato válido.";
            }

            if ($data['servicio'] === '') {
                $errores[] = "Debe seleccionar un servicio.";
            }

            if ($data['fecha_cita'] === '' || $data['hora_cita'] === '') {
                $errores[] = "Debe seleccionar fecha y hora.";
            }

            if (empty($errores) &&
                $citaModel->horarioOcupado($data['fecha_cita'], $data['hora_cita'])) {

                $errores[] = "Ese horario ya está ocupado para ese día. Por favor elige otro.";
            }

            if (empty($errores)) {
                if ($citaModel->crear($data)) {
                    $mensaje_exito = "Cita agendada correctamente.";
                } else {
                    $error = "No se pudo guardar la cita. Intente de nuevo.";
                }
            } else {
                $error = implode("<br>", $errores);
            }
        }

        require_once __DIR__ . '/../views/citas/CitasView.php';
    }

    public function misCitas()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ?url=auth/login');
            exit();
        }

        $citaModel = new Cita();

        $mensaje_exito = null;
        $error = null;

    
        $esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

        if ($esAdmin) {
           
            $citasAll = $citaModel->obtenerTodas();
            
        } else {
            
            $citasUsuario = $citaModel->obtenerPorUsuario($_SESSION['user_id']);
        }

        require_once __DIR__ . '/../views/citas/MisCitasView.php';
    }

    public function cancelar()
    {
        if (!isset($_SESSION['user_id'])) {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Sesión no válida.',
                ]);
                return;
            }
            header('Location: ?url=auth/login');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'Método no permitido.',
                ]);
                return;
            }
            header('Location: ?url=citas/misCitas');
            exit();
        }

        $citaId = isset($_POST['cita_id']) ? (int)$_POST['cita_id'] : 0;

        if ($citaId <= 0) {
            if (isset($_POST['ajax'])) {
                header('Content-Type: application/json');
                echo json_encode([
                    'success' => false,
                    'message' => 'ID de cita no válido.',
                ]);
                return;
            }
            header('Location: ?url=citas/misCitas');
            exit();
        }

        $esAdmin = isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';

        $citaModel = new Cita();

    
        $usuarioParaEliminar = $esAdmin ? null : $_SESSION['user_id'];

        $ok = $citaModel->eliminar($citaId, $usuarioParaEliminar);

        if (isset($_POST['ajax'])) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => (bool)$ok,
                'message' => $ok
                    ? 'La cita se canceló correctamente.'
                    : 'No se pudo cancelar la cita.',
            ]);
            return;
        }

        header('Location: ?url=citas/misCitas');
        exit();
    }
}
