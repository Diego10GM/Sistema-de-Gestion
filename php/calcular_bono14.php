<?php
include_once '../../php/conexion.php';
$conn = conectar();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calcular Bono 14</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <!-- Menú -->
    <div class="col-md-3">
        <?php include_once '../menu.php'; ?>
    </div>

    <!-- Contenido principal -->
    <div style="margin-left: 260px; padding: 20px;">
        <div class="main-container">
            <div class="card card-bono14">
                <div class="card-header">
                    <h2 class="card-title">Calcular Bono 14</h2>
                </div>
                <div class="card-body">
                    <form id="formBono14" class="form-container">
                        <div class="mb-3">
                            <label for="anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="anio" name="anio" 
                                   value="<?php echo date('Y'); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="empleado" class="form-label">Empleado</label>
                            <select class="form-select" id="empleado" name="id_empleado" required>
                                <option value="">Seleccione un empleado</option>
                                <?php
                                $sql = "SELECT e.id_empleado, e.nombre_empleado, e.salario_base,
                                       (SELECT COUNT(*) FROM bono14 b 
                                        WHERE b.id_empleado = e.id_empleado 
                                        AND b.anio = YEAR(CURRENT_DATE)) as tiene_bono
                                       FROM empleados e 
                                       ORDER BY e.nombre_empleado";
                                $resultado = $conn->query($sql);
                                
                                while($fila = $resultado->fetch_assoc()) {
                                    if ($fila['tiene_bono'] == 0) {
                                        echo "<option value='".$fila['id_empleado']."' 
                                              data-salario='".$fila['salario_base']."'>".
                                              $fila['nombre_empleado']." - Q.".
                                              number_format($fila['salario_base'], 2).
                                              "</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="monto_calculado" class="form-label">Monto Calculado</label>
                            <input type="text" class="form-control" id="monto_calculado" name="monto_total" 
                                   readonly>
                        </div>
                        <div class="btn-group-bono14">
                            <button type="button" class="btn btn-calcular" onclick="calcularBono()">Calcular</button>
                            <button type="button" class="btn btn-guardar-bono" onclick="guardarBono()">Guardar Bono</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function calcularBono() {
            const select = document.getElementById('empleado');
            const montoInput = document.getElementById('monto_calculado');
            
            if (!select.value) {
                alert('Por favor seleccione un empleado');
                return;
            }

            const salario = select.options[select.selectedIndex].getAttribute('data-salario');
            if (salario) {
                montoInput.value = 'Q. ' + parseFloat(salario).toFixed(2);
            }
        }

        function guardarBono() {
            const idEmpleado = document.getElementById('empleado').value;
            const montoCalculado = document.getElementById('monto_calculado').value.replace('Q. ', '');
            const anio = document.getElementById('anio').value;

            if (!idEmpleado || !montoCalculado) {
                alert('Por favor calcule el bono primero');
                return;
            }

            fetch('../../php/bono14.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'crear',
                    id_empleado: idEmpleado,
                    anio: anio,
                    monto_total: parseFloat(montoCalculado)
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Bono guardado exitosamente');
                    window.location.href = 'ver_bono14.php';
                } else {
                    alert(data.message || 'Error al guardar el bono');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al procesar la solicitud');
            });
        }

        // Limpiar el monto cuando se cambia de empleado
        document.getElementById('empleado').addEventListener('change', function() {
            document.getElementById('monto_calculado').value = '';
        });
    </script>
</body>
</html>