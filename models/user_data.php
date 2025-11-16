<?php

class UserData {
    private $db;
    private $table = 'users_data';
    
    public $idUser;
    public $nombre;
    public $apellidos;
    public $email;
    public $telefono;
    public $fechaNacimiento;
    public $direccion;
    public $sexo;

    public function __construct($database) {
        $this->db = $database;
    }

    public function save() {
        $query = "INSERT INTO " . $this->table . " (nombre, apellidos, email, telefono, fecha_nacimiento, direccion, sexo) 
                  VALUES (:nombre, :apellidos, :email, :telefono, :fecha_nacimiento, :direccion, :sexo)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':fecha_nacimiento', $this->fechaNacimiento);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':sexo', $this->sexo);
        
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE idUser = :id LIMIT 0,1";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                  SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono, 
                      fecha_nacimiento = :fecha_nacimiento, direccion = :direccion, sexo = :sexo 
                  WHERE idUser = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':apellidos', $this->apellidos);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':telefono', $this->telefono);
        $stmt->bindParam(':fecha_nacimiento', $this->fechaNacimiento);
        $stmt->bindParam(':direccion', $this->direccion);
        $stmt->bindParam(':sexo', $this->sexo);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE idUser = :id";
        
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        
        return $stmt->execute();
    }
}

?> 