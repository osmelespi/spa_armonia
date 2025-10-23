<main>
    <div class="container d-flex justify-content-center ">
        <div class="card p-4 w-50">
            <h1>Crear cuenta</h1>

            <form method="post" action="">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input id="nombre" name="nombre" type="text" class="form-control" required maxlength="100">
                    </div>

                    <div class="col-md-6">
                        <label for="apellido" class="form-label">Apellidos</label>
                        <input id="apellido" name="apellidos" type="text" class="form-control" required maxlength="100">
                    </div>

                    <div class="col-12">
                        <label for="email" class="form-label">Correo electrónico</label>
                        <input id="email" name="email" type="email" class="form-control" required maxlength="255" placeholder="nombre@ejemplo.com">
                    </div>

                    <div class="col-md-6">
                        <label for="password" class="form-label">Contraseña</label>
                        <input id="password" name="password" type="password" class="form-control" required minlength="6" autocomplete="new-password">
                    </div>

                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                        <input id="password_confirm" name="password_confirm" type="password" class="form-control" required minlength="6" autocomplete="new-password">
                    </div>

                    <div class="col-12">
                        <small class="form-text text-muted">La contraseña debe tener al menos 6 caracteres.</small>
                    </div>
                    <div class="col-12 d-flex gap-2">
                        <button type="submit" class="btn btn-green">Registrarme</button>
                        <a class="btn btn-outline-secondary" href="/iniciar-sesion.php">Iniciar sesión</a>
                    </div>
                    <div class="col-12 link">
                        ¿Ya tienes cuenta? <a href="/iniciar-sesion.php">Inicia sesión</a>
                    </div>
                </div>
            </form>

            
        </div>
    </div>
</main>