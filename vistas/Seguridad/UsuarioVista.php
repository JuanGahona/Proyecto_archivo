<?php
require_once '../../src/libreria/cabezal.php';
?>
<link rel="stylesheet" href="../../src/css/EstilosGlobales.css">

<div class="full-height-container">

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h2>Lista de Usuarios</h2>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-person-fill-add"></i> Crear usuario
                </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear Usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td><label for="usuario">Usuario<span
                                            style="color: red; font-size: 1.2rem;">*</span>:</label></td>
                                <td><input type="text" id="usuario" class="form-control"></td>
                                <td><label for="contrasena">Contraseña<span
                                            style="color: red; font-size: 1.2rem;">*</span>:</label></td>
                                <td><input type="password" id="contrasena" class="form-control"></td>
                            </tr>
                            <tr>
                                <td><label for="nombre">Nombre<span
                                            style="color: red; font-size: 1.2rem;">*</span>:</label></td>
                                <td><input type="text" id="nombres" class="form-control" required></td>
                                <td><label for="email">Email<span
                                            style="color: red; font-size: 1.2rem;">*</span>:</label></td>
                                <td>
                                    <div class="input-group">
                                        <input type="text" id="email" class="form-control" placeholder="nombre"
                                            aria-label="Nombre" required>
                                        <span class="input-group-text">@medilaser.com.co</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><label for="rol">Rol<span style="color: red; font-size: 1.2rem;">*</span>:</label>
                                </td>
                                <td>
                                    <select id="rol" class="form-select">
                                        <!-- Se crea dinamicamente -->
                                    </select>
                                </td>
                                <td><label for="sucursal">Sucursal<span style="color: red; font-size: 1.2rem;">*</span>:</label></td>
                                <td>
                                    <select id="sucursal" class="form-select">
                                        <option value="0">-- Seleccionar Sucursal --</option>
                                        <option value="Neiva">Medilaser Neiva</option>
                                        <option value="Abner Lozano">Medilaser Abner Lozano</option>
                                        <option value="Tunja">Medilaser Tunja</option>
                                        <option value="Florencia">Medilaser Florencia</option>
                                        <option value="Pitalito">Medilaser Pitalito</option>
                                        <option value="Medifaca">Medilaser Medifaca</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="CrearUsuario();">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Usuario -->

    <div class="table-responsive">
        <table id="tableUsuario" class="table table-bordered table-striped display nowrap" style="width:100%">
            <!-- Se crea dinamicamente tabla usuario-->
        </table>
    </div>
</div>

<script src="../../src/js/seguridad/Usuario.js"></script>
<?php
require_once '../../src/libreria/piedepagina.php';
?>