<?php
include '../../php/conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Comisiones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php include '../../menu.php'; ?>

    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <div class="main-container">
            <h2 class="main-title">Comisiones por Ventas</h2>

            <!-- Filtros -->
            <div class="form-container mb-4">
                <form action="" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <label for="empleado" class="form-label">Empleado</label>
                        <select class="form-select" id="empleado" name="empleado">
                            <option value="">Todos los empleados</option>
                            <?php
                            $sql = "SELECT id, nombre FROM empleados WHERE activo = 1 ORDER BY nombre";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    $selected = (isset($_GET['empleado']) && $_GET['empleado'] == $row['id']) ? 'selected' : '';
                                    echo "<option value='".$row['id']."' ".$selected.">".$row['nombre']."</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="mes" class="form-label">Mes</label>
                        <input type="month" class="form-control" id="mes" name="mes" 
                               value="<?php echo isset($_GET['mes']) ? $_GET['mes'] : date('Y-m'); ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-agregar d-block w-100">Filtrar</button>
                    </div>
                </form>
            </div>

            <!-- Tabla de comisiones -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Empleado</th>
                            <th>Total Ventas</th>
                            <th>Comisión</th>
                            <th>Período</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Construir la consulta base
                        $sql = "SELECT e.nombre, 
                                      SUM(v.monto) as total_ventas,
                                      SUM(v.comision) as total_comision,
                                      DATE_FORMAT(v.fecha, '%Y-%m') as periodo
                               FROM empleados e
                               LEFT JOIN ventas v ON e.id = v.empleado_id";

                        // Agregar filtros si existen
                        $where = array();
                        if(isset($_GET['empleado']) && !empty($_GET['empleado'])) {
                            $where[] = "e.id = ".$_GET['empleado'];
                        }
                        if(isset($_GET['mes']) && !empty($_GET['mes'])) {
                            $where[] = "DATE_FORMAT(v.fecha, '%Y-%m') = '".$_GET['mes']."'";
                        }

                        if(!empty($where)) {
                            $sql .= " WHERE " . implode(" AND ", $where);
                        }

                        $sql .= " GROUP BY e.id, DATE_FORMAT(v.fecha, '%Y-%m')
                                 ORDER BY v.fecha DESC, e.nombre";

                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row['nombre']."</td>";
                                echo "<td>Q ".number_format($row['total_ventas'], 2)."</td>";
                                echo "<td>Q ".number_format($row['total_comision'], 2)."</td>";
                                echo "<td>".date('m/Y', strtotime($row['periodo'].'-01'))."</td>";
                                echo "<td><span class='badge bg-success'>Pagado</span></td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center'>No hay comisiones registradas</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>