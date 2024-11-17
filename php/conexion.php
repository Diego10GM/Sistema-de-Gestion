<?php
function conectar() {
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $base_datos = "planillas";

    $conexion = new mysqli($servidor, $usuario, $password, $base_datos);

    if ($conexion->connect_error) {
        die("Conexión fallida: " . $conexion->connect_error);
    }

    // Establecer el charset a utf8mb4 para manejar todos los caracteres especiales
    if (!$conexion->set_charset("utf8mb4")) {
        printf("Error cargando el conjunto de caracteres utf8mb4: %s\n", $conexion->error);
        exit();
    }

    return $conexion;
}
?>
