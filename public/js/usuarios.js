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

function openEditModal(userId) {
    // Lógica para abrir el modal de edición
    // Puedes usar AJAX para obtener los datos del usuario y rellenar el formulario
    $.ajax({
        url: 'index.php?action=obtener_usuario',
        type: 'GET',
        data: { id: userId },
        dataType: 'json',
        success: function(response) {
                $("#editUserId").val(response.idUser);
                $("#editNombre").val(response.nombre);
                $("#editApellidos").val(response.apellidos);
                $("#editSexo").val(response.sexo);
                $("#editSexo").sele
                $("#editEmail").val(response.email);
                $("#editTelefono").val(response.telefono);
                $("#editFechaNacimiento").val(response.fecha_nacimiento);
                $("#editDireccion").val(response.direccion);
                $("#editRol").val(response.rol);
                // Abrir el modal
                $("#editUserModal").modal("show");
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            alert('Error en la solicitud: ' + error);
        }
    });
}

function actualizarUsuario() {
    let userId = $("#editUserId").val();
    let nombre = $("#editNombre").val();
    let apellidos = $("#editApellidos").val();
    let sexo = $("#editSexo").val();
    let email = $("#editEmail").val();
    let telefono = $("#editTelefono").val();
    let fechaNacimiento = $("#editFechaNacimiento").val();
    let direccion = $("#editDireccion").val();
    let rol = $("#editRol").val();

    $.ajax({
        url: 'index.php?action=editar_usuario',
        type: 'POST',
        data: {
            user_id: userId,
            nombre: nombre,
            apellidos: apellidos,
            sexo: sexo,
            email: email,
            telefono: telefono,
            fecha_nacimiento: fechaNacimiento,
            direccion: direccion,
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
            console.error('Error en la solicitud:', xhr.responseText);
            alert('Error en la solicitud: ' + error);
        }
    });
}   

function deleteUser(userId){
     if (confirm('¿Estás seguro de que deseas eliminar este usuario?')) {
        $.ajax({
            url: 'index.php?action=borrar_usuario',
            method: 'POST', 
            data: { user_id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Usuario eliminado exitosamente');
                    location.reload();
                } else {
                    alert('Error al eliminar la usuario');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', xhr.responseText);
                console.error('Error al eliminar usuario:', error);
                alert('Ocurrió un error al eliminar usuario');
            }
        });
    }
}