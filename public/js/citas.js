$('#modifyAppointmentForm').hide();


$('#openModifyAppointment').on('click', function(e) {
    $('#modifyAppointmentForm').show();
    $('#appointmentForm').hide();
    $(this).addClass('active');
    $('#openAppointment').removeClass('active');
});

$('#openAppointment').on('click', function(e) {
    $('#modifyAppointmentForm').hide();
    $('#appointmentForm').show();
    $(this).addClass('active');
    $('#openModifyAppointment').removeClass('active');
});

function crearCita() {
    const userId = $('#userId').val();
    const fecha = $('#appointmentDate').val();
    const hora = $('#appointmentTime').val();
    const motivo = $('#appointmentReason').val();

    $.ajax({
        url: 'index.php?action=crear_cita',
        method: 'POST',
        data: {
            idUser: userId,
            fechaCita: new Date(fecha + 'T' + hora + 'Z').toISOString(),
            motivoCita: motivo
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Cita creada exitosamente');
                location.reload();
            } else {
                alert('Error al crear la cita');
            }
        }
    });
}

function openEditModal(citaId) {
    $.ajax({
        url: 'index.php?action=obtener_cita',
        method: 'POST',
        data: { idCita: citaId },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const fechaCita = new Date(response.data.fecha_cita);
                const horaCita = fechaCita.toTimeString().split(' ')[0].substring(0,5);
                // Llenar el formulario de edición con los datos de la cita
                $('#editIdCita').val(response.data.idCita);
                $('#editDate').val(fechaCita.toISOString().split('T')[0]);
                $('#editTime').val(horaCita);
                $('#editMotivoCita').val(response.data.motivo_cita);
                $('#editCitaModal').modal('show');
            } else {
                alert('Error al obtener los datos de la cita');
            }
        }
    });
}

function editarCita() {
    const idCita = $('#editIdCita').val();
    const fechaCita = new Date($('#editDate').val() + 'T' + $('#editTime').val() + 'Z').toISOString();
    console.log(fechaCita);
    const motivoCita = $('#editMotivoCita').val();

    $.ajax({
        url: 'index.php?action=editar_cita',
        method: 'POST',
        data: {
            idCita: idCita,
            fechaCita: fechaCita,
            motivoCita: motivoCita
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Cita editada exitosamente');
                location.reload();
            } else {
                alert('Error al editar la cita');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al editar la cita:', error);
            alert('Ocurrió un error al editar la cita');
        }
    });
}

function eliminarCita(citaId) {
    if (confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
        $.ajax({
            url: 'index.php?action=borrar_cita',
            method: 'POST', 
            data: { idCita: citaId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Cita eliminada exitosamente');
                    location.reload();
                } else {
                    alert('Error al eliminar la cita');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', xhr.responseText);
                console.error('Error al eliminar la cita:', error);
                alert('Ocurrió un error al eliminar la cita');
            }
        });
    }
}
