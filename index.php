<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>T Consulting, S.A.</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluyendo estilos personalizados -->
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <!-- Incluir el menú -->
    <?php include 'menu.php'; ?>

    <!-- Contenido principal del index -->
    <div class="container mt-5 pt-5" style="margin-left: 270px;">
        <div class="main-container">
            <!-- Logo de la empresa -->
            <img src="img/Tlogo.jpeg" alt="T Consulting Logo" class="company-logo">
            
            <h1 class="welcome-title">Bienvenido a T Consulting, S.A.</h1>
            <p class="welcome-text">Sistema de Gestión de Planillas</p>

            <div class="row">
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Gestión de Empleados</h3>
                        <p>Administre la información de su personal de manera eficiente.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Tipos de Empleados</h3>
                        <p>Configure las categorías y roles del personal.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-box">
                        <h3>Usuarios del Sistema</h3>
                        <p>Gestione los accesos y permisos del sistema.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Incluyendo Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>