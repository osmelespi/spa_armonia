<?php
require_once '../controllers/citaController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}

$citaController = new CitaController();
$citas = $citaController->obtenerCitas();
?>
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-11 col-md-12">
                <div class="admin-card">
                    <div class="admin-header">
                        <div class="admin-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h2 class="mb-1">Gestión de Citas</h2>
                        <p class="text-muted">Panel de administración de citas</p>
                    </div>

                    <!-- Filtros y Búsqueda -->
                    <div class="filter-section">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">
                                 Buscar por Usuario
                                </label>
                                <input type="text" class="form-control" id="searchInput" 
                                       placeholder="Buscar por nombre de usuario...">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button class="btn btn-success w-100" data-bs-toggle="modal" data-bs-target="#createcita">
                                 Crear Cita
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Lista de Citas -->
                    <div id="appointmentsList" class="row g-4">
                        <!-- Cita 1 -->
                         <?php if (!empty($citas)): foreach ($citas as $cita): ?>
                        <div class="card user-item p-4 col-md-3" data-id="<?php echo $cita['id']; ?>" data-user="<?php echo $cita['usuario']; ?>" data-status="<?php echo $cita['estado']; ?>">
                            <div class="appointment-info">
                                <div class="appointment-user">
                                    <b>Nombre:</b> <?php echo $cita['usuario']; ?>
                                </div>
                                <div class="appointment-date">
                                    <b>Fecha:</b> <?php echo date("l, d \d\e F \d\e Y", strtotime($cita['fecha'])); ?>
                                </div>
                                <div class="appointment-time">
                                    <b>Hora:</b> <?php echo date("H:i", strtotime($cita['hora'])); ?>           
                                </div>
                                <div class="appointment-reason">
                                    <b>Motivo:</b> <?php echo $cita['motivo']; ?>
                                </div>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn btn-primary btn-sm" onclick="editAppointment(1)">
                                    <i class="bi bi-pencil-square"></i> Modificar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteAppointment(1)">
                                    <i class="bi bi-trash"></i> Borrar
                                </button>
                            </div>
                        </div>
                        <?php endforeach; else: ?>
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        No hay citas disponibles.
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Crear Cita -->
    <div class="modal fade" id="createcita" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-plus-circle"></i> Crear Nueva Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="createForm">
                        <!-- Seleccionar Usuario -->
                        <div class="mb-3">
                            <label for="buscarCliente" class="form-label">Cliente</label>
                            <input class="form-control" list="datalistUsuarios" id="buscarCliente" placeholder="Buscar cliente">
                            <datalist id="datalistUsuarios">
                            </datalist>
                        </div>
                        <input type="hidden" id="createUserId" required>

                        <!-- Fecha -->
                        <div class="mb-3">
                            <label for="createDate" class="form-label">
                                <i class="bi bi-calendar3"></i> Fecha
                            </label>
                            <input type="date" class="form-control" id="createDate" required>
                        </div>

                        <!-- Hora -->
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-clock"></i> Hora
                            </label>
                            <div id="createTimeSlotsContainer">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle"></i> Selecciona una fecha para ver los horarios disponibles
                                </div>
                            </div>
                            <input type="hidden" id="createTime" required>
                        </div>

                        <!-- Motivo -->
                        <div class="mb-3">
                            <label for="createReason" class="form-label">
                                <i class="bi bi-chat-left-text"></i> Motivo de la Cita
                            </label>
                            <textarea class="form-control" id="createReason" rows="3" required></textarea>
                            <small class="text-muted">
                                <span id="createCharCount">0</span>/500 caracteres
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="createAppointment()">
                        <i class="bi bi-check-circle"></i> Crear Cita
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/public/js/citasAdmin.js"></script>