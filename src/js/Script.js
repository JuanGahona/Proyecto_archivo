document.addEventListener('DOMContentLoaded', function () {
    var contentFrame = document.getElementById('content-frame');
    var defaultPage = 'Inventario/InventarioArchivo.php';

    function loadPage(page) {
        contentFrame.src = page;
    }

    // Cargar la página por defecto al iniciar
    loadPage(defaultPage);

    // Añadir el evento a los enlaces del navbar
    document.querySelectorAll('.nav-link[data-page], .dropdown-item[data-page]').forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            var page = this.getAttribute('data-page');

            // Si no se especifica una página, usar la página por defecto
            loadPage(page || defaultPage);

            // Remover la clase active de todos los enlaces y añadirla al cliqueado
            document.querySelectorAll('.nav-link').forEach(el => el.classList.remove('active'));
            document.querySelectorAll('.dropdown-item').forEach(el => el.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Opcional: Marcar como activo el enlace correspondiente a la página por defecto
    var defaultLink = document.querySelector(`.nav-link[data-page="${defaultPage}"]`);
    if (defaultLink) {
        defaultLink.classList.add('active');
    }
});

let username = getCookie('username');

document.getElementById('navbar-username').textContent = username || 'Usuario'; // Muestra 'Usuario' si la cookie no está definida

// Función para obtener el valor de una cookie por su nombre
function getCookie(name) {
    let value = "; " + document.cookie;
    let parts = value.split("; " + name + "=");
    if (parts.length === 2) return parts.pop().split(";").shift();
}

document.getElementById('logoutButton').addEventListener('click', function() {
    // Aquí puedes hacer la llamada para cerrar la sesión
    // Por ejemplo, eliminando la cookie y redirigiendo al login
    document.cookie = "username=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    window.location.href = 'login.html'; // Redirige al usuario a la página de login
});