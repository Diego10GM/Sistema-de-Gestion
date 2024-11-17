import { cifrarContraseña } from './utilidades.js';


document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault(); // Prevenir el envío automático del formulario

    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (!username || !password) {
        alert('Por favor, complete todos los campos.');
        return;
    }

    // Cifrar la contraseña con SHA-256
    const passwordCifrada = await cifrarContraseña(password);
    console.log(passwordCifrada)
    // Crear un formulario oculto para enviar los datos
    const form = new FormData();
    form.append('username', username);
    form.append('password', passwordCifrada);

    // Enviar los datos al backend usando fetch
    const response = await fetch('../php/procesar_login.php', {
        method: 'POST',
        body: form
    });

    if (response.ok) {
        window.location.href = '/planillas/index.php'; // Redirigir al dashboard si el login es exitoso
    } else {
        alert('Error al iniciar sesión. Verifique sus credenciales.');
    }
});


