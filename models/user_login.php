<?php

class UserLogin {
    private $db;
    private $table = 'users_login';
    
    public $idLogin;
    public $idUser;
    public $usuario;
    public $contrasena;
    public $rol;
 

    public function __construct($database) {
        $this->db = $database;
    }

    
    public function save() {
        $query = "INSERT INTO " . $this->table . " (idUser, usuario, contrasena, rol) 
                  VALUES (:idUser, :usuario, :contrasena, :rol)";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':idUser', $this->idUser);
        $stmt->bindParam(':usuario', $this->usuario);
        $stmt->bindParam(':contrasena', $this->contrasena);
        $stmt->bindParam(':rol', $this->rol);
        
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE idUser = :id LIMIT 0,1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Recuperar usuario por nombre de usuario
    public function getByUsername($username) {
        $query = "SELECT * FROM " . $this->table . " WHERE usuario = :username LIMIT 0,1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                    SET contrasena = :contrasena, rol = :rol 
                    WHERE idUser = :id";
        
        $stmt = $this->db->prepare($query);
        
        $stmt->bindParam(':contrasena', $this->contrasena);
        $stmt->bindParam(':rol', $this->rol);
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