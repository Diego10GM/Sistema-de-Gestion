<?php
require_once 'conexion.php';
$conn = conectar();
mysqli_set_charset($conn, "utf8mb4");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $id_venta = $_POST['id_venta'];
        $id_empleado = $_POST['empleado'];
        $monto_venta = $_POST['monto'];
        $fecha_venta = $_POST['fecha'];
        
        $sql = "UPDATE ventas SET id_empleado = ?, monto_venta = ?, fecha_venta = ? 
                WHERE id_venta = ?";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idsi", $id_empleado, $monto_venta, $fecha_venta, $id_venta);
        
        if ($stmt->execute()) {
            header("Location: ../views/ventas/ver_ventas.php?mensaje=actualizado");
        } else {
            throw new Exception("Error al actualizar la venta");
        }
    } catch (Exception $e) {
        error_log("Error en procesar_edicion_venta.php: " . $e->getMessage());
        header("Location: ../views/ventas/editar_venta.php?id=".$id_venta."&error=update");
    } finally {
        if (isset($stmt)) {
            $stmt->close();
        }
        if ($conn) {
            $conn->close();
        }
    }
} else {
    header("Location: ../views/ventas/ver_ventas.php");
}
exit();
?>