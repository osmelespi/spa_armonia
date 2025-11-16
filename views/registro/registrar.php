<main>
    <div class="container d-flex justify-content-center ">
        <div class="card p-4 w-50">
            <h1>Crear cuenta</h1>

            <form method="post" action="?action=registrar_usuario">
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
                        <label for="telefono" class="form-label">Teléfono</label>
                        <input id="telefono" name="telefono" type="tel" class="form-control" required maxlength="20" pattern="[0-9+\-\s]{7,20}" placeholder="+34 600 000 000">
                    </div>

                    <div class="col-md-6">
                        <label for="fecha_nacimiento" class="form-label">Fecha de nacimiento</label>
                        <input id="fecha_nacimiento" name="fecha_nacimiento" type="date" class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label for="direccion" class="form-label">Dirección</label>
                        <textarea id="direccion" name="direccion" class="form-control" rows="2" maxlength="255" placeholder="Calle, número, ciudad, código postal"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select id="sexo" name="sexo" class="form-select" required>
                            <option value="" selected disabled>Selecciona...</option>
                            <option value="hombre">Hombre</option>
                            <option value="mujer">Mujer</option>
                            <option value="sin_determinar">Prefiero no decirlo</option>
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="nombre_usuario" class="form-label">Nombre de usuario</label>
                        <input id="nombre_usuario" name="usuario" type="text" class="form-control" required maxlength="50" placeholder="Nombre de usuario">
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
                        
                    </div>
                    <div class="col-12 link">
                        ¿Ya tienes cuenta? <a href="?action=login">Inicia sesión</a>
                    </div>
                </div>
            </form> 
        </div>
    </div>
</main>