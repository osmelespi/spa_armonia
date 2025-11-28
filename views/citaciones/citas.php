<?php
require_once '../controllers/citaController.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?action=login");
    exit();
}
if($_SESSION['rol'] == 'admin'){
    header("Location: index.php?action=home");
    exit();
}

$citaController = new CitaController();
$citas = $citaController->obtenerCitasPorIdUsuario($_SESSION['user_id']);
?>
<main class="container">
    <div class="card text-center">
        <div class="card-header">
            <ul class="nav nav-pills card-header-pills">
            <li class="nav-item">
                <a id="openAppointment" class="nav-link active" href="#">Pedir Cita</a>
            </li>
            <li class="nav-item">
                <a id="openModifyAppointment" class="nav-link" href="#">Ver y Modificar Cita</a>
            </li>
            </ul>
        </div>
        <div class="card-body">
            <form id="appointmentForm">
                <input type="hidden" id="userId" value="<?php echo $_SESSION['user_id']; ?>">
                <div class="row">
                   <!-- Fecha de la Cita -->
                    <div class="col-6 mb-4">
                        <label for="appointmentDate" class="form-label">
                            <i class="bi bi-calendar3"></i> Fecha de la Cita
                        </label>
                        <div class="calendar-container">
                            <input type="date" class="form-control form-control-lg" id="appointmentDate" required>
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Selecciona una fecha disponible
                            </small>
                        </div>
                    </div>

                    <!-- Hora de la Cita -->
                    <div class="col-6 mb-4">
                        <label class="form-label">
                            <i class="bi bi-clock"></i> Hora de la Cita
                        </label>
                        <div id="timeSlotsContainer">
                            <input type="time" class="form-control form-control-lg" id="appointmentTime" required>
                        </div>
                    </div>
                </div>
                <!-- Motivo de la Cita -->
                <div class="mb-4">
                    <label for="appointmentReason" class="form-label">
                        <i class="bi bi-chat-left-text"></i> Motivo de la Cita
                    </label>
                    <textarea class="form-control" id="appointmentReason" rows="4" 
                                placeholder="Describe brevemente el motivo de tu cita..." required></textarea>
                </div>

                <!-- Botón Solicitar -->
                <div class="d-grid mt-4">
                    <button type="button" onclick="crearCita()" class="btn btn-primary btn-lg">
                        <i class="bi bi-send-check"></i> Solicitar Cita
                    </button>
                </div>
            </form> 
            <div class="container" id="modifyAppointmentForm">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">
                        <div class="appointments-card">
                            <div class="appointments-header">
                                <div class="appointments-icon">
                                    <i class="bi bi-calendar-week"></i>
                                </div>
                                <h2 class="mb-1">Mis Citas</h2>
                                <p class="text-muted">Gestiona tus citas programadas</p>
                            </div>

                            <!-- Lista de Citas -->
                            <div id="appointmentsList" class="row gap-4">
                                <?php if (!empty($citas)): ?>
                                <?php foreach ($citas as $cita): ?>
                                    <div class="card appointment-item d-flex flex-wrap align-items-center p-3 col-md-6 col-lg-4" data-id="<?php echo $cita['idCita']; ?>">
                                        <div class="appointment-info">
                                            <div class="appointment-date">
                                                <i class="bi bi-calendar3"></i> 
                                                <?php
                                                // Formatear fecha en español usando IntlDateFormatter (más fiable que strftime)
                                                $date = new DateTime($cita['fecha_cita']);

                                                if (class_exists('IntlDateFormatter')) {
                                                    $fmt = new IntlDateFormatter(
                                                        'es_ES',
                                                        IntlDateFormatter::FULL,
                                                        IntlDateFormatter::NONE,
                                                        'Europe/Madrid',
                                                        IntlDateFormatter::GREGORIAN,
                                                        "EEEE, d 'de' MMMM 'de' y"
                                                    );
                                                    $fecha = $fmt->format($date);
                                                    echo ucfirst(mb_strtolower($fecha, 'UTF-8'));
                                                } else {
                                                    // Fallback a strftime si no existe la extensión intl
                                                    setlocale(LC_TIME, 'es_ES.UTF-8', 'es_ES', 'Spanish_Spain.1252');
                                                    $fecha = strftime("%A, %d de %B de %Y", $date->getTimestamp());
                                                    echo ucfirst(utf8_encode($fecha));
                                                }
                                                ?>
                                            </div>
                                            <div class="appointment-time">
                                                <i class="bi bi-clock"></i> 
                                                <?php 
                                                    $hora = date("H:i", strtotime($cita['fecha_cita']));
                                                    echo $hora; 
                                                ?>
                                            </div>
                                            <div class="appointment-reason">
                                                <i class="bi bi-chat-left-text"></i> <?php echo $cita['motivo_cita']; ?>
                                            </div>
                                        </div>
                                        <div class="appointment-actions mt-3">
                                            <button class="btn btn-primary" onclick="openEditModal(<?php echo $cita['idCita']; ?>)">
                                                <i class="bi bi-pencil-square"></i> Modificar
                                            </button>
                                            <button class="btn btn-danger" onclick="eliminarCita(<?php echo $cita['idCita']; ?>)">
                                                <i class="bi bi-trash"></i> Borrar
                                            </button>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <p class="text-muted">No tienes citas programadas.</p>
                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Modal Editar Cita -->
    <div class="modal fade" id="editCitaModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square"></i> Editar Cita
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm" autocomplete="off">
                        <input type="hidden" id="editIdCita" required>
                        
                        <div class="row mb-3">
                            <div class="col">
                                <label for="editDate" class="form-label">
                                    <i class="bi bi-calendar3"></i> Fecha
                                </label>
                                <input type="date" class="form-control" id="editDate" required>
                            </div>
                            <div class="col">
                                <label class="form-label">
                                    <i class="bi bi-clock"></i> Hora
                                </label>
                                <input type="time" class="form-control" id="editTime" required>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="mb-3">
                            <label for="editReason" class="form-label">
                                <i class="bi bi-chat-left-text"></i> Motivo de la Cita
                            </label>
                            <textarea class="form-control" id="editMotivoCita" rows="3" required></textarea>
                            <small class="text-muted">
                                <span id="editCharCount">0</span>/500 caracteres
                            </small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </button>
                    <button type="button" class="btn btn-success" onclick="editarCita()">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="/public/js/citas.js"></script>
