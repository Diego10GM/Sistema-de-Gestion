<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Horas Extra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="main-container">
                <h2 class="main-title">Registrar Horas Extra</h2>
                
                <div class="card">
                    <div class="card-body">
                        <form action="../../php/procesar_horas_extra.php" method="POST">
                            <div class="mb-3">
                                <label for="id_empleado" class="form-label">Empleado</label>
                                <select class="form-select" id="id_empleado" name="id_empleado" required>
                                    <option value="">Seleccione un empleado</option>
                                    <?php
                                    require_once '../../php/conexion.php';
                                    $conn = conectar();
                                    $sql = "SELECT id_empleado, nombre_empleado FROM empleados ORDER BY nombre_empleado";
                                    $result = $conn->query($sql);
                                    while($row = $result->fetch_assoc()) {
                                        echo "<option value='" . $row['id_empleado'] . "'>" . 
                                             htmlspecialchars($row['nombre_empleado']) . "</option>";
                                    }
                                    $conn->close();
                                    ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="fecha" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha" name="fecha" 
                                       value="<?php echo date('Y-m-d'); ?>" required>
                            </div>

                            <div class="mb-3">
                                <label for="cantidad_horas" class="form-label">Cantidad de Horas</label>
                                <input type="number" class="form-control" id="cantidad_horas" name="cantidad_horas" 
                                       step="0.01" min="0.01" required>
                            </div>

                            <div class="mb-3">
                                <label for="tipo_hora" class="form-label">Tipo de Hora</label>
                                <select class="form-select" id="tipo_hora" name="tipo_hora" required>
                                    <option value="Normal">Normal</option>
                                    <option value="Doble">Doble</option>
                                </select>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Guardar</button>
                                <a href="ver_horas.php" class="btn btn-secondary">Cancelar</a>
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
            const horas = document.getElementById('cantidad_horas').value;
            if (horas <= 0) {
                e.preventDefault();
                alert('La cantidad de horas debe ser mayor que 0');
            }
        });
    </script>
</body>
</html>