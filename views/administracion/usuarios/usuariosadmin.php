<?php
require_once '../controllers/usuarioController.php';

if($_SESSION['rol'] == 'user'){
    header("Location: index.php?action=home");
    exit();
}

$usuarioController = new UsuarioController();
$usuarios = $usuarioController->listarUsuarios();
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-md-12">
                <div class="admin-card">
                    <div class="admin-header">
                        <div class="admin-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h2 class="mb-1">Gestión de Usuarios</h2>
                        <p class="text-muted">Panel de administración de usuarios</p>
                    </div>
            
                    <!-- Botón Crear Usuario y Búsqueda -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <div class="search-box">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscarUsuarios" 
                                           placeholder="Buscar por nombre, email o nombre de usuario...">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createUser">
                                Crear Nuevo Usuario
                            </button>
                        </div>
                    </div>

                    <!-- Lista de Usuarios -->
                    <div id="usersList" class="row gap-4">
                        <!-- Usuario 1 --> 
                        <?php foreach($usuarios as $usuario): ?>
                        <div class= "card user-item p-4 col-md-3" data-id="<?php echo $usuario['idUser']; ?>" data-search="<?php echo $usuario['nombre'] . ' ' . $usuario['apellidos'] . ' ' . $usuario['email'] . ' ' . $usuario['usuario']; ?>">
                            <div class="user-info">
                                <div class="user-name">
                                <b>Nombre:</b> <?php echo $usuario['nombre'] . ' ' . $usuario['apellidos']; ?>
                                </div>
                                <div class="user-email">
                                 <b>Email:</b> <?php echo $usuario['email']; ?>
                                </div>
                                <div class="user-username">
                                 <b>Usuario:</b> <?php echo $usuario['usuario']; ?>
                                </div>
                                <div class="mt-2">
                                    <?php
                                    if ($usuario['rol'] === 'admin') {
                                        echo '<span class="role-badge badge rounded-pill text-bg-success my-2">Administrador</span>';
                                    } else {
                                        echo '<span class="role-badge badge rounded-pill text-bg-primary my-2">Usuario</span>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(<?php echo $usuario['idUser']; ?>)">
                                     Modificar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(<?php echo $usuario['idUser']; ?>)">
                                     Borrar
                                </button>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <!-- Mensaje sin resultados -->
                    <div id="noResults" class="alert alert-warning text-center" style="display: none;">
                        <i class="bi bi-exclamation-circle"></i> No se encontraron usuarios que coincidan con la búsqueda
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Usuario -->
    <div class="modal fade" id="createUser" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus"></i> Crear Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="createNombre" class="form-label">
                                    <i class="bi bi-person"></i> Nombre
                                </label>
                                <input type="text" class="form-control" id="createNombre" name="nombre" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="createApellidos" class="form-label">
                                    <i class="bi bi-person"></i> Apellidos
                                </label>
                                <input type="text" class="form-control" id="createApellidos" name="apellidos" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="createSexo" class="form-label">
                                    <i class="bi bi-card-text"></i> Sexo
                                </label>
                                <select class="form-select" id="createSexo" name="sexo" required>
                                    <option value="">Seleccionar sexo...</option>
                                    <option value="Hombre">Masculino</option>
                                    <option value="Mujer">Femenino</option>
                                    <option value="Sin determinar">Sin determinar</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="createEmail" class="form-label">
                                    <i class="bi bi-card-text"></i> Email
                                </label>
                                <input type="email" class="form-control" id="createEmail" name="email" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="createTelefono" class="form-label">
                                    <i class="bi bi-card-text"></i> Teléfono
                                </label>
                                <input type="tel" class="form-control" id="createTelefono" name="telefono" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="createFechaNacimiento" class="form-label">
                                    <i class="bi bi-card-text"></i> Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" id="createFechaNacimiento" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-7 mb-3">
                                <label for="createDireccion" class="form-label">
                                    <i class="bi bi-card-text"></i> Dirección
                                </label>
                                <input type="text" class="form-control" id="createDireccion" name="direccion" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createUsuario" class="form-label">
                                    <i class="bi bi-at"></i> Nombre de Usuario
                                </label>
                                <input type="text" class="form-control" id="createUsuario" name="usuario" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createPassword" class="form-label">
                                    <i class="bi bi-lock"></i> Contraseña
                                </label>
                                <input type="password" class="form-control" id="createPassword" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createRol" class="form-label">
                                    <i class="bi bi-shield-check"></i> Rol
                                </label>
                                <select class="form-select" id="createRol" name="role" required>
                                    <option value="">Seleccionar rol...</option>
                                    <option value="user">Usuario</option>
                                    <option value="admin">Administrador</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="crearUsuario()">
                    Crear Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal editar Usuario -->

    <div class="modal fade" id="editUserModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-lines-fill"></i> Editar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <input type="hidden" id="editUserId" name="idUser">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="editNombre" class="form-label">
                                    <i class="bi bi-person"></i> Nombre
                                </label>
                                <input type="text" class="form-control" id="editNombre" name="nombre" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="editApellidos" class="form-label">
                                    <i class="bi bi-person"></i> Apellidos
                                </label>
                                <input type="text" class="form-control" id="editApellidos" name="apellidos" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="editSexo" class="form-label">
                                    <i class="bi bi-card-text"></i> Sexo
                                </label>
                                <select class="form-select" id="editSexo" name="sexo" required>
                                    <option value="">Seleccionar sexo...</option>
                                    <option value="Hombre">Masculino</option>
                                    <option value="Mujer">Femenino</option>
                                    <option value="Sin determinar">Sin determinar</option>
                                </select>
                            </div>
                            <div class="col-md-8 mb-3">
                                <label for="editEmail" class="form-label">
                                    <i class="bi bi-card-text"></i> Email
                                </label>    
                                <input type="email" class="form-control" id="editEmail" name="email" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="editTelefono" class="form-label">
                                    <i class="bi bi-card-text"></i> Teléfono
                                </label>
                                <input type="text" class="form-control" id="editTelefono" name="telefono" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="editFechaNacimiento" class="form-label">
                                    <i class="bi bi-card-text"></i> Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" id="editFechaNacimiento" name="fecha_nacimiento" required>
                            </div>
                            <div class="col-md-7 mb-3">
                                <label for="editDireccion" class="form-label">
                                    <i class="bi bi-card-text"></i> Dirección
                                </label>
                                <input type="text" class="form-control" id="editDireccion" name="direccion" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="editRol" class="form-label">
                                    <i class="bi bi-shield-check"></i> Rol
                                </label>
                                <select class="form-select" id="editRol" name="rol" required>
                                    <option value="">Seleccionar rol...</option>
                                    <option value="admin">Administrador</option>
                                    <option value="user">Usuario</option>
                                </select>
                            </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="actualizarUsuario()">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>

</main>
<script src="/public/js/usuarios.js"></script>