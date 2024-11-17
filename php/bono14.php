<?php
require_once 'conexion.php';

// Configurar headers para JSON
header('Content-Type: application/json');

// Obtener la conexión
$conn = conectar();

// Verificar el tipo de acción solicitada
$action = isset($_GET['action']) ? $_GET['action'] : (isset($_POST['action']) ? $_POST['action'] : '');

// Si es una petición POST, obtener los datos del body
if ($_SERVER['REQUEST_METHOD'] == 'POST' && !isset($_POST['action'])) {
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'];
}

switch ($action) {
    case 'obtener_empleados':
        // Obtener lista de empleados para el select
        $sql = "SELECT id_empleado, nombre_empleado FROM empleados ORDER BY nombre_empleado";
        $result = $conn->query($sql);
        $empleados = [];
        
        while ($row = $result->fetch_assoc()) {
            $empleados[] = $row;
        }
        
        echo json_encode($empleados);
        break;

    case 'crear':
        // Crear nuevo registro de bono
        $data = json_decode(file_get_contents('php://input'), true);
        
        $sql = "INSERT INTO bono14 (id_empleado, anio, monto_total, fecha_calculo, estado) 
                VALUES (?, ?, ?, CURDATE(), 'Pendiente')";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("idd", 
            $data['id_empleado'],
            $data['anio'],
            $data['monto_total']
        );
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Bono creado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al crear el bono']);
        }
        break;

    case 'obtener_bono':
        // Obtener datos de un bono específico
        $id_empleado = $_GET['id_empleado'];
        
        $sql = "SELECT * FROM bono14 WHERE id_empleado = ? AND anio = YEAR(CURRENT_DATE)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_empleado);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            echo json_encode($row);
        } else {
            echo json_encode(['error' => 'Bono no encontrado']);
        }
        break;

    case 'actualizar':
        // Actualizar un bono existente
        $data = json_decode(file_get_contents('php://input'), true);
        
        $sql = "UPDATE bono14 
                SET monto_total = ?, anio = ?, fecha_calculo = CURDATE()
                WHERE id_empleado = ? AND anio = YEAR(CURRENT_DATE)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ddi", 
            $data['monto_total'],
            $data['anio'],
            $data['id_empleado']
        );
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Bono actualizado exitosamente']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar el bono']);
        }
        break;

    case 'pagar':
        // Marcar un bono como pagado
        $data = json_decode(file_get_contents('php://input'), true);
        
        $sql = "UPDATE bono14 
                SET estado = 'Pagado' 
                WHERE id_empleado = ? AND anio = YEAR(CURRENT_DATE)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $data['id_empleado']);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Bono marcado como pagado']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al procesar el pago']);
        }
        break;

    default:
        echo json_encode(['error' => 'Acción no válida']);
        break;
}

$conn->close();
?>