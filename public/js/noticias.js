$('#createNoticiaForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: 'index.php?action=crear_noticia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            // Manejar la respuesta del servidor
            if (response.success) {
                alert('Noticia creada con éxito.');
                window.location.href = 'index.php?action=noticias_admin';
            } else {
                console.log(response);
                alert(response.message || 'Error al crear la noticia.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            console.log('Respuesta del servidor:', xhr.responseText); // Para ver qué está devolviendo
            alert('Error en la solicitud: ' + error);
        }
    });
});

$('#editNoticiaForm').on('submit', function(e) {
    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
        url: 'index.php?action=editar_noticia',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                alert('Noticia editada con éxito.');
                window.location.href = 'index.php?action=noticias_admin';
            } else {
                console.log(response);
                alert(response.message || 'Error al editar la noticia.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
            alert('Error en la solicitud: ' + error);
        }
    });
});

function editarNoticia(id) {
    $.ajax({
        url: 'index.php?action=obtener_noticia',
        type: 'POST',
        data: { idNoticia: id },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Rellenar el formulario con los datos de la noticia
                $('#editTitle').val(response.data.titulo);
                $('#editContent').val(response.data.texto);
                $('#editIdNoticia').val(response.data.idNoticia);
                $('#editNoticia').modal('show');
            } else {
                alert('Error al obtener la noticia.');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud:', error);
            console.log('Respuesta del servidor:', xhr.responseText);
            alert('Error en la solicitud: ' + error);
        }
    });
}

function borrarNoticia(id) {
    if (confirm('¿Estás seguro de que deseas borrar esta noticia?')) {
        $.ajax({
            url: 'index.php?action=borrar_noticia',
            type: 'POST',
            data: { idNoticia: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert('Noticia eliminada con éxito.');
                    window.location.href = 'index.php?action=noticias_admin';
                } else {
                    console.log(response);
                    alert(response.message || 'Error al eliminar la noticia.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error en la solicitud:', error);
                console.log('Respuesta del servidor:', xhr.responseText);
                alert('Error en la solicitud: ' + error);
            }
        });
    }
}
