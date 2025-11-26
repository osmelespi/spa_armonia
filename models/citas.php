<?php
class Citas {
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
        $query = "SELECT 
                    citas.*, 
                    users_data.nombre as nombre_usuario,
                    users_data.apellidos as apellidos_usuario
                FROM " . $this->table . " as citas
                LEFT JOIN users_data ON citas.idUser = users_data.idUser
                WHERE citas.idCita = :id
                ORDER BY citas.fecha_cita DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByIdUsuario($idUsuario) {
        $query = "SELECT * FROM " . $this->table . " 
                WHERE idUser = :idUsuario
                ORDER BY fecha_cita DESC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':idUsuario', $idUsuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUsuario($usuario) {
        $query = "SELECT 
                    citas.*, 
                    users_data.nombre as nombre_usuario,
                    users_data.apellidos as apellidos_usuario,
                    users_data.email as email_usuario,
                    users_data.telefono as telefono_usuario
                FROM " . $this->table . " as citas
                LEFT JOIN users_data ON citas.idUser = users_data.idUser
                WHERE users_data.nombre LIKE :nombreUsuario
                ORDER BY citas.fecha_cita DESC";

        $stmt = $this->db->prepare($query);
        $likeUsuario = "%" . $usuario . "%";
        $stmt->bindParam(':nombreUsuario', $likeUsuario);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                  SET fecha_cita = :fecha_cita, motivo_cita = :motivo_cita 
                  WHERE idCita = :id";

        $stmt = $this->db->prepare($query);

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

      public function deleteByUserId($id) {
        $query = "DELETE FROM " . $this->table . " WHERE idUser = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }


}
?>