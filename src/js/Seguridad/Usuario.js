CargarTablaUsuario();

function CargarTablaUsuario() {
    $(document).ready(function() {
        $.ajax({
            url: '../../Controlador/Seguridad/UsuarioControlador.php?action=ObtenerUsuarios', // Cambia a la ruta correcta
            method: 'GET',
            dataType: 'json',
            success: function(response) {
    
                // Destruir el DataTable si ya está inicializado para evitar errores
                if ($.fn.DataTable.isDataTable('#tableUsuario')) {
                    $('#tableUsuario').DataTable().clear().destroy();
                }
                // Inicializar el DataTable con los datos obtenidos
                $('#tableUsuario').DataTable({
                    data: response.data,
                    autoWidth: false,
                    select: true,
                    columns: [
                        { data: 'usuarios', title: 'Usuario' },
                        { data: 'nombres', title: 'Nombre' },
                        { data: 'email', title: 'Email' },
                        { data: 'sucursal', title: 'Sucursal', className: 'text-center' },
                        { data: 'rol.nombre', title: 'Rol' },
                        {
                            title: 'Acciones',
                            data: null,
                            render: function(data, type, row) {
                                return `
                                <div class="btn-vertical">
                                    <button class="btn btn-primary btn-sm btn-action btn-edit" data-id="${row.id}">
                                        <i class="bi bi-person-fill-gear"></i>
                                    </button>
                                    <button class="btn btn-danger btn-sm btn-action btn-delete" data-id="${row.id}">
                                        <i class="bi bi-person-dash-fill"></i>
                                    </button>
                                    <button onclick="Auditoria(${row.id})" class="btn btn-warning btn-sm btn-action btn-file" title="Auditoria">
                                        <i class="bi bi-info-circle-fill"></i>
                                    </button>
                                </div>
                                `;
                            }
                        }
                    ],
                    initComplete: function() {
                        var api = this.api();
            
                        // Para cada columna, se agrega un input debajo del título
                        api.columns().every(function() {
                            var column = this;
                            var title = $(column.header()).text(); 
            
                            // Agregar el título y el input dentro del header
                            $(column.header()).html(`
                                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <span style="margin-bottom: 0.5rem;">${title}</span> 
                                    <input type="text" placeholder="Buscar" style="width: 100%; padding: 0.3rem 0.5rem; box-sizing: border-box; border-radius: 20px; border: 1px solid #ccc; outline: none; font-size: 0.9rem;" />
                                </div>
                            `);
            
                            // Configurar el filtro de búsqueda
                            $(column.header()).find('input').on('keyup change', function() {
                                column.search($(this).val()).draw();
                            });
                        });
                    },
                    autoFill: true,
                    pageLength: 10,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                    }
                });
    
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
                        popup: 'custom-toast-popup',
                        title: 'custom-toast-title',
                        content: 'custom-toast-content',
                        icon: 'custom-toast-icon'
                    }
                });

                CargarRoles();
            },
            error: function(jqXHR, textStatus, errorThrown) {
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

function CrearUsuario() {
    $(document).ready(function() {
        const usuario = document.getElementById('usuario').value;
        const contrasena = document.getElementById('contrasena').value;
        const nombres = document.getElementById('nombres').value;
        const email = document.getElementById('email').value;
        const sucursal = document.getElementById('sucursal').value;
        const rol_id = document.getElementById('rol').value;

        // Datos del nuevo usuario
        const usuarioData = {
            usuario: usuario,
            contrasena: contrasena,
            nombres: nombres,
            email: email,
            sucursal: sucursal,
            rol_id: rol_id,
            estado: 'Activo',
            creado_por: 'JSCABRERAS'
        };

        $.ajax({
            url: '../../Controlador/Seguridad/UsuarioControlador.php?action=CrearUsuario',
            method: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(usuarioData),
            dataType: 'json',
            success: function(response) {
                // Cargar tabla de usuarios (si es necesario)
                CargarTablaUsuario();

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
            error: function(jqXHR, textStatus, errorThrown) {
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

function Auditoria(id) {
    $.ajax({
        url: '../../Controlador/Seguridad/UsuarioControlador.php?action=Auditoria&id=' + id,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            // Aquí puedes manejar la respuesta del servidor
            console.log('Respuesta del servidor:', response);
        
            // Asumiendo que response.data contiene el objeto con datos válidos
            var usuarioData = response.data;
        
            const modalContent = `
                <div class="modal fade" id="auditModal" tabindex="-1" aria-labelledby="auditModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="auditModalLabel">Detalles de Auditoría</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="usuarioInput" class="form-label"><strong>Usuario:</strong></label>
                                    <input type="text" class="form-control" id="usuarioInput" value="${usuarioData.usuario}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="creadoPorInput" class="form-label"><strong>Creado por:</strong></label>
                                    <input type="text" class="form-control" id="creadoPorInput" value="${usuarioData.creado_por}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="fechaCreacionInput" class="form-label"><strong>Fecha de creación:</strong></label>
                                    <input type="text" class="form-control" id="fechaCreacionInput" value="${usuarioData.fecha_creacion}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="actualizadoPorInput" class="form-label"><strong>Actualizado por:</strong></label>
                                    <input type="text" class="form-control" id="actualizadoPorInput" value="${usuarioData.actualizado_por}" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="fechaActualizacionInput" class="form-label"><strong>Fecha de actualización:</strong></label>
                                    <input type="text" class="form-control" id="fechaActualizacionInput" value="${usuarioData.fecha_actualizacion}" readonly>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
        
            // Insertar la modal en el body
            document.body.insertAdjacentHTML('beforeend', modalContent);
        
            // Mostrar la modal
            var auditModal = new bootstrap.Modal(document.getElementById('auditModal'));
            auditModal.show();
        
            // Remover la modal del DOM cuando se oculta
            document.getElementById('auditModal').addEventListener('hidden.bs.modal', function (event) {
                document.getElementById('auditModal').remove();
            });
        },
        error: function(jqXHR, textStatus, errorThrown) {
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

function CargarRoles(){
    $.ajax({
        url: '../../Controlador/Seguridad/UsuarioControlador.php?action=ObtenerRoles',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            const $rolSelect = $('#rol');
            $rolSelect.empty(); 
            // Agregar la opción por defecto
            $rolSelect.append('<option value="">-- Seleccionar Rol --</option>');
            // Llenar el select con los roles
            $.each(response.data, function(index, rol) {
                $rolSelect.append(`<option value="${rol.id}">${rol.nombre}</option>`);
            });
           
        },
        error: function(xhr, status, error) {
            console.error('Error en la solicitud AJAX:', status, error);
        }
    });
}