<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Bonos 14</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-container">
                        <h2 class="main-title">Gestión de Planillas - Bonos 14</h2>
                        
                        <!-- Botón para abrir el modal -->
                        <button type="button" class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#modalAgregarBono">
                            Agregar Bono
                        </button>
                        
                        <!-- Tabla de bonos -->
                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Empleado</th>
                                            <th>Año</th>
                                            <th>Monto</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        require_once '../../php/conexion.php';
                                        $conn = conectar();
                                        
                                        $sql = "SELECT b.*, e.nombre_empleado 
                                               FROM bono14 b 
                                               RIGHT JOIN empleados e ON b.id_empleado = e.id_empleado 
                                               LEFT JOIN tipo_empleado t ON e.id_tipo = t.id_tipo";
                                        
                                        $result = $conn->query($sql);
                                        
                                        while($row = $result->fetch_assoc()) {
                                            // Si no hay registro de bono, establecer valores predeterminados
                                            $estado = isset($row['estado']) ? $row['estado'] : 'Pendiente';
                                            $monto = isset($row['monto']) ? number_format($row['monto'], 2) : '0.00';
                                            $anio = isset($row['anio']) ? $row['anio'] : date('Y');
                                            
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id_empleado']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nombre_empleado']) . "</td>";
                                            echo "<td>" . htmlspecialchars($anio) . "</td>";
                                            echo "<td>Q. " . $monto . "</td>";
                                            echo "<td>" . htmlspecialchars($estado) . "</td>";
                                            echo "<td>
                                                    <button class='btn btn-danger btn-sm' onclick='editarBono(" . $row['id_empleado'] . ")'>Editar</button>
                                                    <button class='btn btn-success btn-sm' onclick='pagarBono(" . $row['id_empleado'] . ")'>Pagar</button>
                                                </td>";
                                            echo "</tr>";
                                        }
                                        $conn->close();
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Agregar Bono -->
    <div class="modal fade" id="modalAgregarBono" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Agregar Bono 14</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formAgregarBono">
                        <div class="mb-3">
                            <label for="agregar-empleado" class="form-label">Empleado</label>
                            <select class="form-control" id="agregar-empleado" required>
                                <!-- Se llenará dinámicamente -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-anio" class="form-label">Año</label>
                            <input type="number" class="form-control" id="agregar-anio" value="<?php echo date('Y'); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="agregar-monto" class="form-label">Monto</label>
                            <input type="number" step="0.01" class="form-control" id="agregar-monto" required>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarNuevoBono()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts necesarios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/bono14.js"></script>
</body>
</html>