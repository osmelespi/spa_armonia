$('#btnSave, #btnCancel').hide();
$('#passwordForm').hide();

let nombreOriginal = $('#nombre').val();
let apellidosOriginal = $('#apellidos').val();
let emailOriginal = $('#email').val();
let telefonoOriginal = $('#telefono').val();
let fechaNacimientoOriginal = $('#fechaNacimiento').val();
let sexoOriginal = $('#sexo').val();
let direccionOriginal = $('#direccion').val();

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