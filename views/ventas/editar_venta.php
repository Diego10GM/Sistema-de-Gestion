<?php
require_once '../../php/conexion.php';
$conn = conectar();
mysqli_set_charset($conn, "utf8mb4");

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

try {
    // Obtener datos de la venta
    $sql_venta = "SELECT * FROM ventas WHERE id_venta = ?";
    $stmt = $conn->prepare($sql_venta);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result_venta = $stmt->get_result();
    $venta = $result_venta->fetch_assoc();

    if (!$venta) {
        header("Location: ver_ventas.php");
        exit();
    }
} catch (Exception $e) {
    header("Location: ver_ventas.php?mensaje=error");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Venta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php include '../../menu.php'; ?>

    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <div class="main-container">
            <h2 class="main-title">Editar Venta</h2>

            <div class="form-container">
                <form action="../../php/procesar_edicion_venta.php" method="POST">
                    <input type="hidden" name="id_venta" value="<?php echo $venta['id_venta']; ?>">
                    
                    <div class="mb-3">
                        <label for="empleado" class="form-label">Empleado</label>
                        <select class="form-select" id="empleado" name="empleado" required>
                            <option value="">Seleccione un empleado</option>
                            <?php
                            try {
                                $sql = "SELECT id_empleado, nombre_empleado FROM empleados WHERE activo = 1 ORDER BY nombre_empleado";
                                $result = $conn->query($sql);
                                
                                while ($row = $result->fetch_assoc()) {
                                    $selected = ($row['id_empleado'] == $venta['id_empleado']) ? 'selected' : '';
                                    echo "<option value='".$row['id_empleado']."' $selected>".$row['nombre_empleado']."</option>";
                                }
                            } catch (Exception $e) {
                                echo "<option value=''>Error al cargar empleados</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="monto" class="form-label">Monto de la Venta</label>
                        <input type="number" class="form-control" id="monto" name="monto" 
                               step="0.01" min="0" value="<?php echo $venta['monto_venta']; ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" 
                               value="<?php echo $venta['fecha_venta']; ?>" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Actualizar Venta</button>
                    <a href="ver_ventas.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>