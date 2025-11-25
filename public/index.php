<?php

session_start();

require_once '../config/database.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        require_once '../views/layouts/header.php';
        require_once '../views/home/index.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'noticias':
        require_once '../views/layouts/header.php';
        require_once '../views/noticias/noticias.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'registro':
        require_once '../views/layouts/header.php';
        require_once '../views/registro/registrar.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'registrar_usuario':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->registrarUsuario();
        break;
    case 'login':
        require_once '../views/layouts/header.php';
        require_once '../views/login/login.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'autenticar':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->login();
        break;
    case 'logout':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->logout();
        break;
    case 'buscar_usuarios':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->buscarUsuarios();
        break;
    case 'crear_usuario':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->crearUsuario();
        break;
    case 'perfil':
        require_once '../views/layouts/header.php';
        require_once '../views/perfil/perfil.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'actualizar_perfil':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->actualizarPerfil();
        break;
    case 'cambiar_contrasena':
        require_once '../controllers/usuarioController.php';
        $usuarioController = new UsuarioController();
        $usuarioController->cambiarContrasena();
        break;  
    case 'citas':
        require_once '../views/layouts/header.php';
        require_once '../views/citaciones/citas.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'usuarios_admin':
        require_once '../views/layouts/header.php';
        require_once '../views/administracion/usuarios/usuariosadmin.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'citas_admin':
        require_once '../views/layouts/header.php';
        require_once '../views/administracion/citas/citasadmin.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'noticias_admin':
        require_once '../views/layouts/header.php'; 
        require_once '../views/administracion/noticias/noticiasadmin.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'crear_noticia':
        require_once '../controllers/noticiaController.php';
        $noticiaController = new NoticiaController();
        $noticiaController->guardarNoticia();
        break;
    case 'obtener_noticia':
        require_once '../controllers/noticiaController.php';
        $noticiaController = new NoticiaController();
        $noticiaController->obtenerNoticiaPorId();
        break;
    case 'editar_noticia':
        require_once '../controllers/noticiaController.php';
        $noticiaController = new NoticiaController();
        $noticiaController->editarNoticia();
        break;
    case 'borrar_noticia':
        require_once '../controllers/noticiaController.php';
        $noticiaController = new NoticiaController();
        $noticiaController->borrarNoticia();
        break;
    case 'crear_cita':
        require_once '../controllers/citaController.php';
        $citaController = new CitaController();
        $citaController->guardarCita();
        break;
    case 'obtener_cita':
        require_once '../controllers/citaController.php';
        $citaController = new CitaController();
        $citaController->obtenerCitaPorId();
        break;
    case 'obtener_citas_usuario':
        require_once '../controllers/citaController.php';
        $citaController = new CitaController();
        $citaController->obtenerCitasPorUsuario();
        break;
    case 'editar_cita':
        require_once '../controllers/citaController.php';
        $citaController = new CitaController();
        $citaController->editarCita();
        break;
    case 'borrar_cita':
        require_once '../controllers/citaController.php';
        $citaController = new CitaController();
        $citaController->borrarCita();
        break;
    // Aquí puedes agregar más casos para diferentes acciones
    default:
        require_once '../views/layouts/header.php';
        require_once '../views/home/index.php';
        require_once '../views/layouts/footer.php';
        break;
}

?>
