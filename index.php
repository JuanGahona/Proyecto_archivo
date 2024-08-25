<?php
    require_once 'src/libreria/cabezal.php';
?>

<link rel="stylesheet" href="src/css/login.css">

<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="login-container animate__animated animate__fadeInDown">
        <div class="login-header">
            <div class="file-icon animate__animated animate__bounceIn">
                <i class="bi bi-folder-fill"></i> <!-- Icono de carpeta -->
            </div>
            <h1 class="gradient-text">Clinica Medilaser</h1>
            <p class="gradient-text">Gestión de Historias Clínicas</p>
        </div>
        <form>
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" class="form-control" id="usuario" placeholder="Ingrese su usuario">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" placeholder="Ingrese su contraseña">
            </div>
            <div class="d-grid">
                <button type="submit" class="btn btn-login">Ingresar</button>
            </div>
        </form>
        <div class="login-footer">
            <p>&copy; 2024 Medilaser</p>
        </div>
    </div>
</div>



<?php
    require_once 'src/libreria/piedepagina.php';
?>