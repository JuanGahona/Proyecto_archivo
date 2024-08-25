<?php
require_once '../../src/libreria/cabezal.php';
?>
<link rel="stylesheet" href="../../src/css/EstilosGlobales.css">
<link rel="stylesheet" href="../../src/css/Inventario/ArchivoEstilo.css">

<div class="full-height-container">

    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col">
                <h2>Lista de Archivos</h2>
            </div>
        </div>
    </div>


    <div class="container-fluid">
        <div class="row">
            <div class="col-auto">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-person-fill-add"></i> Crear archivo
                </button>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Crear archivo</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td><label for="numero_identificacion">N° Paciente</label></td>
                                <td><input type="text" id="numero_identificacion" class="form-control" onkeydown="if(event.keyCode === 13) BuscarPaciente();"></td>
                                <td><label for="nombre_paciente">Nombre de paciente</label></td>
                                <td><input type="text" id="nombre_paciente" class="form-control" disabled></td>
                            </tr>
                            <tr>
                                <td><label for="fecha_creacion">Fecha creación</label></td>
                                <td><input type="date" id="fecha_creacion" class="form-control" disabled></td>
                                <td><label for="folio">N° Folio</label></td>
                                <td><input type="number" id="folio" class="form-control" placeholder="Folio" disabled></td>
                            </tr>
                            <tr>
                                <td><label for="tomo">N° Tomo</label></td>
                                <td><input type="number" id="tomo" class="form-control" placeholder="Tomo" disabled></td>
                                <td><label for="fila">N° Fila</label></td>
                                <td><input type="number" id="fila" class="form-control" placeholder="Fila" disabled></td>
                            </tr>
                            <tr>
                                <td><label for="estanteria">N° estanteria</label></td>
                                <td><input type="number" id="estanteria" class="form-control" placeholder="Estanteria" disabled></td>
                                <td><label for="archivero">N° archivero</label></td>
                                <td><input type="number" id="archivero" class="form-control" placeholder="Archivero" disabled></td>
                            </tr>
                            <tr class="col-2">
                                <td><label for="observacion">Observaciones</label></td>
                                <td><textarea id="observacion" class="form-control" placeholder="Sin observaciones" style="width: 100%;" disabled></textarea></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="crearArchivo();">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla Archivo -->

    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
        <table id="tableArchivos" class="table table-bordered table-striped display nowrap" style="width:100%">
            <!-- Se crea dinámicamente la tabla -->
        </table>
    </div>
</div>

<script src="../../src/js/Inventario/Archivo.js"></script>
<?php
require_once '../../src/libreria/piedepagina.php';
?>