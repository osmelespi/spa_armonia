<?php
$enlace=$_GET['action'] ?? 'home';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spa Armonia</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/e6bf8f83ec.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <nav>
            <a href="?action=home">
                <img src="assets/img/logo.png" class="logo" alt="logo" width="150">
            </a>
            <ul>
                <li>
                    <a class="<?php echo $enlace === 'home' ? 'enlaceactivo' : ''; ?>" href="?action=home">Inicio</a>   
                </li>
                <?php
                $noticias = '<li>
                    <a class="' . ($enlace === 'noticias' ? 'enlaceactivo' : '') . '" href="?action=noticias">Noticias</a>
                </li>';
                
                if (isset($_SESSION['user_id'])) {
                    if ($_SESSION['rol'] === 'user') {
                        echo $noticias;
                        echo '<li>
                                <a class="' . ($enlace === 'citas' ? 'enlaceactivo' : '') . '" href="?action=citas">Citas</a>
                              </li>';
                    } else if ($_SESSION['rol'] === 'admin') {
                        echo $noticias;
                        echo '<li>
                                <a class="' . ($enlace === 'citas_admin' ? 'enlaceactivo' : '') . '" href="?action=citas_admin">Citas</a>
                              </li>
                              <li>
                                <a class="' . ($enlace === 'usuarios_admin' ? 'enlaceactivo' : '') . '" href="?action=usuarios_admin">Usuarios</a>
                              </li>
                              <li>
                                <a class="' . ($enlace === 'noticias_admin' ? 'enlaceactivo' : '') . '" href="?action=noticias_admin">Gestión de Noticias</a>
                              </li>';
                    }
                } else {
                    echo $noticias;
                }
                ?>
            </ul>
            <?php
            if (isset($_SESSION['user_id'])) {
                echo '<ul>
                        <li>
                            <div class="dropdown menu-usuario">
                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                '. $_SESSION['nombre'] .' '. $_SESSION['apellidos'] .'
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="?action=perfil">Perfil</a></li>
                                    <li><a class="dropdown-item" href="?action=logout">Cerrar Sesión</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>';
            } else {
                echo '<ul>
                        <li>
                            <a class="' . ($enlace === 'registro' ? 'enlaceactivo' : '') . '" href="?action=registro">Registrar</a>
                        </li>
                        <li>
                            <a class="loginBoton ' . ($enlace === 'login' ? 'enlaceactivo' : '') . '" href="?action=login">Iniciar Sesión</a>
                        </li>
                    </ul>';
            }
            ?>
        </nav>
    </header>
