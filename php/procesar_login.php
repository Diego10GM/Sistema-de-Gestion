<?php
session_start(); // Iniciar sesión

include 'conexion.php'; // Incluyendo la conexión a la base de datos

$conexion = conectar(); // Llama a la función conectar()

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos enviados por el formulario
    $usernameOrEmail = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar si el usuario existe (por nombre de usuario o correo)
    $query = "SELECT * FROM usuarios WHERE (username = '$usernameOrEmail')";
    $result = $conexion->query($query);

    if ($result && $result->num_rows > 0) {
        // Usuario encontrado
        $usuario = $result->fetch_assoc();
        

        // Verificar la contraseña (asegúrate de que esté cifrada en la base de datos)
        if (password_verify($password, $usuario['password'])) {
            // Guardar los datos de la sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['username'] = $usuario['username'];

            // Redirigir al dashboard o a la página principal
            header('Location: ../index.php'); 
            exit;

        } else {
            // Contraseña incorrecta
            echo '<script>alert("Contraseña incorrecta"); window.location.href = "/planillas/views/login.php";</script>';
        }
    } else {
        // Usuario no encontrado
        echo '<script>alert("Usuario o correo no encontrado"); window.location.href = "/planillas/views/login.php";</script>';
    }
}

// Cerrar la conexión a la base de datos
$conexion->close();
?>
