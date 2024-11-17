// Variables globales
let bonoSeleccionado = null;

// Función para cargar los empleados en el select del modal de agregar
async function cargarEmpleados() {
    try {
        const response = await fetch('/planillas/php/bono14.php?action=obtener_empleados');
        const empleados = await response.json();
        
        const selectEmpleado = document.getElementById('agregar-empleado');
        selectEmpleado.innerHTML = '<option value="">Seleccione un empleado</option>';
        
        empleados.forEach(empleado => {
            selectEmpleado.innerHTML += `
                <option value="${empleado.id_empleado}">
                    ${empleado.nombre_empleado}
                </option>`;
        });
    } catch (error) {
        console.error('Error al cargar empleados:', error);
        alert('Error al cargar la lista de empleados');
    }
}

// Función para guardar un nuevo bono
async function guardarNuevoBono() {
    try {
        const empleado = document.getElementById('agregar-empleado').value;
        const anio = document.getElementById('agregar-anio').value;
        const monto_total = document.getElementById('agregar-monto').value;

        if (!empleado || !anio || !monto_total) {
            alert('Por favor complete todos los campos');
            return;
        }

        const response = await fetch('/planillas/php/bono14.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'crear',
                id_empleado: empleado,
                anio: anio,
                monto_total: monto_total
            })
        });

        const result = await response.json();
        if (result.success) {
            alert('Bono agregado exitosamente');
            location.reload();
        } else {
            alert(result.message || 'Error al guardar el bono');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    }
}

// Función para mostrar modal de editar
async function editarBono(idEmpleado) {
    try {
        const response = await fetch(`/planillas/php/bono14.php?action=obtener_bono&id_empleado=${idEmpleado}`);
        const bono = await response.json();

        document.getElementById('editar-id-empleado').value = bono.id_empleado;
        document.getElementById('editar-anio').value = bono.anio;
        document.getElementById('editar-monto').value = bono.monto_total;

        const modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
        modalEditar.show();
    } catch (error) {
        console.error('Error:', error);
        alert('Error al cargar los datos del bono');
    }
}

// Función para guardar cambios de un bono
async function guardarCambiosBono() {
    try {
        const idEmpleado = document.getElementById('editar-id-empleado').value;
        const anio = document.getElementById('editar-anio').value;
        const monto_total = document.getElementById('editar-monto').value;

        const response = await fetch('/planillas/php/bono14.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                action: 'actualizar',
                id_empleado: idEmpleado,
                anio: anio,
                monto_total: monto_total
            })
        });

        const result = await response.json();
        if (result.success) {
            alert('Bono actualizado exitosamente');
            location.reload();
        } else {
            alert(result.message || 'Error al actualizar el bono');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al procesar la solicitud');
    }
}

// Función para pagar un bono
async function pagarBono(idEmpleado) {
    if (confirm('¿Está seguro que desea marcar este bono como pagado?')) {
        try {
            const response = await fetch('/planillas/php/bono14.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    action: 'pagar',
                    id_empleado: idEmpleado
                })
            });

            const result = await response.json();
            if (result.success) {
                alert('Bono marcado como pagado');
                location.reload();
            } else {
                alert(result.message || 'Error al procesar el pago');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error al procesar la solicitud');
        }
    }
}

// Inicializar cuando el documento esté listo
document.addEventListener('DOMContentLoaded', () => {
    // Cargar datos iniciales
    cargarEmpleados();

    // Event listener para el botón de agregar
    document.querySelector('.btn-agregar').addEventListener('click', () => {
        const modalAgregar = new bootstrap.Modal(document.getElementById('modalAgregarBono'));
        modalAgregar.show();
    });
});