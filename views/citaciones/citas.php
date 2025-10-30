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
                <!-- Fecha de la Cita -->
                <div class="mb-4">
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
                <div class="mb-4">
                    <label class="form-label">
                        <i class="bi bi-clock"></i> Hora de la Cita
                    </label>
                    <div id="timeSlotsContainer">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> Selecciona primero una fecha para ver los horarios disponibles
                        </div>
                    </div>
                    <input type="hidden" id="selectedTime" required>
                </div>

                <!-- Motivo de la Cita -->
                <div class="mb-4">
                    <label for="appointmentReason" class="form-label">
                        <i class="bi bi-chat-left-text"></i> Motivo de la Cita
                    </label>
                    <textarea class="form-control" id="appointmentReason" rows="4" 
                                placeholder="Describe brevemente el motivo de tu cita..." required></textarea>
                    <small class="text-muted">
                        <span id="charCount">0</span>/500 caracteres
                    </small>
                </div>

                <!-- Resumen de la Cita -->
                <div class="summary-box" id="summaryBox" style="display: none;">
                    <h6><i class="bi bi-info-circle-fill"></i> Resumen de tu Cita</h6>
                    <div class="summary-item">
                        <i class="bi bi-calendar-event"></i>
                        <strong>Fecha:</strong> <span id="summaryDate">-</span>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-clock-fill"></i>
                        <strong>Hora:</strong> <span id="summaryTime">-</span>
                    </div>
                    <div class="summary-item">
                        <i class="bi bi-chat-dots-fill"></i>
                        <strong>Motivo:</strong> <span id="summaryReason">-</span>
                    </div>
                </div>

                <!-- Botón Solicitar -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="bi bi-send-check"></i> Solicitar Cita
                    </button>
                </div>
            </form>   
        </div>
    </div>
</main>
<script src="/public/js/citas.js"></script>
