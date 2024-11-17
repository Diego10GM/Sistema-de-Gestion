let empleadoSeleccionado = null;

// Función para inicializar la página
function inicializarPagina() {
    console.log('Inicializando página...');
    cargarEmpleados();
    cargarTiposEmpleado();
}

// Cargar empleados
async function cargarEmpleados() {
    try {
        const response = await fetch('/planillas/php/empleados.php?action=leer');
        const empleados = await response.json();
        
        const tabla = document.querySelector('.table tbody');
        tabla.innerHTML = ''; 

        empleados.forEach(empleado => {
            let fila = `
                <tr>
                    <td>${empleado.id_empleado}</td>
                    <td>${empleado.nombre_empleado}</td>
                    <td>${empleado.correo}</td>
                    <td>${empleado.telefono}</td>
                    <td>${empleado.nombre_tipo}</td>
                    <td>
                        <button class="btn btn-editar btn-sm" onclick="mostrarModalEditar(${empleado.id_empleado})">Editar</button>
                        <button class="btn btn-eliminar btn-sm" onclick="mostrarModalEliminar(${empleado.id_empleado})">Eliminar</button>
                    </td>
                </tr>`;
            tabla.innerHTML += fila;
        });
    } catch (error) {
        console.error('Error al cargar empleados:', error);
    }
}

// Guardar nuevo empleado
async function guardarNuevoEmpleado() {
    try {
        const formData = {
            action: 'crear',
            nombre_empleado: document.getElementById('agregar-nombre-empleado').value,
            correo: document.getElementById('agregar-correo').value,
            telefono: document.getElementById('agregar-telefono').value,
            id_tipo: document.getElementById('agregar-tipo-empleado').value
        };

        const response = await fetch('/planillas/php/empleados.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const result = await response.json();
        if (result.message === "Empleado creado exitosamente") {
            await cargarEmpleados();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalAgregarEmpleado'));
            modal.hide();
            limpiarFormulario('agregar');
        }
    } catch (error) {
        console.error('Error al guardar empleado:', error);
    }
}

// Mostrar modal de editar
async function mostrarModalEditar(idEmpleado) {
    try {
        const response = await fetch(`/planillas/php/empleados.php?action=leer_uno&id_empleado=${idEmpleado}`);
        const empleado = await response.json();

        document.getElementById('editar-id-empleado').value = empleado.id_empleado;
        document.getElementById('editar-nombre-empleado').value = empleado.nombre_empleado;
        document.getElementById('editar-correo').value = empleado.correo;
        document.getElementById('editar-telefono').value = empleado.telefono;
        document.getElementById('editar-tipo-empleado').value = empleado.id_tipo;

        const modal = new bootstrap.Modal(document.getElementById('modalEditar'));
        modal.show();
    } catch (error) {
        console.error('Error al cargar empleado:', error);
    }
}

// Guardar cambios de empleado
async function guardarCambiosEmpleado() {
    try {
        const formData = {
            action: 'actualizar',
            id_empleado: document.getElementById('editar-id-empleado').value,
            nombre_empleado: document.getElementById('editar-nombre-empleado').value,
            correo: document.getElementById('editar-correo').value,
            telefono: document.getElementById('editar-telefono').value,
            id_tipo: document.getElementById('editar-tipo-empleado').value
        };

        const response = await fetch('/planillas/php/empleados.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(formData)
        });

        const result = await response.json();
        if (result.message === "Empleado actualizado exitosamente") {
            await cargarEmpleados();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEditar'));
            modal.hide();
            limpiarFormulario('editar');
        }
    } catch (error) {
        console.error('Error al actualizar empleado:', error);
    }
}

// Mostrar modal de eliminar
function mostrarModalEliminar(idEmpleado) {
    empleadoSeleccionado = idEmpleado;
    const modal = new bootstrap.Modal(document.getElementById('modalEliminar'));
    modal.show();
}

// Confirmar eliminación
document.getElementById('btnConfirmarEliminar').addEventListener('click', async () => {
    try {
        const response = await fetch('/planillas/php/empleados.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 
                action: 'eliminar', 
                id_empleado: empleadoSeleccionado 
            })
        });

        const result = await response.json();
        if (result.message === "Empleado eliminado exitosamente") {
            await cargarEmpleados();
            const modal = bootstrap.Modal.getInstance(document.getElementById('modalEliminar'));
            modal.hide();
        }
    } catch (error) {
        console.error('Error al eliminar empleado:', error);
    }
});

// Limpiar formularios
function limpiarFormulario(tipo) {
    if (tipo === 'agregar') {
        document.getElementById('agregar-nombre-empleado').value = '';
        document.getElementById('agregar-correo').value = '';
        document.getElementById('agregar-telefono').value = '';
        document.getElementById('agregar-tipo-empleado').value = '';
    } else if (tipo === 'editar') {
        document.getElementById('editar-nombre-empleado').value = '';
        document.getElementById('editar-correo').value = '';
        document.getElementById('editar-telefono').value = '';
        document.getElementById('editar-tipo-empleado').value = '';
    }
}

// Cargar tipos de empleado
async function cargarTiposEmpleado() {
    try {
        const response = await fetch('/planillas/php/tipo_empleado.php');
        const tipos = await response.json();

        const dropdownAgregar = document.getElementById('agregar-tipo-empleado');
        const dropdownEditar = document.getElementById('editar-tipo-empleado');

        dropdownAgregar.innerHTML = '';
        dropdownEditar.innerHTML = '';

        tipos.forEach(tipo => {
            const option = `<option value="${tipo.id_tipo}">${tipo.nombre_tipo}</option>`;
            dropdownAgregar.innerHTML += option;
            dropdownEditar.innerHTML += option;
        });
    } catch (error) {
        console.error('Error al cargar tipos de empleado:', error);
        alert('Error al cargar los tipos de empleado');
    }
}

// Manejo de errores general
window.addEventListener('unhandledrejection', function(event) {
    console.error('Error no manejado:', event.reason);
    alert('Ocurrió un error inesperado. Por favor, intente de nuevo.');
});

// Inicializar la página cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    inicializarPagina();

    // Agregar listeners para limpiar formularios cuando se cierren los modales
    document.getElementById('modalAgregarEmpleado').addEventListener('hidden.bs.modal', function () {
        limpiarFormulario('agregar');
    });

    document.getElementById('modalEditar').addEventListener('hidden.bs.modal', function () {
        limpiarFormulario('editar');
    });

    // Validación de formularios
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});

// Función de utilidad para mostrar mensajes
function mostrarMensaje(mensaje, tipo = 'success') {
    // Puedes personalizar esto según tus necesidades
    alert(mensaje);
}

// Función para validar datos antes de enviar
function validarDatos(datos) {
    if (!datos.nombre_empleado || datos.nombre_empleado.trim() === '') {
        mostrarMensaje('El nombre es requerido', 'error');
        return false;
    }
    if (!datos.correo || !datos.correo.includes('@')) {
        mostrarMensaje('El correo no es válido', 'error');
        return false;
    }
    if (!datos.telefono) {
        mostrarMensaje('El teléfono es requerido', 'error');
        return false;
    }
    if (!datos.id_tipo) {
        mostrarMensaje('Debe seleccionar un tipo de empleado', 'error');
        return false;
    }
    return true;
}