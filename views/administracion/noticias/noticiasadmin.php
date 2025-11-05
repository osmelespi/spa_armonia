<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-md-12">
                <div class="admin-card">
                    <div class="admin-header">
                        <div class="admin-icon">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h2 class="mb-1">Gestión de Noticias</h2>
                        <p class="text-muted">Panel de administración de noticias</p>
                    </div>
            
                    <!-- Botón Crear Usuario y Búsqueda -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createUser">
                                Crear Nueva Noticia
                            </button>
                        </div>
                    </div>

                    <!-- Lista de Noticias -->
                    <div id="newsList" class="row g-4">
                        <!-- Noticia 1 -->
                        <div class= "card news-item p-4 col-md-3" data-id="1" data-search="Título de la noticia 1">
                            <div class="news-info">
                                <div class="news-title">
                                <b>Título:</b> Título de la noticia 1
                                </div>
                                <div class="news-content">
                                 <b>Contenido:</b> Este es el contenido de la noticia 1.
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
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Noticia -->
    <div class="modal fade" id="createUser" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-person-plus"></i> Crear Nueva Noticia
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createTitle" class="form-label">
                                    Título de la Noticia
                                </label>
                                <input type="text" class="form-control" id="createTitle" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="uploadFile" class="form-label">
                                    Archivo de la Noticia
                                </label>
                                <input type="file" class="form-control" id="uploadFile" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="createContent" class="form-label">
                                 Contenido de la Noticia
                                </label>
                                <textarea class="form-control" id="createContent" required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="createNews()">
                    Crear Noticia
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>