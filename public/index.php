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
    case 'registro':
        require_once '../views/layouts/header.php';
        require_once '../views/registro/registrar.php';
        require_once '../views/layouts/footer.php';
        break;
    // Aquí puedes agregar más casos para diferentes acciones
    default:
        require_once '../views/layouts/header.php';
        require_once '../views/home/index.php';
        require_once '../views/layouts/footer.php';
        break;
}

?>
