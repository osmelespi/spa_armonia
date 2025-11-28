<?php
require_once '../config/database.php';
require_once '../models/user_data.php';
require_once '../models/user_login.php';
require_once '../models/citas.php';

class UsuarioController {
    private $db;
    private $userData;
    private $userLogin;
    private $citas;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->userData = new UserData($this->db);
        $this->userLogin = new UserLogin($this->db);
        $this->citas = new Citas($this->db);
    }

    public function listarUsuarios() {
        return $this->userData->getAll();
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

                $_SESSION['nombre'] = $_POST['nombre'];
                $_SESSION['apellidos'] = $_POST['apellidos'];

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el perfil']);
        }
       
    }

    public function buscarUsuarios() {
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['nombre'])) {
            $query = $_GET['nombre'];
            $usuarios = $this->userData->searchByName($query);
            $userDataList = [];
            foreach($usuarios as $usuario) {
                $userDataList[] = [
                    'id' => $usuario['idUser'],
                    'nombre' => $usuario['nombre'] . ' ' . $usuario['apellidos'],
                    'email' => $usuario['email'],
                    'usuario' => $usuario['usuario'],
                    'rol' => $usuario['rol']
                ];
            }
            header('Content-Type: application/json');
            echo json_encode($userDataList);
        }
    }

    public function cambiarContrasena() {
        try {
            if($_SERVER['REQUEST_METHOD'] == 'POST') {
                $userId = $_POST['user_id'];
                $contrasenaactual = $_POST['contrasena_actual'];
                $nuevaContrasena = $_POST['nueva_contrasena'];
                
                $usuario = $this->userLogin->getById($userId);
                if(!$usuario) {
                    throw new Exception("Usuario no encontrado");
                } else {
                    if(password_verify($nuevaContrasena, $usuario['contrasena'])) {
                        throw new Exception("La nueva contraseña no puede ser igual a la anterior");
                    } else if(password_verify($contrasenaactual, $usuario['contrasena'])) {
                        $this->userLogin->contrasena = password_hash($nuevaContrasena, PASSWORD_BCRYPT);
                    } else {
                        throw new Exception("La contraseña actual es incorrecta");
                    }
                }

                $this->userLogin->idUser = $userId;
                $this->userLogin->usuario = $usuario['usuario'];
                $this->userLogin->rol = $usuario['rol'];

                $this->userLogin->update($userId);

                session_unset();
                session_destroy();

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Contraseña cambiada correctamente']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
       
    }

    public function crearUsuario() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            try {
                $this->db->beginTransaction();
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
                $this->userLogin->rol = $_POST['rol'];
                $this->userLogin->save();

                $this->db->commit();

                echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
            } catch (Exception $e) {
                $this->db->rollBack();
                echo json_encode(['success' => false, 'message' => 'Error al crear el usuario']);
            }
            
        }
    }

    public function obtenerUsuario() {
        if($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
            $id = $_GET['id'];
            $usuarioData = $this->userData->getById($id);
            $usuarioLoginData = $this->userLogin->getById($id);

            if($usuarioData && $usuarioLoginData) {
                $usuario = [
                    'idUser' => $usuarioData['idUser'],
                    'nombre' => $usuarioData['nombre'],
                    'apellidos' => $usuarioData['apellidos'],
                    'email' => $usuarioData['email'],
                    'telefono' => $usuarioData['telefono'],
                    'fecha_nacimiento' => $usuarioData['fecha_nacimiento'],
                    'direccion' => $usuarioData['direccion'],
                    'sexo' => $usuarioData['sexo'],
                    'rol' => $usuarioLoginData['rol']
                ];

                header('Content-Type: application/json');
                echo json_encode($usuario);
            } else {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
            }
        }
    }

    public function editarUsuario() {
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

                $userLoginData = $this->userLogin->getById($_POST['user_id']);
                if(!$userLoginData) {
                    throw new Exception("Usuario no encontrado");
                }
                $this->userLogin->contrasena = $userLoginData['contrasena']; // Mantener la contraseña actual
                $this->userLogin->rol = $_POST['rol'];
                $this->userLogin->update($_POST['user_id']);

                if($_SESSION['user_id'] == $_POST['user_id']) {
                   $_SESSION['rol'] = $_POST['rol']; 
                }

                header('Content-Type: application/json');
                echo json_encode(['success' => true, 'message' => 'Perfil actualizado correctamente']);
            }
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
       
    }

    public function borrarUsuario(){
        try{
            $this->citas->deleteByUserId($_POST["user_id"]);
            $this->userLogin->delete($_POST["user_id"]);
            $this->userData->delete($_POST["user_id"]);
        
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => 'Se ha borrado el usuario correctamente']);
        } catch (Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }

    }
}
?>