<?php
class Cita {
    private $db;
    private $table = 'citas';

    public $idCita;
    public $idUser;
    public $fechaCita;
    public $motivoCita;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAll() {
        $query = "SELECT 
                    citas.*, 
                    users_data.nombre as nombre_usuario,
                    users_data.apellidos as apellidos_usuario,
                    users_data.email as email_usuario,
                    users_data.telefono as telefono_usuario
                FROM " . $this->table . " as citas
                LEFT JOIN users_data ON citas.idUser = users_data.idUser
                ORDER BY citas.fecha_cita DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $query = "INSERT INTO " . $this->table . " (idUser, fecha_cita, motivo_cita) 
                  VALUES (:idUser, :fecha_cita, :motivo_cita)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':idUser', $this->idUser);
        $stmt->bindParam(':fecha_cita', $this->fechaCita);
        $stmt->bindParam(':motivo_cita', $this->motivoCita);

        return $stmt->execute();
    } 

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE idCita = :id LIMIT 0,1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUserId($idUser) {
        $query = "SELECT * FROM " . $this->table . " WHERE idUser = :idUser ORDER BY fecha_cita DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                  SET idUser = :idUser, fecha_cita = :fecha_cita, motivo_cita = :motivo_cita 
                  WHERE idCita = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':idUser', $this->idUser);
        $stmt->bindParam(':fecha_cita', $this->fechaCita);
        $stmt->bindParam(':motivo_cita', $this->motivoCita);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE idCita = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

}
?>