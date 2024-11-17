<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gestión de Planillas</title>
    <!-- Incluyendo Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
        }
        .login-form {
            background-color: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-form h1 {
            margin-bottom: 1.5rem;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="login-form col-12 col-md-6 col-lg-4">
        <h1>Gestión de Planillas</h1>
        <form id="loginForm" action="../php/procesar_login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuario o Correo</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Ingrese su usuario o correo" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>
    

    <!-- Incluyendo Bootstrap JS y archivo JS de validación -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="module" src="../js/login.js"></script>

</body>
</html>
