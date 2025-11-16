<?php
require_once '../models/noticia.php';
require_once '../config/database.php';

class NoticiaController {

    private $db;
    private $noticia;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->noticia = new Noticia($this->db);
    }

    public function obtenerNoticias() {
        return $this->noticia->getAll();
    }

    public function obtenerNoticiaPorId() {
        $noticia = $this->noticia->getById($_POST['idNoticia']);
        if ($noticia) {
            echo json_encode(['success' => true, 'data' => $noticia]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Noticia no encontrada']);
        }
    }

    public function guardarNoticia() {
        try {
            $this->db->beginTransaction();

            $this->noticia->titulo = $_POST['titulo'];
            $this->noticia->imagen = $this->guardarImagen($_FILES['imagen']);
            $this->noticia->texto = $_POST['texto'];
            $this->noticia->fecha = $_POST['fecha'] ?? date('Y-m-d H:i:s'); 
            $this->noticia->idUser = $_POST['idUser'] ?? $_SESSION['user_id'];

            $resultado = $this->noticia->save();

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Noticia creada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en guardarNoticia: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al crear la noticia: ' . $e->getMessage()
            ]);
        }

        exit;
    }

    public function editarNoticia() {
        try {
            $this->db->beginTransaction();

            $this->noticia->titulo = $_POST['titulo'];
            $this->noticia->texto = $_POST['texto'];

            $resultado = $this->noticia->update($_POST['idNoticia']);

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Noticia actualizada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al actualizar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en editarNoticia: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al actualizar la noticia: ' . $e->getMessage()
            ]);
        }

        exit;
    }

    public function borrarNoticia() {
        try {
            $this->db->beginTransaction();

            $resultado = $this->noticia->delete($_POST['idNoticia']);

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Noticia eliminada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al eliminar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en borrarNoticia: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al eliminar la noticia: ' . $e->getMessage()
            ]);
        }

        exit;
    }

    private function guardarImagen($file) {
        $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = $_FILES['imagen']['type'];
        
        if (!in_array($fileType, $allowedTypes)) {
            echo json_encode(['success' => false, 'message' => 'Tipo de archivo no permitido. Solo se aceptan imágenes.']);
            exit;
        }

        // Validar tamaño (ejemplo: máximo 5MB)
        $maxSize = 5 * 1024 * 1024; // 5MB en bytes
        if ($_FILES['imagen']['size'] > $maxSize) {
            echo json_encode(['success' => false, 'message' => 'La imagen es demasiado grande. Máximo 5MB.']);
            exit;
        }

        // Crear directorio si no existe
        $uploadDir = 'uploads/noticias/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Generar nombre único para la imagen
        $extension = pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
        $nombreArchivo = uniqid('noticia_') . '_' . time() . '.' . $extension;
        $rutaDestino = $uploadDir . $nombreArchivo;

        // Mover el archivo subido
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino)) {
            echo json_encode(['success' => false, 'message' => 'Error al guardar la imagen']);
            exit;
        }

        return $rutaDestino;
    }

}

?>