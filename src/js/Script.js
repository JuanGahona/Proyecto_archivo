document.addEventListener('DOMContentLoaded', function () {
    var contentFrame = document.getElementById('content-frame');
    var defaultPage = 'Seguridad/UsuarioVista.php';

    function loadPage(page) {
        contentFrame.src = page;
    }

    loadPage(defaultPage);

    document.querySelectorAll('#sidebar .nav-link[data-page]').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var page = this.getAttribute('data-page');

            // Si no se especifica una página, usar la página por defecto
            loadPage(page || defaultPage);

            // Remover la clase active de todos los enlaces y añadirla al cliqueado
            document.querySelectorAll('#sidebar .nav-link').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Opcional: Marcar como activo el enlace correspondiente a la página por defecto
    var defaultLink = document.querySelector(`#sidebar .nav-link[data-page="${defaultPage}"]`);
    if (defaultLink) {
        defaultLink.classList.add('active');
    }
});