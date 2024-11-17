<?php
session_start();
require_once 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = conectar();
    
    $id_empleado = $_POST['id_empleado'];
    $fecha_anticipo = $_POST['fecha_anticipo'];
    $monto = $_POST['monto'];
    $estado = $_POST['estado'];
    
    // Validaciones
    $errores = [];
    
    if (empty($id_empleado)) $errores[] = "Debe seleccionar un empleado";
    if (empty($fecha_anticipo)) $errores[] = "La fecha es requerida";
    if (empty($monto) || $monto <= 0) $errores[] = "El monto debe ser mayor que 0";
    if (empty($estado)) $errores[] = "El estado es requerido";
    
    if (empty($errores)) {
        $stmt = $conn->prepare("INSERT INTO anticipos (id_empleado, fecha_anticipo, monto, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isds", $id_empleado, $fecha_anticipo, $monto, $estado);
        
        if ($stmt->execute()) {
            $_SESSION['mensaje'] = "Anticipo generado exitosamente";
            header("Location: ../views/anticipos/ver_anticipos.php");
            exit();
        } else {
            $errores[] = "Error al generar el anticipo: " . $conn->error;
        }
    }
    
    if (!empty($errores)) {
        $_SESSION['errores'] = $errores;
        header("Location: ../views/anticipos/generar_anticipo.php");
        exit();
    }
}

header("Location: ../views/anticipos/ver_anticipos.php");
exit();
?>