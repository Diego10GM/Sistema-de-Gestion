<?php
require_once '../../php/conexion.php';
session_start();

// Activamos la visualización de errores para desarrollo
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificamos que sea una petición POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error'] = "Método no permitido";
    header('Location: registrar_venta.php');
    exit();
}

// Verificamos que los campos necesarios estén presentes
if (!isset($_POST['empleado']) || !isset($_POST['fecha'])) {
    $_SESSION['error'] = "Faltan datos requeridos";
    header('Location: registrar_venta.php');
    exit();
}

// Obtenemos los datos del formulario
$id_empleado = $_POST['empleado'];
$fecha_venta = $_POST['fecha'];

// Validamos que los campos no estén vacíos
if (empty($id_empleado) || empty($fecha_venta)) {
    $_SESSION['error'] = "Todos los campos son obligatorios";
    header('Location: registrar_venta.php');
    exit();
}

try {
    // Obtenemos la conexión
    $conn = conectar();
    
    // Iniciamos una transacción
    $conn->begin_transaction();

    // Insertamos la venta
    $sql = "INSERT INTO ventas (id_empleado, fecha_venta, monto_venta) VALUES (?, ?, 0.00)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_empleado, $fecha_venta);
    
    if (!$stmt->execute()) {
        throw new Exception("Error al registrar la venta: " . $stmt->error);
    }

    // Obtenemos el ID de la venta insertada
    $id_venta = $conn->insert_id;

    // Confirmamos la transacción
    $conn->commit();

    // Guardamos mensaje de éxito
    $_SESSION['success'] = "Venta registrada correctamente";
    
    // Redirigimos a la página de ver ventas
    header('Location: ver_ventas.php');
    exit();

} catch (Exception $e) {
    // Si hay error, hacemos rollback
    if (isset($conn)) {
        $conn->rollback();
    }
    
    // Guardamos el mensaje de error
    $_SESSION['error'] = "Error al procesar la venta: " . $e->getMessage();
    
    // Redirigimos de vuelta al formulario
    header('Location: registrar_venta.php');
    exit();
} finally {
    // Cerramos la conexión
    if (isset($conn)) {
        $conn->close();
    }
}
?>