<?php
require_once '../../php/conexion.php';
$conn = conectar();
mysqli_set_charset($conn, "utf8mb4");

try {
    $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($id > 0) {
        $sql = "DELETE FROM ventas WHERE id_venta = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            header("Location: ver_ventas.php?mensaje=eliminado");
        } else {
            throw new Exception("Error al eliminar la venta");
        }
    } else {
        throw new Exception("ID de venta no válido");
    }
} catch (Exception $e) {
    error_log("Error en eliminar_venta.php: " . $e->getMessage());
    header("Location: ver_ventas.php?mensaje=error");
} finally {
    if (isset($stmt)) {
        $stmt->close();
    }
    if ($conn) {
        $conn->close();
    }
}
exit();
?>