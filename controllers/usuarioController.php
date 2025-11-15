<?php
require_once '../config/database.php';
require_once '../models/user_data.php';
require_once '../models/user_login.php';

class UsuarioController {
    private $db;
    private $userData;
    private $userLogin;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userData = new UserData($this->db);
        $this->userLogin = new UserLogin($this->db);
    }

    // Métodos para manejar las operaciones de usuario
    public function registrarUsuario() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                // Guardar datos personales
                $this->userData->nombre = $_POST['nombre'];
                $this->userData->apellidos = $_POST['apellidos'];
                $this->userData->email = $_POST['email'];
                $this->userData->telefono = $_POST['telefono'];
                $this->userData->fechaNacimiento = $_POST['fecha_nacimiento'];
                $this->userData->direccion = $_POST['direccion'];
                $this->userData->sexo = $_POST['sexo'];
                $this->userData->save();

                // Obtener el ID del usuario recién creado
                $idUser = $this->db->lastInsertId();

                // Guardar datos de login
                $this->userLogin->idUser = $idUser;
                $this->userLogin->usuario = $_POST['usuario'];
                $this->userLogin->contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);
                $this->userLogin->rol = 'user';
                $this->userLogin->save();

                header("Location: index.php?action=login");
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION['error'] = "Error al registrar el usuario";
            }
            
        }
    }
}

?>