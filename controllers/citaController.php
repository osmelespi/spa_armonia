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

}

?>