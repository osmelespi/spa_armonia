<?php
require_once '../controllers/usuarioController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
$usuarioController = new UsuarioController();
$perfilData = $usuarioController->obtenerPerfil($_SESSION['user_id']);
?>

<main class="container">
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a id="openPersonalData" class="nav-link active" href="#">Datos Personales</a>
            </li>
            <li class="nav-item">
                <a id="openChangePassword" class="nav-link" href="#">Cambiar Contraseña</a>
            </li>
            </ul>
        </div>
        <div class="card-body">
            <form id="profileForm">
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <!-- Nombre de Usuario (Solo lectura) -->
                <div class="mb-4">
                    <label for="username" class="form-label">
                        <i class="bi bi-person-badge"></i> Nombre de Usuario
                    </label>
                    <input type="text" class="form-control readonly-field" id="username" 
                            value="<?php echo $_SESSION['usuario']; ?>" readonly>
                    <small class="text-muted">El nombre de usuario no se puede modificar</small>
                </div>

                <!-- Nombre -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="nombre" class="form-label">
                            <i class="bi bi-person"></i> Nombre
                        </label>
                        <input type="text" class="form-control" id="nombre" name="nombre"
                                value="<?php echo $perfilData['nombre']; ?>" disabled required>
                    </div>
                    <!-- Apellidos -->
                    <div class="col-md-6">
                        <label for="apellidos" class="form-label">
                            <i class="bi bi-person"></i> Apellidos
                        </label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos"
                                value="<?php echo $perfilData['apellidos']; ?>" disabled required>
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class="bi bi-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" class="form-control" id="email" name="email"
                            value="<?php echo $perfilData['email']; ?>" disabled required>
                </div>

                <!-- Teléfono -->
                <div class="mb-3">
                    <label for="telefono" class="form-label">
                        <i class="bi bi-telephone"></i> Teléfono
                    </label>
                    <input type="tel" class="form-control" id="telefono" name="telefono"
                            value="<?php echo $perfilData['telefono']; ?>" disabled required>
                </div>

                <!-- Fecha de Nacimiento -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="fechaNacimiento" class="form-label">
                            <i class="bi bi-calendar"></i> Fecha de Nacimiento
                        </label>
                        <input type="date" class="form-control" id="fechaNacimiento" name="fecha_nacimiento"
                                value="<?php echo $perfilData['fecha_nacimiento']; ?>" disabled required>
                    </div>
                    <!-- Sexo -->
                    <div class="col-md-6">
                        <label for="sexo" class="form-label">
                            <i class="bi bi-gender-ambiguous"></i> Sexo
                        </label>
                        <select class="form-select" id="sexo" disabled required name="sexo">
                            <option value="">Seleccionar...</option>
                            <option value="Hombre" <?php echo ($perfilData['sexo'] == 'Hombre') ? 'selected' : ''; ?>>Masculino</option>
                            <option value="Mujer" <?php echo ($perfilData['sexo'] == 'Mujer') ? 'selected' : ''; ?>>Femenino</option>
                            <option value="Sin determinar" <?php echo ($perfilData['sexo'] == 'Sin determinar') ? 'selected' : ''; ?>>Sin determinar</option>
                        </select>
                    </div>
                </div>

                <!-- Dirección -->
                <div class="mb-4">
                    <label for="direccion" class="form-label">
                        <i class="bi bi-house"></i> Dirección
                    </label>
                    <textarea class="form-control" id="direccion" name="direccion" rows="2" disabled required><?php echo $perfilData['direccion']; ?></textarea>
                </div>

                <!-- Botones -->
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="button" class="btn btn-primary btn-edit" id="btnEdit">
                        <i class="bi bi-pencil"></i> Editar Perfil
                    </button>
                    <button type="button" class="btn btn-secondary btn-cancel" id="btnCancel">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="submit" class="btn btn-success btn-save" id="btnSave">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                </div>
            </form>
            <form id="passwordForm">
                <!-- Contraseña Actual -->
                <input type="hidden" name="user_id" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="mb-4">
                    <label for="currentPassword" class="form-label">
                        <i class="bi bi-lock"></i> Contraseña Actual
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="currentPassword" 
                                placeholder="Ingresa tu contraseña actual" name="contrasena_actual" required>
                    </div>
                </div>

                <!-- Nueva Contraseña -->
                <div class="mb-3">
                    <label for="newPassword" class="form-label">
                        <i class="bi bi-key"></i> Nueva Contraseña
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="newPassword" 
                                placeholder="Ingresa tu nueva contraseña" name="nueva_contrasena" required minlength="6">
                    </div>
                    <div class="password-strength" id="passwordStrength"></div>
                    
                    <!-- Requisitos de contraseña -->
                    <div class="password-requirements">
                        <small class="requirement" id="req-length">
                            <i class="bi bi-circle"></i> Mínimo 6 caracteres
                        </small>
                    </div>
                </div>

                <!-- Confirmar Nueva Contraseña -->
                <div class="mb-4">
                    <label for="confirmPassword" class="form-label">
                        <i class="bi bi-key-fill"></i> Confirmar Nueva Contraseña
                    </label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirmPassword" 
                                placeholder="Confirma tu nueva contraseña" required>
                    </div>
                    <small class="text-muted" id="matchMessage"></small>
                </div>

                <!-- Botón Cambiar -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg" id="btnChange">
                        <i class="bi bi-shield-check"></i> Cambiar Contraseña
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
<script src="/public/js/perfil.js"></script>
