<?php
class EncuestasController {

    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /encuestas/auth/login');
            exit();
        }

        $encuesta = new Encuesta();
        $misEncuestas = $encuesta->getEncuestasPorUsuario($_SESSION['user_id']);
        $todasLasEncuestas = $encuesta->getAllEncuestas();

        require_once 'app/views/encuestas/listar_encuestas.php';
    }

    public function crear() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $titulo = $_POST['titulo'];
            $descripcion = $_POST['descripcion'];
            $preguntas = $_POST['preguntas']; 

            $encuesta = new Encuesta();
            if ($encuesta->crearEncuesta($_SESSION['user_id'], $titulo, $descripcion, $preguntas)) {
                header('Location: /encuestas/encuestas/index');
                exit();
            } else {
                
                $error = "No se pudo crear la encuesta. Inténtelo de nuevo.";
                require_once 'app/views/encuestas/crear_encuesta.php';
            }
        } else {
            require_once 'app/views/encuestas/crear_encuesta.php';
        }
    }

    public function ver($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit();
        }

        $encuesta = new Encuesta();
        $infoEncuesta = $encuesta->getEncuestaCompleta($id);

        if (!$infoEncuesta) {
            
            header("Location: /encuestas/encuestas/index");
            return;
        }
        
        $yaRespondio = $encuesta->verificarRespuesta($id, $_SESSION['user_id']);

        require_once 'app/views/encuestas/ver_encuesta.php';
    }


    public function resultados($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit();
        }

        $encuesta = new Encuesta();
        $resultados = $encuesta->getResultadosEncuesta($id);

        if (!$resultados) {
            header("Location: /encuestas/encuestas/index");
            return;
        }

        $esCreador = ($resultados['encuesta']['id_creador'] == $_SESSION['user_id']);
        
        $haSidoRespondida = $encuesta->haSidoRespondida($id);
        
        require_once 'app/views/encuestas/resultados_encuesta.php';
    }

    public function eliminar($id) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /auth/login');
            exit();
        }

        $encuesta = new Encuesta();
        
        if ($encuesta->esCreador($_SESSION['user_id'], $id) && !$encuesta->haSidoRespondida($id)) {
            if ($encuesta->eliminarEncuesta($id)) {
                // Éxito
                $_SESSION['mensaje'] = "Encuesta eliminada con éxito.";
            } else {
                // Error
                $_SESSION['error'] = "No se pudo eliminar la encuesta.";
            }
        } else {
            
            $_SESSION['error'] = "No tienes permiso para eliminar esta encuesta o ya ha sido respondida.";
        }

        header('Location: /encuestas/encuestas/index');
        exit();
    }
}