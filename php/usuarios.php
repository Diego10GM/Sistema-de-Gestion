<?php
error_reporting(E_ALL);  // Mostrar todos los errores
ini_set('display_errors', 1); // Asegura de que se muestren los errores

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Access-Control-Allow-Headers: Content-Type');

include 'conexion.php'; // Asegúra de que este archivo exista y sea correcto

$conexion = conectar();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    if ($data['action'] == 'crear') {
        $usuario = $data['usuario'];
        $password = $data['password']; // Ya cifrada desde el frontend
        $id_empleado = $data['id_empleado'];

        // Verificar que las variables no estén vacías
        if (!$usuario || !$password || !$id_empleado) {
            echo json_encode(["error" => "Faltan datos obligatorios"]);
            exit;
        }

        // Asegúrate de que la consulta SQL esté bien formada
        $query = "INSERT INTO usuarios (username, password, id_empleado) VALUES ('$usuario', '$password', '$id_empleado')";

        if ($conexion->query($query)) {
            echo json_encode(["message" => "Usuario creado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al crear usuario", "error" => $conexion->error]);
        }
    } elseif ($data['action'] == 'actualizar') {
        $id_usuario = $data['id_usuario'];
        $usuario = $data['usuario'];
        $id_empleado = $data['id_empleado'];

        if (isset($data['password']) && $data['password'] != null) {
            $password = $data['password'];
            $query = "UPDATE usuarios SET username='$usuario', password='$password', id_empleado='$id_empleado' WHERE id_usuario='$id_usuario'";
        } else {
            $query = "UPDATE usuarios SET username='$usuario', id_empleado='$id_empleado' WHERE id_usuario='$id_usuario'";
        }

        if ($conexion->query($query)) {
            echo json_encode(["message" => "Usuario actualizado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al actualizar usuario", "error" => $conexion->error]);
        }
    } elseif ($data['action'] == 'eliminar') {
        $id_usuario = $data['id_usuario'];
        $query = "DELETE FROM usuarios WHERE id_usuario='$id_usuario'";
        if ($conexion->query($query)) {
            echo json_encode(["message" => "Usuario eliminado exitosamente"]);
        } else {
            echo json_encode(["message" => "Error al eliminar usuario", "error" => $conexion->error]);
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    
    if (isset($_GET['action']) && $_GET['action'] == 'leer') {
        $result = $conexion->query("SELECT usuarios.id_usuario, usuarios.username, empleados.nombre_empleado FROM usuarios JOIN empleados ON usuarios.id_empleado = empleados.id_empleado");
        $usuarios = [];
        while ($row = $result->fetch_assoc()) {
            $usuarios[] = $row;
        }
        echo json_encode($usuarios);
        
    } elseif (isset($_GET['action']) && $_GET['action'] == 'leer_uno') {
        $id_usuario = $_GET['id_usuario'];
        $result = $conexion->query("SELECT * FROM usuarios WHERE id_usuario = '$id_usuario'");
        if ($result && $result->num_rows > 0) {
            echo json_encode($result->fetch_assoc());
        } else {
            echo json_encode(["error" => "Usuario no encontrado"]);
        }
    }
}

$conexion->close();
?>
