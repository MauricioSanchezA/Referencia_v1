<?php
// Iniciar la sesión solo si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start(); // Inicia la sesión si no está activa
}


// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['id'])) {
    // Si no está logueado, redirige a la página de inicio de sesión
    header("Location: index.php?vista=login");
    exit();
}
?>

<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <a class="navbar-item" href="index.php?vista=home">
            <img src="./img/logo_3.png" width="160" height="160">
        </a>

        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasicExample">
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
            <span aria-hidden="true"></span>
        </a>
    </div>

    <div id="navbarBasicExample" class="navbar-menu">
        <div class="navbar-start">
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Administrador'): ?>
                <div class="navbar-item has-dropdown is-hoverable">
                    <a class="navbar-link">Usuarios</a>
                    <div class="navbar-dropdown">
                        <a href="index.php?vista=user_new" class="navbar-item">Nuevo</a>
                        <a href="index.php?vista=user_list" class="navbar-item">Lista</a>
                        <a href="index.php?vista=user_search" class="navbar-item">Buscar</a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Paciente</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=pacient_new" class="navbar-item">Nuevo</a>
                    
                    <!-- Menú de segundo nivel para "Buscar" -->
                    <div class="navbar-item has-dropdown is-hoverable is-right">
                        <a class="navbar-link">
                            Buscar
                            <span class="icon is-small">
                                <i class="fas fa-angle-right"></i>
                            </span>
                        </a>
                        <div class="navbar-dropdown">
                            <a href="index.php?vista=pacientacept_search" class="navbar-item">Aceptados</a>
                            <a href="index.php?vista=pacient_search" class="navbar-item">Pendientes</a>
                        </div>
                    </div>

                    <a href="index.php?vista=pacient_urgency" class="navbar-item">Urgencias</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Especialidades</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=category_new" class="navbar-item">Nueva</a>
                    <a href="index.php?vista=category_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=category_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Contrato</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=contrato_new" class="navbar-item">Nueva</a>
                    <a href="index.php?vista=contrato_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=contrato_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">EPS</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=product_new" class="navbar-item">Nuevo</a>
                    <a href="index.php?vista=product_list" class="navbar-item">Lista</a>
                    <a href="index.php?vista=product_category" class="navbar-item">Por Especialidades</a>
                    <a href="index.php?vista=product_search" class="navbar-item">Buscar</a>
                </div>
            </div>

            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link">Reportes</a>
                <div class="navbar-dropdown">
                    <a href="index.php?vista=pacient_list" class="navbar-item">Pendientes</a>
                    <a href="index.php?vista=pacientacept_list" class="navbar-item">Aceptados</a>
                    <a href="index.php?vista=pacientclose_list" class="navbar-item">Cerrados</a>
                </div>
            </div>
        </div>

        <div class="navbar-end">
            <div class="navbar-item">
                <div class="buttons">
                    <a href="index.php?vista=user_update&user_id_up=<?php echo $_SESSION['id']; ?>" class="button is-primary is-rounded">
                        Mi cuenta
                    </a>

                    <a href="index.php?vista=logout" class="button is-link is-rounded">
                        Salir
                    </a>
                </div>
            </div>
        </div>
    </div>
</nav>
 

<style>

/* Cambiar color y aplicar efecto de escala al pasar el mouse */
.navbar-item a.navbar-link:hover, .navbar-item a.navbar-item:hover {
    background-color: #e3f6ff; /* Fondo claro */
    color: #006400; /* Verde oscuro */
    transform: scale(1.2); /* Efecto de zoom */
    transition: transform 0.3s, color 0.3s; /* Transición suave */
}

/* Asegurar que los submenús se alineen correctamente */
.navbar-item.has-dropdown.is-hoverable.is-right .navbar-dropdown {
    left: 100%; /* Desplazar el submenú hacia la derecha */
    top: 0; /* Alinear con el ítem padre */
    margin-left: -1px; /* Eliminar el espacio entre los menús */
}

/* Rotar la flecha hacia la derecha */
.navbar-link .icon i {
    transition: transform 0.3s ease; /* Transición suave */
}

/* Rotar la flecha hacia abajo cuando el menú está activo */
.navbar-item.has-dropdown.is-active .navbar-link .icon i {
    transform: rotate(45deg); /* Rotar la flecha hacia abajo */
}
.navbar-dropdown {
    display: none;
}

.navbar-item.has-dropdown.is-active .navbar-dropdown {
    display: block;
}
</style>