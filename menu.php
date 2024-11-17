<!-- menu.php -->
<nav class="navbar navbar-dark bg-dark vh-100 flex-column p-3 fixed-top collapse-horizontal" style="width: 250px;" id="sideMenu">
    <div class="d-flex justify-content-between align-items-center">
        <a href="index.php" class="navbar-brand mb-4 text-white">Menú</a>
        <button class="navbar-toggler d-lg-none" type="button" onclick="toggleMenu()">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <ul class="navbar-nav flex-column w-100">
        <!-- Dropdown para CRUD de Empleados -->
        <li class="nav-item dropdown w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="empleadosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Empleados
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="empleadosDropdown">
            <li><a class="dropdown-item text-white" href="/planillas/views/empleados/ver_empleados.php">Ver Empleados</a></li>
            <li><a class="dropdown-item text-white" href="/planillas/views/agregar_empleado.php">Agregar Empleado</a></li>
            </ul>

        <!-- Dropdown para CRUD de Tipos de Empleado -->
        <li class="nav-item dropdown mt-3 w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="tipoEmpleadoDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tipos de Empleado
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="tipoEmpleadoDropdown">
                <li><a class="dropdown-item text-white" href="/planillas/views/tipo_empleados.php">Ver Tipos</a></li>
                <li><a class="dropdown-item text-white" href="/planillas/views/agregar_empleado.php">Agregar Tipo</a></li>
            </ul>
        </li>

        <!-- Dropdown para CRUD de Usuarios -->
        <li class="nav-item dropdown mt-3 w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="usuariosDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Usuarios
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="usuariosDropdown">
                <li><a class="dropdown-item text-white" href="/planillas/views/usuarios.php">Ver Usuarios</a></li>
            </ul>
        </li>

        <!-- Dropdown para Bono 14 -->
        <li class="nav-item dropdown mt-3 w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="bono14Dropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Bono 14
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="bono14Dropdown">
                <li><a class="dropdown-item text-white" href="/planillas/views/bono14/ver_bono14.php">Ver Bonos</a></li>
                <li><a class="dropdown-item text-white" href="/planillas/views/bono14/calcular_bono14.php">Calcular Bono</a></li>
            </ul>
        </li>

        <!-- Dropdown para Anticipos -->
        <li class="nav-item dropdown mt-3 w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="anticiposDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Anticipos
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="anticiposDropdown">
                <li><a class="dropdown-item text-white" href="/planillas/views/anticipos/ver_anticipos.php">Ver Anticipos</a></li>
                <li><a class="dropdown-item text-white" href="/planillas/views/anticipos/generar_anticipo.php">Generar Anticipo</a></li>
            </ul>
        </li>

        <!-- Dropdown para Horas Extra -->
        <li class="nav-item dropdown mt-3 w-100">
            <a class="nav-link dropdown-toggle text-white w-100" href="#" id="horasExtraDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Horas Extra
            </a>
            <ul class="dropdown-menu bg-dark w-100" aria-labelledby="horasExtraDropdown">
                <li><a class="dropdown-item text-white" href="/planillas/views/horas_extra/ver_horas.php">Ver Horas Extra</a></li>
                <li><a class="dropdown-item text-white" href="/planillas/views/horas_extra/registrar_horas.php">Registrar Horas</a></li>
            </ul>
        </li>

        <!-- Nuevo Dropdown para Ventas y Comisiones -->
        <a class="nav-link dropdown-toggle text-white w-100" href="#" id="ventasDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        <li class="nav-item dropdown mt-3 w-100">
        Ventas y Comisiones
        <ul class="dropdown-menu bg-dark w-100" aria-labelledby="ventasDropdown">
        </a>
        <li><a class="dropdown-item text-white" href="../planillas/views/ventas/ver_ventas.php">Ver Ventas</a></li>
        <li><a class="dropdown-item text-white" href="views/ventas/registrar_venta.php">Registrar Venta</a></li>
        <li><a class="dropdown-item text-white" href="views/ventas/ver_comisiones.php">Ver Comisiones</a></li>
    </ul>
</li>
    </ul>

    <hr class="text-white">

    <!-- Opciones de Autenticación -->
    <ul class="navbar-nav flex-column mt-auto w-100">
        <li class="nav-item mt-3 w-100">
            <a href="/planillas/views/registro.php" class="nav-link text-white w-100">Registrarse</a>
        </li>
        <li class="nav-item mt-3 w-100">
            <a href="/planillas/views/login.php" class="nav-link text-white w-100">Iniciar Sesión</a>
        </li>
    </ul>
</nav>

<style>
/* Solo agregamos los estilos de responsividad, manteniendo tus estilos existentes */
@media (max-width: 992px) {
    #sideMenu {
        width: 0 !important;
        padding: 0 !important;
        overflow: hidden;
        transition: all 0.3s ease;
        transform: translateX(-100%);
    }

    #sideMenu.show {
        width: 250px !important;
        padding: 1rem !important;
        transform: translateX(0);
    }
}

.content-wrapper {
    margin-left: 250px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    padding: 20px;
}

@media (max-width: 992px) {
    .content-wrapper {
        margin-left: 0;
    }
}
</style>

<script>
function toggleMenu() {
    const menu = document.getElementById('sideMenu');
    menu.classList.toggle('show');
}

document.addEventListener('click', function(event) {
    const menu = document.getElementById('sideMenu');
    const targetElement = event.target;
    
    if (window.innerWidth < 992 && 
        !menu.contains(targetElement) && 
        !targetElement.classList.contains('navbar-toggler') &&
        !targetElement.classList.contains('navbar-toggler-icon')) {
        menu.classList.remove('show');
    }
});
</script>
