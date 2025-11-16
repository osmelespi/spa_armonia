<main class="container" role="main">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-8 col-lg-5">
            <div class="card shadow-sm mt-5">
                <div class="card-body">
                    <h1 class="card-title mb-4 text-center">Iniciar sesión</h1>

                    <form action="?action=autenticar" method="post" autocomplete="off" novalidate>
                        <input type="hidden" name="csrf_token">

                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuario</label>
                            <input id="usuario" name="usuario" type="text" required placeholder="Nombre de usuario" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input id="password" name="password" type="password" required placeholder="Contraseña" class="form-control">
                        </div>

                        <span class="text-danger"><?php echo $_SESSION['error'] ?? ''; ?></span>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-green btn-lg">Entrar</button>
                        </div>
                    </form>

                    <p class="text-muted text-center mt-3 mb-0">
                        ¿No estás registrado? <a href="?action=registro">Crear una cuenta</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</main>


