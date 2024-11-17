<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
    <style>
        .table-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table {
            background-color: white;
        }
        .table th {
            background-color: #2c3e50;
            color: white;
            border-color: #2c3e50;
        }
        .table td {
            border-color: #dee2e6;
            vertical-align: middle;
        }
        .btn-editar {
            background-color: #ffc107;
            color: black;
            margin-right: 5px;
        }
        .btn-eliminar {
            background-color: #dc3545;
            color: white;
        }
        .main-title {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2c3e50;
        }
        .btn-agregar {
            background-color: #2c3e50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .btn-agregar:hover {
            background-color: #3498db;
            color: white;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-container">
                        <h2 class="main-title">Gestión de Planillas - Empleados</h2>
                        
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#modalAgregarEmpleado">
                            Agregar Empleado
                        </button>
                        
                        <!-- Tabla de empleados -->
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Teléfono</th>
                                            <th>Tipo</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Se llenará dinámicamente con JavaScript -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Empleado -->
    <div class="modal fade" id="modalAgregarEmpleado" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Nuevo Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarEmpleado">
                        <div class="mb-3">
                            <label for="agregar-nombre-empleado" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="agregar-nombre-empleado" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="agregar-correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="agregar-telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-tipo-empleado" class="form-label">Tipo de Empleado</label>
                            <select class="form-control" id="agregar-tipo-empleado" required>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarNuevoEmpleado()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Editar Empleado -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formEditar">
                        <input type="hidden" id="editar-id-empleado">
                        <div class="mb-3">
                            <label for="editar-nombre-empleado" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="editar-nombre-empleado" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="editar-correo" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="editar-telefono" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-tipo-empleado" class="form-label">Tipo de Empleado</label>
                            <select class="form-control" id="editar-tipo-empleado" required>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarCambiosEmpleado()">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Eliminar Empleado -->
    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Eliminación</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>¿Está seguro que desea eliminar este empleado?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/empleados.js"></script>
</body>
</html>