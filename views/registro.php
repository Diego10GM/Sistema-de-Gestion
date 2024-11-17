<?php require_once '../menu.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
</head>
<body>
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9">
                    <div class="main-container">
                        <div class="card-header">
                            <h3 class="mb-0">Registro de Usuario</h3>
                        </div>
                        <div class="card-body">
                            <?php
                            if (isset($_SESSION['errores_registro'])) {
                                echo '<div class="alert alert-danger">';
                                foreach ($_SESSION['errores_registro'] as $error) {
                                    echo '<p class="mb-0">' . $error . '</p>';
                                }
                                echo '</div>';
                                unset($_SESSION['errores_registro']);
                            }
                            $datos_form = $_SESSION['datos_form'] ?? [];
                            unset($_SESSION['datos_form']);
                            ?>

                            <form action="../php/procesar_registro.php" method="POST">
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre Completo</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" 
                                        value="<?php echo htmlspecialchars($datos_form['nombre'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="usuario" class="form-label">Nombre de Usuario</label>
                                    <input type="text" class="form-control" id="usuario" name="usuario" 
                                        value="<?php echo htmlspecialchars($datos_form['usuario'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                        value="<?php echo htmlspecialchars($datos_form['email'] ?? ''); ?>" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirmar_password" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required>
                                </div>
                                
                                <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmarPassword = document.getElementById('confirmar_password').value;
            
            if (password !== confirmarPassword) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
            }
        });
    </script>
</body>
</html>