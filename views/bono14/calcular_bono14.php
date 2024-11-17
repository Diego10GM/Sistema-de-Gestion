<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T Consulting, S.A.</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluyendo estilos personalizados -->
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <!-- Incluir el menú -->
    <?php include '../../views/menu.php'; ?>

    <!-- Contenido principal -->
    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <div class="main-container">
            <!-- Logo de la empresa -->
            <img src="../../img/Tlogo.jpeg" alt="T Consulting Logo" class="company-logo">
            
            <h1 class="welcome-title">Calcular Bono 14</h1>
            <p class="welcome-text">Ingrese los datos para calcular el bono</p>

            <div class="row">
                <div class="col-md-12">
                    <div class="feature-box">
                        <form id="formBono14">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="anio" class="form-label">Año</label>
                                    <input type="number" class="form-control" id="anio" name="anio" 
                                           value="<?php echo date('Y'); ?>" readonly>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="empleado" class="form-label">Empleado</label>
                                    <select class="form-select" id="empleado" name="id_empleado" required>
                                        <option value="">Seleccione un empleado</option>
                                        <?php
                                        require_once '../../php/conexion.php';
                                        $conn = conectar();
                                        
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
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="monto_calculado" class="form-label">Monto Calculado</label>
                                    <input type="text" class="form-control" id="monto_calculado" name="monto_total" 
                                           readonly>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-primary w-100" onclick="calcularBono()">Calcular</button>
                                </div>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-success w-100" onclick="guardarBono()">Guardar Bono</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluyendo Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

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