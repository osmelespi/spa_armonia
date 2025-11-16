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
                $this->userLogin->contrasena = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $this->userLogin->rol = 'user';
                $this->userLogin->save();

                header("Location: index.php?action=login");
            } catch (Exception $e) {
                $this->db->rollBack();
                $_SESSION['error'] = "Error al registrar el usuario";
            }
            
        }
    }

    public function login() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['usuario'];
            $password = strval($_POST['password']);

            $userLoginData = $this->userLogin->getByUsername($username);

            if($userLoginData && password_verify($password, $userLoginData['contrasena'])) {
                // Autenticación exitosa
                $_SESSION['user_id'] = $userLoginData['idUser'];
                $_SESSION['rol'] = $userLoginData['rol'];
                $_SESSION['usuario'] = $userLoginData['usuario'];

                $usuarioData = $this->userData->getById($userLoginData['idUser']);
                $_SESSION['nombre'] = $usuarioData['nombre'];
                $_SESSION['apellidos'] = $usuarioData['apellidos'];
                $_SESSION['error'] = null;

                header("Location: index.php?action=home");
            } else {
                // Error de autenticación
                $_SESSION['error'] = "Usuario o contraseña incorrectos";
                header("Location: index.php?action=login");
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: index.php?action=home");
    }

    public function obtenerPerfil($userId) {
        return $this->userData->getById($userId);
    }

    public function actualizarPerfil() {
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $this->userData->nombre = $_POST['nombre'];
                $this->userData->apellidos = $_POST['apellidos'];
                $this->userData->email = $_POST['email'];
                $this->userData->telefono = $_POST['telefono'];
                $this->userData->fechaNacimiento = $_POST['fecha_nacimiento'];
                $this->userData->direccion = $_POST['direccion'];
                $this->userData->sexo = $_POST['sexo'];
                
                $this->userData->update($_POST['user_id']);

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el perfil']);
        }
       
    }
}

?>