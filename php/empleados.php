<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once $_SERVER['DOCUMENT_ROOT'].'/planillas/php/conexion.php';
$conexion = conectar();
mysqli_set_charset($conexion, "utf8mb4"); // Cambiado a utf8mb4

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data['action'] == 'crear') {
            $nombre = $conexion->real_escape_string($data['nombre_empleado']);
            $correo = $conexion->real_escape_string($data['correo']);
            $telefono = $conexion->real_escape_string($data['telefono']);
            $id_tipo = (int)$data['id_tipo'];
            $salario_base = (float)$data['salario_base'];

            $query = "INSERT INTO empleados (nombre_empleado, correo, telefono, id_tipo, salario_base) 
                     VALUES ('$nombre', '$correo', '$telefono', '$id_tipo', '$salario_base')";
            
            if ($conexion->query($query)) {
                echo json_encode(["success" => true, "message" => "Empleado creado exitosamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al crear empleado: " . $conexion->error]);
            }

        } elseif ($data['action'] == 'actualizar') {
            $id_empleado = (int)$data['id_empleado'];
            $nombre = $conexion->real_escape_string($data['nombre_empleado']);
            $correo = $conexion->real_escape_string($data['correo']);
            $telefono = $conexion->real_escape_string($data['telefono']);
            $id_tipo = (int)$data['id_tipo'];
            $salario_base = (float)$data['salario_base'];

            $query = "UPDATE empleados 
                     SET nombre_empleado='$nombre', 
                         correo='$correo', 
                         telefono='$telefono', 
                         id_tipo='$id_tipo',
                         salario_base='$salario_base'
                     WHERE id_empleado=$id_empleado";
            
            if ($conexion->query($query)) {
                echo json_encode(["success" => true, "message" => "Empleado actualizado exitosamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al actualizar empleado: " . $conexion->error]);
            }

        } elseif ($data['action'] == 'eliminar') {
            $id_empleado = (int)$data['id_empleado'];

            $query = "DELETE FROM empleados WHERE id_empleado=$id_empleado";
            if ($conexion->query($query)) {
                echo json_encode(["success" => true, "message" => "Empleado eliminado exitosamente"]);
            } else {
                echo json_encode(["success" => false, "message" => "Error al eliminar empleado: " . $conexion->error]);
            }
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['action']) && $_GET['action'] == 'leer') {
            $query = "SELECT 
                e.id_empleado,
                e.nombre_empleado,
                e.correo,
                e.telefono,
                e.id_tipo,
                e.salario_base,
                t.nombre_tipo
            FROM empleados e 
            INNER JOIN tipo_empleado t ON e.id_tipo = t.id_tipo
            ORDER BY e.id_empleado";
            
            $result = $conexion->query($query);
            
            if (!$result) {
                throw new Exception("Error en la consulta: " . $conexion->error);
            }
            
            $empleados = [];
            
            while ($row = $result->fetch_assoc()) {
                // Ya no necesitamos convertir a UTF-8 manualmente
                $empleados[] = $row;
            }
            
            echo json_encode($empleados, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            
        } else if (isset($_GET['action']) && $_GET['action'] == 'leer_uno') {
            $id_empleado = (int)$_GET['id_empleado'];
            
            $query = "SELECT 
                e.id_empleado,
                e.nombre_empleado,
                e.correo,
                e.telefono,
                e.id_tipo,
                e.salario_base,
                t.nombre_tipo
            FROM empleados e
            INNER JOIN tipo_empleado t ON e.id_tipo = t.id_tipo
            WHERE e.id_empleado = $id_empleado";
            
            $result = $conexion->query($query);

            if ($result && $result->num_rows > 0) {
                $empleado = $result->fetch_assoc();
                echo json_encode(["success" => true, "data" => $empleado], 
                               JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            } else {
                echo json_encode(["success" => false, "message" => "Empleado no encontrado"]);
            }
        }
    }

} catch (Exception $e) {
    error_log("Error en empleados.php: " . $e->getMessage());
    echo json_encode([
        "success" => false, 
        "message" => "Error: " . $e->getMessage()
    ]);
} finally {
    if ($conexion) {
        $conexion->close();
    }
}
?>
