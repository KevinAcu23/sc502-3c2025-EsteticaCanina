<?php
class Encuesta {
    private $pdo;

    public function __construct() {
        $this->pdo = getPDOConnection();
    }
    
    public function getEncuestasPorUsuario($id_creador) {
        $stmt = $this->pdo->prepare("SELECT * FROM encuestas WHERE id_creador = ?");
        $stmt->execute([$id_creador]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getAllEncuestas() {
        $stmt = $this->pdo->query("SELECT * FROM encuestas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearEncuesta($id_creador, $titulo, $descripcion, $preguntas) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("INSERT INTO encuestas (id_creador, titulo, descripcion) VALUES (?, ?, ?)");
            $stmt->execute([$id_creador, $titulo, $descripcion]);
            $encuestaId = $this->pdo->lastInsertId();

            foreach ($preguntas as $pregunta) {
                $stmt = $this->pdo->prepare("INSERT INTO preguntas (id_encuesta, texto_pregunta) VALUES (?, ?)");
                $stmt->execute([$encuestaId, $pregunta]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getEncuestaCompleta($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM encuestas WHERE id = ?");
        $stmt->execute([$id]);
        $encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($encuesta) {
            $stmt = $this->pdo->prepare("SELECT * FROM preguntas WHERE id_encuesta = ?");
            $stmt->execute([$id]);
            $encuesta['preguntas'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $encuesta ? $encuesta : null;
    }
    
    public function verificarRespuesta($encuesta_id, $user_id) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM participantes WHERE id_encuesta = ? AND id_usuario = ?");
        $stmt->execute([$encuesta_id, $user_id]);
        return $stmt->fetchColumn() > 0;
    }

    public function guardarRespuestas($userId, $encuestaId, $respuestas) {
        $this->pdo->beginTransaction();
        try {
            $stmt = $this->pdo->prepare("INSERT INTO participantes (id_encuesta, id_usuario) VALUES (?, ?)");
            $stmt->execute([$encuestaId, $userId]);

            $stmt = $this->pdo->prepare("INSERT INTO respuestas (id_pregunta, id_usuario, valor_respuesta) VALUES (?, ?, ?)");
            foreach ($respuestas as $preguntaId => $valor) {
                $preguntaId = str_replace('respuesta_', '', $preguntaId);
                $stmt->execute([$preguntaId, $userId, $valor]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function getResultadosEncuesta($id) {
        $infoEncuesta = $this->getEncuestaCompleta($id);
        if (!$infoEncuesta) {
            return false;
        }

        $resultados = [];
        foreach ($infoEncuesta['preguntas'] as $pregunta) {
            $stmt = $this->pdo->prepare("SELECT valor_respuesta, COUNT(*) AS total FROM respuestas WHERE id_pregunta = ? GROUP BY valor_respuesta");
            $stmt->execute([$pregunta['id']]);
            $pregunta['resultados'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $totalRespuestas = array_sum(array_column($pregunta['resultados'], 'total'));
            $pregunta['total_respuestas'] = $totalRespuestas;

            $resultados[] = $pregunta;
        }

        return [
            'encuesta' => $infoEncuesta,
            'preguntas_con_resultados' => $resultados
        ];
    }


    public function esCreador($userId, $encuestaId) {
        $stmt = $this->pdo->prepare("SELECT id_creador FROM encuestas WHERE id = ?");
        $stmt->execute([$encuestaId]);
        $encuesta = $stmt->fetch(PDO::FETCH_ASSOC);

        return $encuesta && $encuesta['id_creador'] == $userId;
    }

    public function haSidoRespondida($encuestaId) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM participantes WHERE id_encuesta = ?");
        $stmt->execute([$encuestaId]);
        return $stmt->fetchColumn() > 0;
    }

    public function eliminarEncuesta($id) {
        $stmt = $this->pdo->prepare("DELETE FROM encuestas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}