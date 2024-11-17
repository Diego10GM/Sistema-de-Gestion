<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Planillas - Empleados</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <!-- Incluir el menú -->
    <?php include '../menu.php'; ?>

    <!-- Contenido principal del CRUD de empleados -->
    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <h2>Gestión de Planillas - Empleados</h2>

        <!-- Botón para agregar empleado -->
        <button class="btn btn-primary mb-3" onclick="mostrarModalAgregar()">Agregar Empleado</button>

        <!-- Tabla de empleados -->
        <table class="table table-bordered table-striped" id="tabla-empleados">
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
                <!-- Datos cargados dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Modal de agregar empleado -->
    <div class="modal fade" id="modalAgregar" tabindex="-1" aria-labelledby="modalAgregarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarLabel">Agregar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-agregar">
                        <div class="mb-3">
                            <label for="agregar-nombre-empleado" class="form-label">Nombre:</label>
                            <input type="text" id="agregar-nombre-empleado" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-correo" class="form-label">Correo:</label>
                            <input type="email" id="agregar-correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-telefono" class="form-label">Teléfono:</label>
                            <input type="text" id="agregar-telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-tipo-empleado" class="form-label">Tipo de Empleado:</label>
                            <select id="agregar-tipo-empleado" class="form-select" required>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarNuevoEmpleado()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de edición de empleado -->
    <div class="modal fade" id="modalEditar" tabindex="-1" aria-labelledby="modalEditarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarLabel">Editar Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-editar">
                        <input type="hidden" id="editar-id-empleado">
                        <div class="mb-3">
                            <label for="editar-nombre-empleado" class="form-label">Nombre:</label>
                            <input type="text" id="editar-nombre-empleado" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-correo" class="form-label">Correo:</label>
                            <input type="email" id="editar-correo" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-telefono" class="form-label">Teléfono:</label>
                            <input type="text" id="editar-telefono" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-tipo-empleado" class="form-label">Tipo de Empleado:</label>
                            <select id="editar-tipo-empleado" class="form-select" required>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarCambiosEmpleado()">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de confirmación de eliminación -->
<div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEliminarLabel">Confirmar Eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Estás seguro de que deseas eliminar este empleado?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <!-- Este es el botón con el ID -->
                <button type="button" class="btn btn-danger" id="btnConfirmarEliminar">Sí, eliminar</button>
            </div>
        </div>
    </div>
</div>


    <!-- Incluyendo Bootstrap JS y el archivo JS de funciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/empleados.js"></script>
</body>
</html>
