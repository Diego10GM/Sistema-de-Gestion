<?php require_once '../../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Anticipos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="main-container">
                        <h2>Lista de Anticipos</h2>
                        
                        <a href="generar_anticipo.php" class="btn btn-primary mb-3">Nuevo Anticipo</a>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Empleado</th>
                                        <th>Fecha Anticipo</th>
                                        <th>Monto</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    require_once '../../php/conexion.php';
                                    $conn = conectar();
                                    
                                    $sql = "SELECT a.*, e.nombre_empleado 
                                           FROM anticipos a 
                                           INNER JOIN empleados e ON a.id_empleado = e.id_empleado 
                                           ORDER BY a.fecha_anticipo DESC";
                                    
                                    $result = $conn->query($sql);
                                    
                                    if ($result && $result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . htmlspecialchars($row['id_anticipo']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['nombre_empleado']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['fecha_anticipo']) . "</td>";
                                            echo "<td>Q " . number_format($row['monto'], 2) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                            echo "<td>
                                                    <a href='editar_anticipo.php?id=" . $row['id_anticipo'] . "' class='btn btn-sm btn-warning'>Editar</a>
                                                    <a href='eliminar_anticipo.php?id=" . $row['id_anticipo'] . "' 
                                                       class='btn btn-sm btn-danger' 
                                                       onclick='return confirm(\"¿Está seguro de eliminar este anticipo?\")'>
                                                       Eliminar
                                                    </a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No hay anticipos registrados</td></tr>";
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>