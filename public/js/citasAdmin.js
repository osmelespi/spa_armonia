$('#buscarCliente').on('input', function() {
    const value = $(this).val().toLowerCase();
    $.ajax({
        url: 'index.php?action=buscar_usuarios',
        method: 'GET',
        data: { nombre: value },
        dataType: 'json',
        success: function(data) {
            const usuarios = data;
            const datalist = $('#datalistUsuarios');
            datalist.empty();
            usuarios.forEach(usuario => {
                datalist.append(`<option value="${usuario.nombre}" data-id="${usuario.id}"></option>`);
            });
        }
    });
});

// Evento para capturar cuando se selecciona un usuario
$('#buscarCliente').on('change', function() {
    const nombreSeleccionado = $(this).val();
    
    // Buscamos la opción que coincide con el valor seleccionado
    const opcionSeleccionada = $('#datalistUsuarios option').filter(function() {
        return $(this).val() === nombreSeleccionado;
    });
    
    // Obtenemos el ID
    const idUsuario = opcionSeleccionada.data('id');
    
    if (idUsuario) {
        $('#createUserId').val(idUsuario);
    }
});

// Función para crear una cita
function crearCita() {
    const userId = $('#createUserId').val();
    const fecha = $('#createDate').val();
    const hora = $('#createTimeInput').val();
    const motivo = $('#createReason').val();

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

function openEditModal(idCita) {
    $.ajax({
        url: 'index.php?action=obtener_cita',
        method: 'POST',
        data: { idCita: idCita },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                const fechaCita = new Date(response.data.fecha_cita);
                const horaCita = fechaCita.toTimeString().split(' ')[0].substring(0,5);
                const nombreCliente = response.data.nombre_usuario + ' ' + response.data.apellidos_usuario;
                // Rellenar el formulario con los datos de la cita
                $('#editUserId').val(response.data.idUser);
                $('#editClienteNombre').text(nombreCliente);
                $('#editIdCita').val(response.data.idCita);
                $('#editDate').val(fechaCita.toISOString().split('T')[0]);
                $('#editTimeInput').val(horaCita);
                $('#editReason').val(response.data.motivo_cita);
                $('#editCitaModal').modal('show');
            } else {
                alert('Error al obtener los datos de la cita');
            }
        }
    });
}

function editarCita() {
    const idCita = $('#editIdCita').val();
    const fechaCita = new Date($('#editDate').val() + 'T' + $('#editTimeInput').val() + 'Z').toISOString();
    const motivoCita = $('#editReason').val();

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
            console.error('Error en la solicitud:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
            alert('Error en la solicitud: ' + error);
        }
    });
}

function borrarCita(idCita) {
    if (confirm('¿Estás seguro de que deseas eliminar esta cita?')) {
        $.ajax({
            url: 'index.php?action=borrar_cita',
            method: 'POST',
            data: { idCita: idCita },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Cita eliminada exitosamente');
                    location.reload();
                } else {
                    alert('Error al eliminar la cita');
                }
            }
        });
    }
}

$('#searchInput').on('input', function() {
    const value = $(this).val().toLowerCase();

    $.ajax({
        url: 'index.php?action=obtener_citas_usuario',
        method: 'GET',
        data: { nombre: value },
        dataType: 'json',
        success: function(response) {
            $('#appointmentsList').empty();
            response.data.forEach(cita => {
                const fechaCita = new Date(cita['fecha_cita']).toLocaleDateString();
                const horaCita = new Date(cita['fecha_cita']).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                const citaHtml = `
                    <div class="card user-item p-4 col-md-3" data-user="<?php echo $cita['idUser']; ?>">
                            <div class="appointment-info">
                                <div class="appointment-user">
                                    <b>Nombre:</b> ${cita['nombre_usuario']} ${cita['apellidos_usuario']}
                                </div>
                                <div class="appointment-telefono">
                                    <b>Teléfono:</b> ${cita['telefono_usuario']}
                                </div>
                                <div class="appointment-email">
                                    <b>Email:</b> ${cita['email_usuario']}
                                </div>
                                <div class="appointment-date">
                                    <b>Fecha:</b> ${fechaCita}
                                </div>
                                <div class="appointment-time">
                                    <b>Hora:</b> ${horaCita}
                                </div>
                                <div class="appointment-reason">
                                    <b>Motivo:</b> ${cita['motivo_cita']}
                                </div>
                            </div>
                            <div class="appointment-actions">
                                <button class="btn btn-primary btn-sm" onclick="openEditModal(${cita['idCita']})">
                                    <i class="bi bi-pencil-square"></i> Modificar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="borrarCita(${cita['idCita']})">
                                    <i class="bi bi-trash"></i> Borrar
                                </button>
                            </div>
                        </div>`;
                $('#appointmentsList').append(citaHtml);
            });
        }
    });
});
