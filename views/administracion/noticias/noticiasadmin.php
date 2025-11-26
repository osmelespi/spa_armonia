<?php
require_once '../controllers/noticiaController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
if($_SESSION['rol'] == 'user'){
    header("Location: index.php?action=home");
    exit();
}

$noticiaController = new NoticiaController();
$noticias = $noticiaController->obtenerNoticias();
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
                        <?php if (!empty($noticias)): ?>
                            <?php foreach ($noticias as $noticia): ?>
                                <?php
                                $textoCorto = strlen($noticia['texto']) > 100 ? substr($noticia['texto'], 0, 100) . '...' : $noticia['texto'];
                                ?>
                                <!-- Cambié col-md-3 para que esté en el div correcto -->
                                <div class="col-md-3">
                                    <div class="card news-item p-4" data-id="<?php echo htmlspecialchars($noticia['idNoticia']); ?>" data-search="<?php echo htmlspecialchars($noticia['titulo'] . ' ' . $noticia['texto']); ?>">
                                        <div class="news-image mb-3 text-center">
                                            <img src="<?php echo htmlspecialchars($noticia['imagen']); ?>" alt="Imagen de la Noticia" class="img-fluid rounded" style="max-height: 150px;">
                                        </div>
                                        <div class="news-info">
                                            <div class="news-title">
                                                <b>Título:</b> <?php echo htmlspecialchars($noticia['titulo']); ?>
                                            </div>
                                            <div class="news-content">
                                                <b>Contenido:</b> <?php echo htmlspecialchars($textoCorto); ?>
                                            </div>
                                        </div>
                                        <div class="user-actions mt-3">
                                            <!-- Corregido: usaba 'id' en lugar de 'idNoticia' -->
                                            <button class="btn btn-primary btn-sm" onclick="editarNoticia(<?php echo $noticia['idNoticia']; ?>)">
                                                Modificar
                                            </button>
                                            <button class="btn btn-danger btn-sm" onclick="borrarNoticia(<?php echo $noticia['idNoticia']; ?>)">
                                                Borrar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        No hay noticias disponibles.
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
                <form id="createNoticiaForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="createTitle" class="form-label">
                                    Título de la Noticia
                                </label>
                                <input type="text" class="form-control" id="createTitle" name="titulo" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="uploadFile" class="form-label">
                                    Archivo de la Noticia
                                </label>
                                <input type="file" class="form-control" id="uploadFile" name="imagen" accept="image/*" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="createContent" class="form-label">
                                Contenido de la Noticia
                                </label>
                                <textarea class="form-control" id="createContent" name="texto" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Crear Noticia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Modificar Noticia -->
    <div class="modal fade" id="editNoticia" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil"></i> Modificar Noticia
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="editNoticiaForm" enctype="multipart/form-data">
                    <input type="hidden" name="idNoticia" id="editIdNoticia">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="editTitle" class="form-label">
                                    Título de la Noticia
                                </label>
                                <input type="text" class="form-control" id="editTitle" name="titulo" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="col-md-12 mb-3">
                                <label for="editContent" class="form-label">
                                    Contenido de la Noticia
                                </label>
                                <textarea class="form-control" id="editContent" name="texto" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-warning">Modificar Noticia</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<script src="/public/js/noticias.js"></script>