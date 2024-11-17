<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Planillas - Usuarios</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <!-- Incluir el menú -->
    <?php include '../menu.php'; ?>

    <!-- Contenido principal del CRUD de usuarios -->
    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <h2>Gestión de Planillas - Usuarios</h2>

        <!-- Botón para agregar usuario -->
        <button class="btn btn-primary mb-3" onclick="mostrarModalAgregarUsuario()">Agregar Usuario</button>

        <!-- Tabla de usuarios -->
        <table class="table table-bordered table-striped" id="tabla-usuarios">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Empleado</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos cargados dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Modal de agregar usuario -->
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="modalAgregarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAgregarUsuarioLabel">Agregar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-agregar-usuario" onsubmit="return false;">
                        <div class="mb-3">
                            <label for="agregar-usuario" class="form-label">Nombre de Usuario:</label>
                            <input type="text" id="agregar-usuario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-password" class="form-label">Contraseña:</label>
                            <input type="password" id="agregar-password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-empleado" class="form-label">Empleado:</label>
                            <select id="agregar-empleado" class="form-select" required>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarNuevoUsuario()">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de editar usuario -->
    <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditarUsuarioLabel">Editar Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-editar-usuario" onsubmit="return false;">
                        <input type="hidden" id="editar-id-usuario">
                        <div class="mb-3">
                            <label for="editar-usuario" class="form-label">Nombre de Usuario:</label>
                            <input type="text" id="editar-usuario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="editar-password" class="form-label">Nueva Contraseña:</label>
                            <input type="password" id="editar-password" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="editar-empleado" class="form-label">Empleado:</label>
                            <select id="editar-empleado" class="form-select" required>
                                <!-- Opciones cargadas dinámicamente -->
                            </select>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="guardarCambiosUsuario()">Guardar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluyendo Bootstrap JS y el archivo JS de funciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="../js/usuarios.js"></script>
</body>
</html>
