<?php
require_once '../models/citas.php';
require_once '../config/database.php';

class citaController {
    
    private $db;
    private $cita;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->cita = new Cita($this->db);
    }

    public function obtenerCitas() {
        return $this->cita->getAll();
    }

    public function obtenerCitaPorId() {
        $cita = $this->cita->getById($_POST['idCita']);
        if ($cita) {
            echo json_encode(['success' => true, 'data' => $cita]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Cita no encontrada']);
        }
    }

    public function obtenerCitasPorUsuario() {
        $citas = $this->cita->getByUserId($_POST['idUser']);
        if ($citas) {
            echo json_encode(['success' => true, 'data' => $citas]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se encontraron citas']);
        }
    }

    public function guardarCita() {
        try {
            $this->db->beginTransaction();

            $this->cita->idUser = $_POST['idUser'];
            $this->cita->fechaCita = $_POST['fechaCita'];
            $this->cita->motivoCita = $_POST['motivoCita'];

            $resultado = $this->cita->save();

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Cita creada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en guardarCita: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al crear la cita: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function editarCita() {
        try {
            $this->db->beginTransaction();

            $this->cita->idUser = $_POST['idUser'];
            $this->cita->fechaCita = $_POST['fechaCita'];
            $this->cita->motivoCita = $_POST['motivoCita'];

            $resultado = $this->cita->update($_POST['idCita']);

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Cita actualizada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al actualizar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en editarCita: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al actualizar la cita: ' . $e->getMessage()
            ]);
        }
        exit;
    }

    public function borrarCita() {
        try {
            $this->db->beginTransaction();

            $resultado = $this->cita->delete($_POST['idCita']);

            if ($resultado) {
                $this->db->commit();
                echo json_encode(['success' => true, 'message' => 'Cita eliminada correctamente']);
            } else {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al eliminar en la base de datos']);
            }
        } catch (Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            
            // Log del error real para debugging
            error_log('Error en borrarCita: ' . $e->getMessage());
            
            echo json_encode([
                'success' => false, 
                'message' => 'Error al eliminar la cita: ' . $e->getMessage()
            ]);
        }
        exit;
    }
}

?>