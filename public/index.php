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
    case 'login':
        require_once '../views/layouts/header.php';
        require_once '../views/login/login.php';
        require_once '../views/layouts/footer.php';
        break;
    case 'perfil':
        require_once '../views/layouts/header.php';
        require_once '../views/perfil/perfil.php';
        require_once '../views/layouts/footer.php';
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
    // Aquí puedes agregar más casos para diferentes acciones
    default:
        require_once '../views/layouts/header.php';
        require_once '../views/home/index.php';
        require_once '../views/layouts/footer.php';
        break;
}

?>
