import { cifrarContraseña } from './utilidades.js';

let usuarioSeleccionado = null; // Guardar el usuario seleccionado

async function cargarUsuarios() {
    try {
        const response = await fetch('../php/usuarios.php?action=leer');

        // Verifica que la respuesta sea exitosa
        if (!response.ok) {
            throw new Error('Error en la solicitud');
        }

        // Analiza la respuesta JSON
        const usuarios = await response.json();

        // Asegúrate de que el JSON tenga el formato esperado
        if (!Array.isArray(usuarios)) {
            throw new Error('El formato de respuesta no es válido');
        }

        let tabla = document.querySelector('#tabla-usuarios tbody');
        tabla.innerHTML = ''; // Limpiar la tabla

        usuarios.forEach(usuario => {
            let fila = `
                <tr>
                    <td>${usuario.id_usuario}</td>
                    <td>${usuario.nombre_empleado}</td>
                    <td>${usuario.username}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" onclick="mostrarModalEditarUsuario(${usuario.id_usuario})">Editar</button>
                        <button class="btn btn-danger btn-sm" onclick="mostrarModalEliminarUsuario(${usuario.id_usuario})">Eliminar</button>
                    </td>
                </tr>`;
            tabla.innerHTML += fila;
        });
    } catch (error) {
        console.error('Error al cargar usuarios:', error);
        alert('Hubo un error al cargar los usuarios. Revisa la consola para más detalles.');
    }
}


// Cargar empleados para el dropdown
async function cargarEmpleados() {
    const response = await fetch('../php/empleados.php?action=leer');
    const empleados = await response.json();

    let dropdownAgregar = document.getElementById('agregar-empleado');
    let dropdownEditar = document.getElementById('editar-empleado');

    dropdownAgregar.innerHTML = '';
    dropdownEditar.innerHTML = '';

    empleados.forEach(empleado => {
        let option = `<option value="${empleado.id_empleado}">${empleado.nombre_empleado}</option>`;
        dropdownAgregar.innerHTML += option;
        dropdownEditar.innerHTML += option;
    });
}


// Mostrar modal de agregar usuario
function mostrarModalAgregarUsuario() {
    cargarEmpleados(); // Cargar empleados en el dropdown
    const modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregarUsuario'));
    modalAgregar.show();
}

async function guardarNuevoUsuario() {
    try {
        const usuario = document.getElementById('agregar-usuario').value;
        const password = document.getElementById('agregar-password').value;
        const empleado = document.getElementById('agregar-empleado').value;

        //console.log(usuario);
        //console.log(password);
        //console.log(empleado);
        if (!usuario || !password || !empleado) {
            alert('Todos los campos son obligatorios');
            return;
        }

        const passwordCifrada = await cifrarContraseña(password);
       // console.log(passwordCifrada);
        const response = await fetch('../php/usuarios.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'crear',
                usuario: usuario,
                password: passwordCifrada,
                id_empleado: empleado
            })
        });

        const result = await response.json();
        if (result.message === "Usuario creado exitosamente") {
            cargarUsuarios(); // Recargar la lista de usuarios
            const modalAgregar = bootstrap.Modal.getInstance(document.getElementById('modalAgregarUsuario'));
            modalAgregar.hide(); // Ocultar modal
        } else {
            alert('Error al crear el usuario');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Hubo un error en la solicitud. Por favor, revisa la consola para más detalles.');
    }
}



// Mostrar modal de edición de usuario
async function mostrarModalEditarUsuario(idUsuario) {
cargarEmpleados(); // Cargar empleados en el dropdown

const response = await fetch(`../php/usuarios.php?action=leer_uno&id_usuario=${idUsuario}`);
const usuario = await response.json();

document.getElementById('editar-id-usuario').value = usuario.id_usuario;
document.getElementById('editar-usuario').value = usuario.username;
document.getElementById('editar-empleado').value = usuario.id_empleado;

const modalEditar = new bootstrap.Modal(document.getElementById('modalEditarUsuario'));
modalEditar.show();
}

// Guardar cambios en el usuario
async function guardarCambiosUsuario() {
const idUsuario = document.getElementById('editar-id-usuario').value;
const usuario = document.getElementById('editar-usuario').value;
const password = document.getElementById('editar-password').value; // Puede estar vacío si no se desea cambiar la contraseña
const empleado = document.getElementById('editar-empleado').value;

let passwordCifrada = null;
if (password) {
    passwordCifrada = await cifrarContraseña(password); // Cifrar solo si se cambia la contraseña
}

const response = await fetch('../php/usuarios.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
        action: 'actualizar',
        id_usuario: idUsuario,
        usuario: usuario,
        password: passwordCifrada, // Puede ser null si no se cambia la contraseña
        id_empleado: empleado
    })
});

const result = await response.json();
if (result.message === "Usuario actualizado exitosamente") {
    cargarUsuarios(); // Recargar la lista de usuarios
    const modalEditar = bootstrap.Modal.getInstance(document.getElementById('modalEditarUsuario'));
    modalEditar.hide(); // Ocultar modal
} else {
    alert('Error al actualizar el usuario');
}
}

// Mostrar modal de confirmación de eliminación
function mostrarModalEliminarUsuario(idUsuario) {
usuarioSeleccionado = idUsuario;
const modalEliminar = new bootstrap.Modal(document.getElementById('modalEliminarUsuario'));
modalEliminar.show();
}

// Confirmar eliminación de usuario
async function eliminarUsuario() {
const response = await fetch('../php/usuarios.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'eliminar', id_usuario: usuarioSeleccionado })
});

const result = await response.json();
if (result.message === "Usuario eliminado exitosamente") {
    cargarUsuarios(); // Recargar la lista de usuarios
    const modalEliminar = bootstrap.Modal.getInstance(document.getElementById('modalEliminarUsuario'));
    modalEliminar.hide();
} else {
    alert('Error al eliminar el usuario');
}
}

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
cargarUsuarios();  // Cargar lista de usuarios al cargar la página
});
