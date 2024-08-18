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
                    columns: [
                        { data: 'id', title: 'Codigo' },
                        { data: 'usuarios', title: 'Usuario' },
                        { data: 'nombres', title: 'Nombre' },
                        { data: 'email', title: 'Email' },
                        { data: 'sucursal', title: 'Sucursal' },
                        { data: 'rol.nombre', title: 'Rol' },
                        { data: 'estado', title: 'Estado' },
                        { data: 'created_at', title: 'Fecha Creacion' },
                        { data: 'updated_at', title: 'Fecha Actualizado' },
                        
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
                                    </div>
                                `;
                            }
                        }
                    ],
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