<?php

class Noticia {
    private $db;
    private $table = 'noticias';

    public $idNoticia;
    public $titulo;
    public $imagen;
    public $texto;
    public $fecha;
    public $idUser;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY fecha DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save() {
        $query = "INSERT INTO " . $this->table . " (titulo, imagen, texto, fecha, idUser) 
                  VALUES (:titulo, :imagen, :texto, :fecha, :idUser)";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':imagen', $this->imagen);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':fecha', $this->fecha);
        $stmt->bindParam(':idUser', $this->idUser);

        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE idNoticia = :id LIMIT 0,1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id) {
        $query = "UPDATE " . $this->table . " 
                  SET titulo = :titulo, texto = :texto
                  WHERE idNoticia = :id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':titulo', $this->titulo);
        $stmt->bindParam(':texto', $this->texto);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE idNoticia = :id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);

        return $stmt->execute();
    }

}

?>