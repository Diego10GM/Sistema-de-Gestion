<?php
require_once '../../php/conexion.php';
session_start();

// Activamos la visualización de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtenemos la conexión
$conn = conectar();

// Función para obtener los empleados
function obtenerEmpleados($conn) {
    try {
        $sql = "SELECT id_empleado, nombre_empleado 
                FROM empleados 
                ORDER BY nombre_empleado";
        
        $resultado = $conn->query($sql);
        
        if ($resultado === false) {
            throw new Exception("Error en la consulta: " . $conn->error);
        }
        
        return $resultado;
    } catch (Exception $e) {
        error_log("Error al cargar empleados: " . $e->getMessage());
        return false;
    }
}

// Intentamos obtener los empleados
$resultado_empleados = obtenerEmpleados($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Registrar Nueva Venta</h2>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form action="procesar_venta.php" method="POST">
            <div class="form-group mb-3">
                <label for="empleado">Empleado</label>
                <select name="empleado" id="empleado" class="form-control" required>
                    <option value="">Seleccione un empleado</option>
                    <?php 
                    if ($resultado_empleados && $resultado_empleados->num_rows > 0): 
                        while ($empleado = $resultado_empleados->fetch_assoc()):
                    ?>
                        <option value="<?php echo htmlspecialchars($empleado['id_empleado']); ?>">
                            <?php echo htmlspecialchars($empleado['nombre_empleado']); ?>
                        </option>
                    <?php 
                        endwhile;
                    else: 
                    ?>
                        <option value="">Error al cargar empleados</option>
                    <?php endif; ?>
                </select>
            </div>
            
            <div class="form-group mb-3">
                <label for="fecha">Fecha</label>
                <input type="date" 
                       name="fecha" 
                       id="fecha" 
                       class="form-control" 
                       value="<?php echo date('Y-m-d'); ?>" 
                       required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Registrar Venta</button>
                <a href="ver_ventas.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>