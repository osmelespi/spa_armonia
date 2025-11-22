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
                                    <span class="input-group-text">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" 
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
                    <div id="usersList" class="row g-4">
                        <!-- Usuario 1 -->
                        <div class= "card user-item p-4 col-md-3" data-id="1" data-search="juan garcía lópez juan.garcia@email.com juangarcia">
                            <div class="user-info">
                                <div class="user-name">
                                <b>Nombre:</b> Juan García López
                                </div>
                                <div class="user-email">
                                 <b>Email:</b> juan.garcia@email.com
                                </div>
                                <div class="user-username">
                                 <b>Usuario:</b> juangarcia
                                </div>
                                <div class="mt-2">
                                    <span class="role-badge role-admin badge rounded-pill text-bg-success my-2">
                                     Administrador
                                    </span>
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-primary btn-sm" onclick="editUser(1)">
                                     Modificar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(1)">
                                     Borrar
                                </button>
                            </div>
                        </div>
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
                                <input type="text" class="form-control" id="createNombre" required>
                            </div>
                            <div class="col-md-5 mb-3">
                                <label for="createApellidos" class="form-label">
                                    <i class="bi bi-person"></i> Apellidos
                                </label>
                                <input type="text" class="form-control" id="createApellidos" required>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="createSexo" class="form-label">
                                    <i class="bi bi-card-text"></i> Sexo
                                </label>
                                <select class="form-select" id="createSexo" required>
                                    <option value="">Seleccionar sexo...</option>
                                    <option value="Hombre">Masculino</option>
                                    <option value="Mujer">Femenino</option>
                                    <option value="Sin determinar">Sin determinar</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createEmail" class="form-label">
                                    <i class="bi bi-card-text"></i> Email
                                </label>
                                <input type="email" class="form-control" id="createEmail" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createTelefono" class="form-label">
                                    <i class="bi bi-card-text"></i> Teléfono
                                </label>
                                <input type="tel" class="form-control" id="createTelefono" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createFechaNacimiento" class="form-label">
                                    <i class="bi bi-card-text"></i> Fecha de Nacimiento
                                </label>
                                <input type="date" class="form-control" id="createFechaNacimiento" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createDireccion" class="form-label">
                                    <i class="bi bi-card-text"></i> Dirección
                                </label>
                                <input type="text" class="form-control" id="createDireccion" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createUsername" class="form-label">
                                    <i class="bi bi-at"></i> Nombre de Usuario
                                </label>
                                <input type="text" class="form-control" id="createUsername" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createPassword" class="form-label">
                                    <i class="bi bi-lock"></i> Contraseña
                                </label>
                                <input type="password" class="form-control" id="createPassword" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="createRole" class="form-label">
                                    <i class="bi bi-shield-check"></i> Rol
                                </label>
                                <select class="form-select" id="createRole" required>
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
                    <button type="button" class="btn btn-success" onclick="createUser()">
                    Crear Usuario
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>