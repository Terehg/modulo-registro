/**
 * Módulo para gestión de turnos
 */

// Inicialización del módulo
document.addEventListener('DOMContentLoaded', function() {
    // Solo inicializar si estamos en la página de turnos
    if (document.getElementById('turnosTable')) {
        initTurnosModule();
    }
});

// Función principal de inicialización
function initTurnosModule() {
    // Inicializar DataTable
    let turnosTable = $('#turnosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        columns: [
            { data: 'id' },
            { data: 'nombre' },
            { data: 'created_at' },
            { data: 'actions', orderable: false, searchable: false }
        ]
    });

    // Cargar turnos al cargar la página
    loadTurnos();

    // Event Listeners
    $('#saveTurnoBtn').click(function() {
        saveTurno();
    });

    $('#updateTurnoBtn').click(function() {
        updateTurno();
    });

    // Permitir enviar el formulario al presionar Enter
    $('#nombre').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            saveTurno();
        }
    });

    $('#edit_nombre').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            updateTurno();
        }
    });

    // Limpiar formulario al cerrar modal
    $('#createTurnoModal').on('hidden.bs.modal', function() {
        $('#createTurnoForm')[0].reset();
        $('#nombre').removeClass('is-invalid');
        $('#nombreError').text('');
    });

    $('#editTurnoModal').on('hidden.bs.modal', function() {
        $('#edit_nombre').removeClass('is-invalid');
        $('#editNombreError').text('');
    });
}

// Función para cargar turnos desde la API
function loadTurnos() {
    $.ajax({
        url: '/api/turnos',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            console.log("IMPRIMIENDO RESPONSE DEL SERVICIO GET TURNOS: ", response);
            if (response.success) {
                let turnos = response.data;
                let table = $('#turnosTable').DataTable();

                // Limpiar tabla
                table.clear();

                // Agregar datos
                turnos.forEach(function(turno) {
                    table.row.add({
                        'id': turno.id,
                        'nombre': turno.nombre,
                        'created_at': formatDate(turno.created_at),
                        'actions': `
                            <div class="action-buttons">
                                <button class="btn btn-sm btn-info edit-turno" data-id="${turno.id}" data-nombre="${turno.nombre}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-turno" data-id="${turno.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        `
                    }).draw(false);
                });

                // Agregar eventos para editar y eliminar
                $('.edit-turno').click(function() {
                    let id = $(this).data('id');
                    let nombre = $(this).data('nombre');

                    $('#edit_id').val(id);
                    $('#edit_nombre').val(nombre);

                    $('#editTurnoModal').modal('show');
                });

                $('.delete-turno').click(function() {
                    let id = $(this).data('id');
                    confirmDelete(id);
                });
            } else {
                toastr.error('Error al cargar los turnos');
            }
        },
        error: function(xhr) {
            toastr.error('Error al cargar los turnos');
            console.log(xhr);
        }
    });
}

// Función para guardar un nuevo turno
function saveTurno() {
    // Resetear errores
    $('#nombreError').text('');
    $('#nombre').removeClass('is-invalid');

    let nombre = $('#nombre').val();

    $.ajax({
        url: '/api/turnos',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            nombre: nombre
        }),
        success: function(response) {
            if (response.success) {
                // Cerrar modal y limpiar formulario
                $('#createTurnoModal').modal('hide');
                $('#createTurnoForm')[0].reset();

                // Mostrar mensaje de éxito
                toastr.success('Turno creado correctamente');

                // Recargar lista de turnos
                loadTurnos();
            }
        },
        error: function(xhr) {
            let response = xhr.responseJSON;

            if (response && response.errors) {
                if (response.errors.nombre) {
                    $('#nombre').addClass('is-invalid');
                    $('#nombreError').text(response.errors.nombre[0]);
                }
            } else {
                toastr.error('Error al crear el turno');
            }
        }
    });
}

// Función para actualizar un turno existente
function updateTurno() {
    // Resetear errores
    $('#editNombreError').text('');
    $('#edit_nombre').removeClass('is-invalid');

    let id = $('#edit_id').val();
    let nombre = $('#edit_nombre').val();

    $.ajax({
        url: `/api/turnos/${id}`,
        type: 'PUT',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            nombre: nombre
        }),
        success: function(response) {
            if (response.success) {
                // Cerrar modal
                $('#editTurnoModal').modal('hide');

                // Mostrar mensaje de éxito
                toastr.success('Turno actualizado correctamente');

                // Recargar lista de turnos
                loadTurnos();
            }
        },
        error: function(xhr) {
            let response = xhr.responseJSON;

            if (response && response.errors) {
                if (response.errors.nombre) {
                    $('#edit_nombre').addClass('is-invalid');
                    $('#editNombreError').text(response.errors.nombre[0]);
                }
            } else {
                toastr.error('Error al actualizar el turno');
                console.log("Este es el error: ", xhr.responseText);
            }
        }
    });
}

// Función para confirmar eliminación
function confirmDelete(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            deleteTurno(id);
        }
    });
}

// Función para eliminar un turno
function deleteTurno(id) {
    $.ajax({
        url: `/api/turnos/${id}`,
        type: 'DELETE',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Mostrar mensaje de éxito
                toastr.success('Turno eliminado correctamente');

                // Recargar lista de turnos
                loadTurnos();
            }
        },
        error: function(xhr) {
            toastr.error('Error al eliminar el turno');
            console.log(xhr);
        }
    });
}

// Función para formatear fecha
function formatDate(dateString) {
    if (!dateString) return '';

    const date = new Date(dateString);
    return date.toLocaleString('es-ES', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Exportar funciones para uso global
window.loadTurnos = loadTurnos;
window.saveTurno = saveTurno;
window.updateTurno = updateTurno;
window.confirmDelete = confirmDelete;
window.deleteTurno = deleteTurno;
window.formatDate = formatDate;