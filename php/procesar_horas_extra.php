<?php
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectar();
    
    $id_empleado = $_POST['id_empleado'];
    $fecha = $_POST['fecha'];
    $cantidad_horas = $_POST['cantidad_horas'];
    $tipo_hora = $_POST['tipo_hora'];
    $estado = 'Pendiente'; // Estado por defecto
    
    $stmt = $conn->prepare("INSERT INTO horas_extra (id_empleado, fecha, cantidad_horas, tipo_hora, estado) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdss", $id_empleado, $fecha, $cantidad_horas, $tipo_hora, $estado);
    
    if ($stmt->execute()) {
        header("Location: ../views/horas_extra/ver_horas.php");
    } else {
        echo "Error: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>