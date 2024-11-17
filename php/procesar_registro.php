<?php
session_start();
require_once 'conexion.php';
$conn = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener y limpiar los datos del formulario
    $usuario = trim(htmlspecialchars($_POST['usuario']));
    $password = $_POST['password'];
    
    // Validaciones básicas
    $errores = [];
    
    // Validar que los campos no estén vacíos
    if (empty($usuario)) $errores[] = "El nombre de usuario es requerido";
    if (empty($password)) $errores[] = "La contraseña es requerida";
    
    // Validar que el usuario no exista
    $stmt = $conn->prepare("SELECT id_usuario FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $errores[] = "El nombre de usuario ya está registrado";
    }
    
    // Si no hay errores, proceder con el registro
    if (empty($errores)) {
        // Encriptar la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        
        // Preparar la consulta SQL
        $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $usuario, $password_hash);
        
        // Ejecutar la consulta
        if ($stmt->execute()) {
            // Registro exitoso
            $_SESSION['mensaje'] = "Registro exitoso. Por favor, inicia sesión.";
            header("Location: ../views/login.php");
            exit();
        } else {
            $errores[] = "Error al registrar el usuario: " . $conn->error;
        }
    }
    
    // Si hay errores, redirigir de vuelta al formulario con los errores
    if (!empty($errores)) {
        $_SESSION['errores_registro'] = $errores;
        $_SESSION['datos_form'] = [
            'usuario' => $usuario
        ];
        header("Location: ../views/registro.php");
        exit();
    }
}

// Si alguien intenta acceder directamente a este archivo
header("Location: ../views/registro.php");
exit();
?>