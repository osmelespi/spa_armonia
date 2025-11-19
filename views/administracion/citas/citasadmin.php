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
                    <div id="appointmentsList" class="row gap-3">
                        <!-- Cita 1 -->
                         <?php if (!empty($citas)): foreach ($citas as $cita): ?>
                        <div class="card user-item p-4 col-md-3" data-user="<?php echo $cita['idUser']; ?>">
                            <div class="appointment-info">
                                <div class="appointment-user">
                                    <b>Nombre:</b> <?php echo $cita['nombre_usuario'] . ' ' . $cita['apellidos_usuario']; ?>
                                </div>
                                <?php
                                // Formatear fecha en español (Intl preferred, fallback a setlocale/strftime)
                                try {
                                    $date = new DateTime($cita['fecha_cita']);
                                    if (class_exists('IntlDateFormatter')) {
                                        $fmt = new IntlDateFormatter(
                                            'es_ES', 
                                            IntlDateFormatter::NONE, 
                                            IntlDateFormatter::NONE, 
                                            'Europe/Madrid', 
                                            IntlDateFormatter::GREGORIAN, 
                                            "EEEE, d 'de' MMMM 'de' yyyy"
                                        );
                                        $fechaCita = $fmt->format($date);
                                    } else {
                                        setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'es', 'spanish');
                                        $fechaCita = strftime('%A, %d de %B de %Y', $date->getTimestamp());
                                    }
                                } catch (Exception $e) {
                                    $fechaCita = date("d/m/Y", strtotime($cita['fecha_cita']));
                                }
                                ?>
                                <div class="appointment-date">
                                    <b>Fecha:</b> <?php echo ucfirst($fechaCita); ?>
                                </div>
                                <div class="appointment-time">
                                    <b>Hora:</b> <?php echo date("H:i", strtotime($cita['fecha_cita'])); ?>           
                                </div>
                                <div class="appointment-reason">
                                    <b>Motivo:</b> <?php echo $cita['motivo_cita']; ?>
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
                    <form id="createForm" autocomplete="off">
                        <!-- Seleccionar Usuario -->
                        <div class="mb-3">
                            <label for="buscarCliente" class="form-label">Cliente</label>
                            <input class="form-control" list="datalistUsuarios" id="buscarCliente" placeholder="Buscar cliente">
                            <datalist id="datalistUsuarios">
                            </datalist>
                        </div>
                        <input type="hidden" id="createUserId" required>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <label for="createDate" class="form-label">
                                    <i class="bi bi-calendar3"></i> Fecha
                                </label>
                                <input type="date" class="form-control" id="createDate" required>
                            </div>
                            <div class="col">
                                <label class="form-label">
                                    <i class="bi bi-clock"></i> Hora
                                </label>
                                <input type="time" class="form-control" id="createTimeInput" required>
                            </div>
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
                    <button type="button" class="btn btn-success" onclick="crearCita()">
                        <i class="bi bi-check-circle"></i> Crear Cita
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/public/js/citasAdmin.js"></script>