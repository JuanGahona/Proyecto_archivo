<?php
    require_once '../src/libreria/cabezal.php';
?>

<div class="wrapper">
    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="sidebar-header">
            <h4>Dashboard</h4>
        </div>
        <hr class="hr-thick">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link active" href="#">
                    <i class="bi bi-house-door"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuUsuarios" role="button" aria-expanded="false">
                    <i class="bi bi-people"></i> Usuarios <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="menuUsuarios">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-page="seguridad/UsuarioVista.php">Lista de Usuarios</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#menuProductos" role="button" aria-expanded="false">
                    <i class="bi bi-box-seam"></i> Inventario <i class="bi bi-chevron-down"></i>
                </a>
                <div class="collapse" id="menuProductos">
                    <ul class="nav flex-column ms-3">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Lista archivos</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Contenido de la página -->
    <div id="content">
        <iframe id="content-frame" title="Contenido principal"></iframe>
    </div>
    
</div>

<?php
require_once '../src/libreria/piedepagina.php';
?>