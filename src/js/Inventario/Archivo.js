CargarTablaArchivo();

function CargarTablaArchivo() {

    var table = $('#tableArchivos');
    if ($.fn.DataTable.isDataTable(table)) {
        table.DataTable().clear().destroy();
    }
    table.empty(); 

    $.ajax({
        url: '../../Controlador/Inventario/InventarioArchivoControlador.php?action=ObtenerArchivos',
        method: 'GET',
        dataType: 'json',
        success: function (response) {

            // Formatear fechas si es necesario
            response.data.forEach(function (archivo) {
                archivo.fecha_creacion = formatDate(archivo.fecha_creacion);
                archivo.fecha_modificacion = formatDate(archivo.fecha_modificacion);
            });

            // Crear la tabla DataTable
            $('#tableArchivos').DataTable({
                data: response.data,
                autoWidth: false,
                select: true,
                columns: [
                    { data: 'numero_identificacion', title: 'N° Paciente', className: 'text-center' },
                    { data: 'nombre_paciente', title: 'Nombre de paciente', className: 'nombre-paciente' },
                    { data: 'fecha_creacion', title: 'Fecha creación', className: 'text-center' },
                    {
                        data: 'folio',
                        title: 'N° Folio',
                        className: 'text-center',
                        render: function (data) {
                            return data + " Folio";
                        }
                    },
                    {
                        data: 'tomo',
                        title: 'N° Tomo',
                        className: 'text-center',
                        render: function (data) {
                            return data + " Tomo";
                        }
                    },
                    {
                        data: 'fila',
                        title: 'N° Fila',
                        className: 'text-center',
                        render: function (data) {
                            return data + " Fila";
                        }
                    },
                    {
                        data: 'estanteria',
                        title: 'N° Estantería',
                        className: 'text-center',
                        render: function (data) {
                            return data + " Estantería";
                        }
                    },
                    {
                        data: 'archivero',
                        title: 'N° Archivero',
                        className: 'text-center',
                        render: function (data) {
                            return data + " Archivero";
                        }
                    },
                    {
                        data: 'observacion',
                        title: 'Observaciones',
                        className: 'observacion',
                        render: function (data) {
                            var texto = data ? data : 'Sin observaciones';
                            return `<a href="#" class="observacion-link" data-observacion="${texto}">${texto}</a>`;
                        }
                    },
                    {
                        title: 'Acciones',
                        data: null,
                        render: function (data, type, row) {
                            return `
                                <div class="btn-vertical">
                                    <button class="btn btn-primary btn-sm btn-action btn-edit" data-id="${row.id}" title="Editar registro">
                                        <i class="bi bi-person-fill-gear"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-action btn-delete" data-id="${row.id}" title="Eliminar registro">
                                        <i class="bi bi-person-dash-fill"></i>
                                    </button>
                                    <button class="btn btn-warning btn-sm btn-action btn-file" data-id="${row.id}" title="Ver archivos">
                                        <i class="bi bi-archive-fill"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                initComplete: function () {
                    var api = this.api();

                    // Agregar una fila para los inputs de búsqueda
                    $('#tableArchivos thead').append('<tr class="search-row"></tr>');
                    api.columns().every(function () {
                        var column = this;
                        var title = $(column.header()).text();
                        var searchInput = $('<input type="text" placeholder="Buscar" style="width: 100%; padding: 0.3rem 0.5rem; box-sizing: border-box; border-radius: 20px; border: 1px solid #ccc; outline: none; font-size: 0.9rem;" />');

                        // Añadir los inputs de búsqueda en la nueva fila
                        $('.search-row').append($('<th>').append(searchInput));

                        // Manejar el evento de búsqueda
                        $(searchInput).on('keyup change', function () {
                            if (column.search() !== this.value) {
                                column.search(this.value).draw();
                            }
                        });
                    });
                },
                autoFill: true,
                pageLength: 10,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                }
            });

            ConfigurarEventosTabla();

            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: response.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInRight'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutRight'
                },
                customClass: {
                    container: 'custom-toast-container',
                    popup: 'custom-toast-popup',
                    title: 'custom-toast-title',
                    content: 'custom-toast-content',
                    icon: 'custom-toast-icon'
                }
            });
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX: ' + textStatus);
            Swal.fire({
                icon: 'error',
                text: 'Error en la solicitud AJAX: ' + textStatus,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}

function BuscarPaciente() {

    const NumeroIdentificaicon = document.getElementById('numero_identificacion').value;

    $.ajax({
        url: '../../Controlador/Inventario/InventarioArchivoControlador.php?action=BuscarPaciente&numeroIndentificacion=' + NumeroIdentificaicon,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.data.length > 0) {

                const paciente = response.data[0];

                const fechaCreacion = new Date(paciente.fecha_creacion);
                const fechaFormato = fechaCreacion.toISOString().split('T')[0];


                // Se crea la Funcion para validar el campo
                validarCampos('#nombre_paciente', paciente.nombre_paciente);
                validarCampos('#fecha_creacion', fechaFormato);
                validarCampos('#folio', paciente.folio);
                validarCampos('#tomo', paciente.tomo);
                validarCampos('#fila', paciente.fila);
                validarCampos('#estanteria', paciente.estanteria);
                validarCampos('#archivero', paciente.archivero);
                validarCampos('#observacion', paciente.observacion);

                Swal.fire({
                    icon: 'warning',
                    title: '¡Advertencia!',
                    text: response.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutRight'
                    },
                    customClass: {
                        container: 'custom-toast-container',
                        popup: 'custom-toast-popup-warning',
                        title: 'custom-toast-title',
                        content: 'custom-toast-content',
                        icon: 'custom-toast-icon-warning'
                    }
                });
            } else {
                console.warn('No se encontraron datos para el paciente.');

                Swal.fire({
                    icon: 'warning',
                    title: 'Paciente no encontrado',
                    text: 'No se encontraron datos para el paciente. ¿Desea crear uno nuevo?',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, crear',
                    cancelButtonText: 'No, cancelar',
                }).then((result) => {
                    if (result.isConfirmed) {

                        limpiar();

                        $('#nombre_paciente').prop('disabled', false);
                        $('#fecha_creacion').prop('disabled', false);
                        $('#folio').prop('disabled', false);
                        $('#tomo').prop('disabled', false);
                        $('#fila').prop('disabled', false);
                        $('#estanteria').prop('disabled', false);
                        $('#archivero').prop('disabled', false);
                        $('#observacion').prop('disabled', false);

                    } else {
                        limpiar();
                    }
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error('Error en la solicitud AJAX: ' + textStatus);
            Swal.fire({
                icon: 'error',
                text: 'Error en la solicitud AJAX: ' + textStatus,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    });
}

function CrearArchivo() {
    $(document).ready(function () {

        // Crear una instancia de FormData
        const formData = new FormData();

        const numero_identificacion = document.getElementById('numero_identificacion').value;
        const nombre_paciente = document.getElementById('nombre_paciente').value;
        const folio = document.getElementById('folio').value;
        const tomo = document.getElementById('tomo').value;
        const fila = document.getElementById('fila').value;
        const estanteria = document.getElementById('estanteria').value;
        const archivero = document.getElementById('archivero').value;
        const observacion = document.getElementById('observacion').value;

        // Tomar el archivo seleccionado por el usuario
        const archivo = document.getElementById('nombre_archivo').files[0];

        // Agregar todos los campos al FormData
        formData.append('numero_identificacion', numero_identificacion);
        formData.append('nombre_paciente', nombre_paciente);
        formData.append('folio', folio);
        formData.append('tomo', tomo);
        formData.append('fila', fila);
        formData.append('estanteria', estanteria);
        formData.append('archivero', archivero);
        formData.append('observacion', observacion);
        formData.append('usuario_id', 2);
        formData.append('archivo', archivo);

        $.ajax({
            url: '../../Controlador/Inventario/InventarioArchivoControlador.php?action=CrearArchivo',
            method: 'POST',
            data: formData,
            processData: false, // Evita que jQuery procese los datos (necesario para FormData)
            contentType: false, // Evita que jQuery establezca el Content-Type (necesario para FormData)
            success: function (response) {

                // Cargar la tabla de archivos después de vaciar y destruir la anterior
                CargarTablaArchivo();

                // Cerrar la modal
                $('#staticBackdrop').modal('hide');

                // Mostrar mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.message,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInRight'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__fadeOutRight'
                    },
                    customClass: {
                        container: 'custom-toast-container',
                        popup: 'custom-toast-popup',
                        title: 'custom-toast-title',
                        content: 'custom-toast-content',
                        icon: 'custom-toast-icon'
                    }
                });
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error en la solicitud AJAX: ' + textStatus);
                Swal.fire({
                    icon: 'error',
                    text: 'Error en la solicitud AJAX: ' + textStatus,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    });
}

function ConfigurarEventosTabla() {
    $('#tableArchivos tbody').on('click', 'a.observacion-link', function (event) {
        event.preventDefault(); // Evita el comportamiento por defecto del enlace
        var observacion = $(this).data('observacion') || 'Sin observaciones';

        // Actualizar el contenido del modal
        $('#modalObservacion .modal-body').text(observacion);

        // Mostrar el modal usando Bootstrap 5
        var modalElement = document.getElementById('modalObservacion');
        var modal = new bootstrap.Modal(modalElement);
        modal.show();
    });
}

function CrearModalObservacion() {
    if ($('#modalObservacion').length === 0) {
        var modalHtml = `
            <!-- Modal -->
            <div class="modal fade" id="modalObservacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Observaciones</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            ...
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        $('body').append(modalHtml);
    }
}

function formatDate(dateString) {
    if (dateString) {
        const date = new Date(dateString);

        // Extraer el día, mes y año
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();

        // Formatear la fecha en el formato deseado: dd/mm/yyyy
        return `${day}/${month}/${year}`;
    }
    return '';
}

function validarCampos(contenido, valorCampo) {
    if (!$(contenido).prop('disabled')) {
        $(contenido).prop('disabled', true);
    }
    $(contenido).val(valorCampo);
}

function limpiarCampos() {
    $('#numero_identificacion').val('');
    $('#nombre_paciente').val('');
    $('#fecha_creacion').val('');
    $('#folio').val('');
    $('#tomo').val('');
    $('#fila').val('');
    $('#estanteria').val('');
    $('#archivero').val('');
    $('#observacion').val('');
}

function limpiar() {
    $('#nombre_paciente').val('');
    $('#fecha_creacion').val('');
    $('#folio').val('');
    $('#tomo').val('');
    $('#fila').val('');
    $('#estanteria').val('');
    $('#archivero').val('');
    $('#observacion').val('');
}