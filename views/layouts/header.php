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
                <li>
                    <a class="<?php echo $enlace === 'noticias' ? 'enlaceactivo' : ''; ?>" href="?action=noticias">Noticias</a>
                </li>
                
            </ul>
            <ul>
                <li>
                    <a class="<?php echo $enlace === 'registro' ? 'enlaceactivo' : ''; ?>" href="?action=registro">Registrar</a>
                </li>
                <li>
                    <a class="loginBoton <?php echo $enlace === 'login' ? 'enlaceactivo' : ''; ?>" href="?action=login">Iniciar Sesión</a>
                </li>
            </ul>
        </nav>
    </header>
