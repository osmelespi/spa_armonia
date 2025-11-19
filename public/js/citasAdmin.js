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
            fechaCita: new Date(fecha + ' ' + hora).toISOString(),
            motivoCita: motivo
        },
        success: function(response) {
            //if (response.success) {
                alert('Cita creada exitosamente');
                location.reload();
            //} else {
            //    alert('Error al crear la cita');
            //}
        }
    });
}
