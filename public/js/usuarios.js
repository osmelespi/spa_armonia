$("#buscarUsuarios").on("input", function() {
    let name = $(this).val().toLowerCase();

    $.ajax({
        url: 'index.php?action=buscar_usuarios',
        type: 'GET',
        data: { nombre: name },
        success: function(response) {            
            let usuarios = response;
            $("#usersList").empty();
            if (usuarios.length > 0) {
                usuarios.forEach(function(usuario) {
                    $("#usersList").append(`
                        <div class="card user-item p-4 col-md-3" data-id="${usuario.idUser}" data-search="${usuario.nombre} ${usuario.email} ${usuario.usuario}">
                            <div class="user-info">
                                <div class="user-name">
                                    <b>Nombre:</b> ${usuario.nombre}
                                </div>
                                <div class="user-email">
                                    <b>Email:</b> ${usuario.email}
                                </div>
                                <div class="user-username">
                                    <b>Usuario:</b> ${usuario.usuario}
                                </div>
                                <div class="mt-2">
                                    ${usuario.rol === 'admin' ? '<span class="role-badge badge rounded-pill text-bg-success my-2">Administrador</span>' : '<span class="role-badge badge rounded-pill text-bg-primary my-2">Usuario</span>'}
                                </div>
                            </div>
                            <div class="user-actions">
                                <button class="btn btn-primary btn-sm" onclick="editUser(${usuario.idUser})">
                                    Modificar
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="deleteUser(${usuario.idUser})">
                                    Borrar
                                </button>
                            </div>
                        </div>
                    `);
                });
                $("#noResults").hide();
            } else {
                $("#noResults").show();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
            alert('Error en la solicitud: ' + error);
        }
    });

});

function crearUsuario() {
    let nombre = $("#createNombre").val();
    let apellidos = $("#createApellidos").val();
    let sexo = $("#createSexo").val();
    let email = $("#createEmail").val();
    let telefono = $("#createTelefono").val();
    let fechaNacimiento = $("#createFechaNacimiento").val();
    let direccion = $("#createDireccion").val();
    let usuario = $("#createUsuario").val();
    let password = $("#createPassword").val();
    let rol = $("#createRol").val(); 
    $.ajax({
        url: 'index.php?action=crear_usuario',
        type: 'POST',
        data: { 
            nombre: nombre,
            apellidos: apellidos,
            sexo: sexo,
            email: email,
            telefono: telefono,
            fecha_nacimiento: fechaNacimiento,
            direccion: direccion,
            usuario: usuario,
            password: password,
            rol: rol
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            alert('Error en la solicitud: ' + error);
        }
    });
}