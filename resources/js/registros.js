/**
 * Módulo para gestión de registros de producción
 */

// Variables globales
let turnosMap = {}; // Para mapear IDs de turnos a nombres
let registrosTable; // Referencia a la tabla DataTable

// Inicialización del módulo
document.addEventListener('DOMContentLoaded', function() {
    // Solo inicializar si estamos en la página de registros
    if (document.getElementById('registrosTable')) {
        initRegistrosModule();
    }
});

// Función principal de inicialización
function initRegistrosModule() {
    // Inicializar DataTable
    registrosTable = $('#registrosTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        },
        columns: [
            { data: 'id' },
            { data: 'maquina' },
            { data: 'proyecto' },
            { data: 'turno' },
            { data: 'created_at' },
        ]
    });

    // Cargar turnos para el selector y filtro
    loadTurnos();

    // Cargar registros al cargar la página
    loadRegistros();

    // Guardar nuevo registro
    $('#saveRegistroBtn').click(function() {
        saveRegistro();
    });

    // Aplicar filtro por turno
    $('#applyFilterBtn').click(function() {
        loadRegistros($('#filter_turno').val());
    });

    // Limpiar filtro
    $('#clearFilterBtn').click(function() {
        $('#filter_turno').val('');
        loadRegistros();
    });

    // Permitir enviar el formulario al presionar Enter
    $('#createRegistroForm input, #createRegistroForm select').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            saveRegistro();
        }
    });

    $('#editRegistroForm input, #editRegistroForm select').keypress(function(e) {
        if (e.which === 13) {
            e.preventDefault();
            updateRegistro();
        }
    });

    // Limpiar formulario al cerrar modal
    $('#createRegistroModal').on('hidden.bs.modal', function() {
        $('#createRegistroForm')[0].reset();
        $('#maquina, #proyecto, #turno_id').removeClass('is-invalid');
        $('#maquinaError, #proyectoError, #turnoError').text('');
    });

    $('#editRegistroModal').on('hidden.bs.modal', function() {
        $('#edit_maquina, #edit_proyecto, #edit_turno_id').removeClass('is-invalid');
        $('#editMaquinaError, #editProyectoError, #editTurnoError').text('');
    });
}

// Función para cargar turnos desde la API
function loadTurnos() {
    $.ajax({
        url: '/api/turnos',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let turnos = response.data;
                let optionsHtml = '<option value="">Seleccione un turno</option>';
                let filterOptionsHtml = '<option value="">Todos los turnos</option>';

                // Crear opciones para los selectores y mapear IDs a nombres
                turnos.forEach(function(turno) {
                    optionsHtml += `<option value="${turno.id}">${turno.nombre}</option>`;
                    filterOptionsHtml += `<option value="${turno.id}">${turno.nombre}</option>`;
                    turnosMap[turno.id] = turno.nombre;
                });

                // Actualizar selectores
                $('#turno_id').html(optionsHtml);
                $('#edit_turno_id').html(optionsHtml);
                $('#filter_turno').html(filterOptionsHtml);
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

// Función para cargar registros desde la API con filtro opcional
function loadRegistros(turnoId = null) {
    // Construir URL con filtro si es necesario
    console.log('loadRegistros() se está ejecutando');
    let url = '/api/registros';
    if (turnoId) {
        url += `?turno_id=${turnoId}`;
    }

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                let registros = response.data;

                // Limpiar tabla
                registrosTable.clear();

                // Agregar datos
                registros.forEach(function(registro) {
                    // Obtener nombre del turno del mapa
                    let turnoNombre = turnosMap[registro.turno_id] || 'Desconocido';

                    registrosTable.row.add({
                        'id': registro.id,
                        'maquina': registro.maquina,
                        'proyecto': registro.proyecto,
                        'turno': turnoNombre,
                        'created_at': formatDate(registro.created_at),

                    }).draw(false);
                });


            } else {
                toastr.error('Error al cargar los registros');
            }
        },
        error: function(xhr) {
            toastr.error('Error al cargar los registros');
            console.log(xhr);
        }
    });
}

// Función para guardar un nuevo registro
function saveRegistro() {
    // Resetear errores
    $('#maquinaError, #proyectoError, #turnoError').text('');
    $('#maquina, #proyecto, #turno_id').removeClass('is-invalid');

    // Obtener valores del formulario
    let maquina = $('#maquina').val();
    let proyecto = $('#proyecto').val();
    let turno_id = $('#turno_id').val();

    // Validar campos
    let isValid = true;

    if (!maquina) {
        $('#maquina').addClass('is-invalid');
        $('#maquinaError').text('El campo máquina es obligatorio');
        isValid = false;
    }

    if (!proyecto) {
        $('#proyecto').addClass('is-invalid');
        $('#proyectoError').text('El campo proyecto es obligatorio');
        isValid = false;
    }

    if (!turno_id) {
        $('#turno_id').addClass('is-invalid');
        $('#turnoError').text('Debe seleccionar un turno');
        isValid = false;
    }

    if (!isValid) return;

    // Enviar datos al servidor
    $.ajax({
        url: '/api/registros',
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify({
            maquina: maquina,
            proyecto: proyecto,
            turno_id: turno_id
        }),
        success: function(response) {
            if (response.success) {
                // Cerrar modal y limpiar formulario
                $('#createRegistroModal').modal('hide');
                $('#createRegistroForm')[0].reset();

                // Mostrar mensaje de éxito
                toastr.success('Registro creado correctamente');

                // Recargar lista de registros
                loadRegistros($('#filter_turno').val());
            } else {
                toastr.error('Error al crear el registro');
            }
        },
        error: function(xhr) {
            let response = xhr.responseJSON;

            if (response && response.errors) {
                if (response.errors.maquina) {
                    $('#maquina').addClass('is-invalid');
                    $('#maquinaError').text(response.errors.maquina[0]);
                }

                if (response.errors.proyecto) {
                    $('#proyecto').addClass('is-invalid');
                    $('#proyectoError').text(response.errors.proyecto[0]);
                }

                if (response.errors.turno_id) {
                    $('#turno_id').addClass('is-invalid');
                    $('#turnoError').text(response.errors.turno_id[0]);
                }
            } else {
                toastr.error('Error al crear el registro');
            }
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
window.loadRegistros = loadRegistros;
window.saveRegistro = saveRegistro;
window.formatDate = formatDate;
