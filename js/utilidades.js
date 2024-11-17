// Función para cifrar contraseñas con SHA-256 y exportarla
export async function cifrarContraseña(contraseña) {
    const encoder = new TextEncoder();
    const data = encoder.encode(contraseña);
    const hashBuffer = await crypto.subtle.digest('SHA-256', data);
    const hashArray = Array.from(new Uint8Array(hashBuffer));
    return hashArray.map(byte => byte.toString(16).padStart(2, '0')).join('');
}


