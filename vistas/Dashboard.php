<?php
require_once '../src/libreria/cabezal.php';
?>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#" data-page="Inicio.php">
                        <i class="bi bi-house-door"></i> Inicio
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarUsuarios" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-people"></i> Usuarios
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarUsuarios">
                        <li><a class="dropdown-item" href="#" data-page="Seguridad/UsuarioVista.php">Lista de
                                Usuarios</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarProductos" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-box-seam"></i> Inventario
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarProductos">
                        <li><a class="dropdown-item" href="#" data-page="Inventario/InventarioArchivo.php">Lista
                                archivos</a></li>
                    </ul>
                </li>
            </ul>
            <div class="ms-auto d-flex align-items-center">
                <span id="navbar-username" class="navbar-username"></span>
                <i class="bi bi-person-circle icon-large"></i>
            </div>
        </div>
    </div>
</nav>

<!-- Contenido de la página -->
<div id="content">
    <iframe id="content-frame" title="Contenido principal"></iframe>
</div>


<?php
require_once '../src/libreria/piedepagina.php';
?>