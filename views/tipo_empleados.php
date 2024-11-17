<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD de Tipos de Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/estilos.css">
</head>
<body>

    <!-- Incluir el menú desde menu.php -->
    <?php include '../../menu.php'; ?>

    <!-- Contenido principal del CRUD de tipos de empleado -->
    <div class="container mt-5 pt-5">
        <h2>CRUD de Tipos de Empleado</h2>
        <form id="form-tipo-empleado" class="mb-4">
            <div class="mb-3">
                <label for="nombre_tipo_empleado" class="form-label">Nombre del Tipo de Empleado:</label>
                <input type="text" id="nombre_tipo_empleado" class="form-control" required>
            </div>
            <button type="button" class="btn btn-primary" onclick="crearTipoEmpleado()">Guardar Tipo</button>
        </form>

        <!-- Tabla de tipos de empleado -->
        <h3>Lista de Tipos de Empleado</h3>
        <table class="table table-bordered table-striped" id="tabla-tipo-empleado">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre del Tipo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <!-- Datos cargados dinámicamente -->
            </tbody>
        </table>
    </div>

    <!-- Incluyendo Bootstrap JS y el archivo JS de funciones -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/empleados.js"></script>
</body>
</html>
