<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Anticipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-container">
                        <h2>Generar Nuevo Anticipo</h2>
                        
                        <form action="../../php/procesar_anticipo.php" method="POST" class="mt-4">
                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Empleado</label>
                                <select class="form-select" id="id_empleado" name="id_empleado" required>
                                    <option value="">Seleccione un empleado</option>
                                    <?php
                                    require_once '../../php/conexion.php';
                                    $conn = conectar();
                                    
                                    $sql = "SELECT id_empleado, nombre_empleado FROM empleados ORDER BY nombre_empleado";
                                    $result = $conn->query($sql);
                                    
                                    if ($result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<option value='" . $row['id_empleado'] . "'>" . 
                                                 htmlspecialchars($row['nombre_empleado']) . "</option>";
                                        }
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fecha_anticipo" class="form-label">Fecha del Anticipo</label>
                                <input type="date" class="form-control" id="fecha_anticipo" name="fecha_anticipo" 
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="monto" class="form-label">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q</span>
                                    <input type="number" class="form-control" id="monto" name="monto" 
                                           step="0.01" min="0.01" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-select" id="estado" name="estado" required>
                                    <option value="Pendiente">Pendiente</option>
                                    <option value="Pagado">Pagado</option>
                                    <option value="Anulado">Anulado</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Generar Anticipo</button>
                                <a href="ver_anticipos.php" class="btn btn-secondary">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const monto = document.getElementById('monto').value;
            if (monto <= 0) {
                e.preventDefault();
                alert('El monto debe ser mayor que 0');
            }
        });
    </script>
</body>
</html>