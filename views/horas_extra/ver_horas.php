<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Horas Extra</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="main-container">
                <h2 class="main-title">Control de Horas Extra</h2>
                
                <button type="button" class="btn btn-agregar" data-bs-toggle="modal" data-bs-target="#modalRegistrarHoras">
                    Registrar Horas Extra
                </button>
                
                <div class="table-container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Empleado</th>
                                <th>Fecha</th>
                                <th>Cantidad de Horas</th>
                                <th>Tipo de Hora</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require_once '../../php/conexion.php';
                            $conn = conectar();
                            
                            $sql = "SELECT h.*, e.nombre_empleado 
                                   FROM horas_extra h 
                                   INNER JOIN empleados e ON h.id_empleado = e.id_empleado 
                                   ORDER BY h.fecha DESC";
                            
                            $result = $conn->query($sql);
                            
                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['id_hora_extra']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['nombre_empleado']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['cantidad_horas']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['tipo_hora']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                    echo "<td>
                                            <button class='btn btn-editar btn-sm'>Editar</button>
                                            <button class='btn btn-eliminar btn-sm'>Eliminar</button>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7' class='text-center'>No hay registros de horas extra</td></tr>";
                            }
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para registrar horas extra -->
    <div class="modal fade" id="modalRegistrarHoras" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Horas Extra</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHorasExtra" action="../../php/procesar_horas_extra.php" method="POST">
                        <div class="mb-3">
                            <label for="id_empleado" class="form-label">Empleado</label>
                            <select class="form-select" id="id_empleado" name="id_empleado" required>
                                <?php
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
                            <input type="date" class="form-control" id="fecha" name="fecha" required>
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

                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>