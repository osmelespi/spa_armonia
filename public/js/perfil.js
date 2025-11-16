 
let nombreOriginal = $('#nombre').val();
let apellidosOriginal = $('#apellidos').val();
let emailOriginal = $('#email').val();
let telefonoOriginal = $('#telefono').val();
let fechaNacimientoOriginal = $('#fechaNacimiento').val();
let sexoOriginal = $('#sexo').val();
let direccionOriginal = $('#direccion').val();

$('#passwordForm').hide();
$('#profileForm').show();
$('#btnSave, #btnCancel').hide();

$('#btnEdit').on('click', function() {
    // Habilitar campos de entrada
    $('#nombre, #apellidos, #email, #telefono, #fechaNacimiento, #sexo, #direccion').prop('disabled', false);
    $(this).hide();
    $('#btnSave, #btnCancel').show();
});

$('#btnCancel').on('click', function() {
    // Deshabilitar campos de entrada y restaurar valores originales
    $('#nombre, #apellidos, #email, #telefono, #fechaNacimiento, #sexo, #direccion').prop('disabled', true);
    $('#btnEdit').show();
    $('#btnSave, #btnCancel').hide();
    
    // Restaurar valores originales
    $('#nombre').val(nombreOriginal);
    $('#apellidos').val(apellidosOriginal);
    $('#email').val(emailOriginal);
    $('#telefono').val(telefonoOriginal);
    $('#fechaNacimiento').val(fechaNacimientoOriginal);
    $('#sexo').val(sexoOriginal);
    $('#direccion').val(direccionOriginal);
});

$('#openChangePassword').on('click', function(e) {
    $('#passwordForm').show();
    $('#profileForm').hide();
    $(this).addClass('active');
    $('#openPersonalData').removeClass('active');
});

$('#openPersonalData').on('click', function(e) {
    $('#passwordForm').hide();
    $('#profileForm').show();
    $(this).addClass('active');
    $('#openChangePassword').removeClass('active');
});

$('#profileForm').on('submit', function(event) {
    event.preventDefault(); // Evitar el envío del formulario por defecto

    // Aquí puedes agregar la lógica para guardar los cambios, por ejemplo, enviar un formulario
    $.ajax({
        url: 'index.php?action=actualizar_perfil',
        method: 'POST',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response, status, xhr) {
            // Manejar la respuesta del servidor
            if (response.success) {
                alert('Perfil actualizado con éxito');
                window.location.href = 'index.php?action=perfil';
            } else {
                console.log(response);
                console.error('Error al actualizar el perfil:', response.message);
                alert('Error al actualizar el perfil');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', error);
            alert('Ocurrió un error al actualizar el perfil');
        }
    });
});