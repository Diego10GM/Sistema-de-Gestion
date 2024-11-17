<?php
header('Content-Type: application/json');
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectar();
    
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];
    $id_tipo = $_POST['id_tipo'];
    
    // Validaciones
    if (empty($nombre) || empty($correo) || empty($telefono) || empty($id_tipo)) {
        echo json_encode(['success' => false, 'message' => 'Todos los campos son requeridos']);
        exit;
    }
    
    // Insertar empleado
    $stmt = $conn->prepare("INSERT INTO empleados (nombre_empleado, correo, telefono, id_tipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $correo, $telefono, $id_tipo);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
    
    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>