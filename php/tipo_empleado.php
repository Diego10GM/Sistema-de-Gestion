<?php
header('Content-Type: application/json; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegurarse de que la ruta sea correcta
include_once $_SERVER['DOCUMENT_ROOT'].'/planillas/php/conexion.php';

try {
    $conexion = conectar();
    
    if ($conexion->connect_error) {
        throw new Exception("Conexión fallida: " . $conexion->connect_error);
    }

    mysqli_set_charset($conexion, "utf8mb4");
    
    $result = $conexion->query("SELECT id_tipo, nombre_tipo FROM tipo_empleado");
    
    if (!$result) {
        throw new Exception("Error en la consulta: " . $conexion->error);
    }

    $tipos_empleado = [];
    
    while ($row = $result->fetch_assoc()) {
        $tipos_empleado[] = [
            'id_tipo' => $row['id_tipo'],
            'nombre_tipo' => $row['nombre_tipo']
        ];
    }

    echo json_encode($tipos_empleado, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

} catch (Exception $e) {
    error_log("Error en tipo_empleado.php: " . $e->getMessage());
    echo json_encode([
        "success" => false,
        "message" => "Error: " . $e->getMessage()
    ]);
} finally {
    if (isset($conexion)) {
        $conexion->close();
    }
}
?>
