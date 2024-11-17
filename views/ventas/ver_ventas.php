<?php
require_once '../../php/conexion.php';
$conn = conectar();
mysqli_set_charset($conn, "utf8mb4");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../css/estilos.css">
</head>
<body>
    <?php include '../../menu.php'; ?>

    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <div class="main-container">
            <h2 class="main-title">Ventas Registradas</h2>
            
            <!-- Botón para agregar nueva venta -->
            <a href="registrar_venta.php" class="btn btn-agregar mb-3">
                <i class="fas fa-plus"></i> Agregar Nueva Venta
            </a>

            <!-- Tabla de ventas -->
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Empleado</th>
                            <th>Monto</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        try {
                            // Consulta SQL con los nombres correctos de las columnas
                            $sql = "SELECT v.id_venta, v.monto_venta, v.fecha_venta, e.nombre_empleado 
                                   FROM ventas v 
                                   JOIN empleados e ON v.id_empleado = e.id_empleado 
                                   ORDER BY v.fecha_venta DESC";
                            
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row['id_venta']."</td>";
                                    echo "<td>".$row['nombre_empleado']."</td>";
                                    echo "<td>Q ".number_format($row['monto_venta'], 2)."</td>";
                                    echo "<td>".date('d/m/Y', strtotime($row['fecha_venta']))."</td>";
                                    echo "<td>
                                            <button class='btn btn-editar btn-sm' onclick='editarVenta(".$row['id_venta'].")'>Editar</button>
                                            <button class='btn btn-eliminar btn-sm' onclick='eliminarVenta(".$row['id_venta'].")'>Eliminar</button>
                                         </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>No hay ventas registradas</td></tr>";
                            }
                        } catch (Exception $e) {
                            echo "<tr><td colspan='5' class='text-center text-danger'>Error al cargar los datos: " . $e->getMessage() . "</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function editarVenta(id) {
            window.location.href = 'editar_venta.php?id=' + id;
        }

        function eliminarVenta(id) {
            if(confirm('¿Está seguro de que desea eliminar esta venta?')) {
                window.location.href = 'eliminar_venta.php?id=' + id;
            }
        }
    </script>
</body>
</html>