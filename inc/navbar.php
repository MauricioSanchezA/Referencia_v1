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
<!-- Menú de primer nivel para "opciones" -->
<nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand">
        <div class="navbar-image">
            <!-- La imagen ahora es un fondo -->
            <img src="./img/logo_4.png" alt="Logo" width="100" height="95">
        </div>

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

/* Asegurarse de que el navbar tiene altura suficiente */
.navbar {
    position: relative; /* Necesario para manejar el contenedor de la imagen de fondo */
    padding-top: 20px;
    padding-bottom: 20px;
    height: 100px; /* Ajusta la altura de tu navbar según sea necesario */
}

/* Contenedor de la imagen */
.navbar-image {
    background-image: url('./img/logo_4.png'); /* Aquí va la ruta de tu imagen */
    background-size: cover;
    background-position: center; /* Centra la imagen */
    height: 100%; /* Asegura que la imagen cubra toda la altura del navbar */
    width: 100%; /* Asegura que ocupe todo el ancho */
}

/* Estilo adicional para la imagen si es necesario */
.navbar-item img {
    display: block;
    max-width: 100%;
    height: auto;
}

/* Efectos de hover y estilo del navbar */
.navbar-item a.navbar-link:hover, .navbar-item a.navbar-item:hover {
    background-color: #e3f6ff;
    color: #006400;
    transform: scale(1.2);
    transition: transform 0.3s, color 0.3s;
}

/* Asegurar que los submenús se alineen correctamente */
.navbar-item.has-dropdown.is-hoverable.is-right .navbar-dropdown {
    left: 100%;
    top: 0;
    margin-left: -1px;
}

/* Efecto de rotación para la flecha */
.navbar-link .icon i {
    transition: transform 0.3s ease;
}

.navbar-item.has-dropdown.is-active .navbar-link .icon i {
    transform: rotate(45deg);
}

.navbar-dropdown {
    display: none;
}

.navbar-item.has-dropdown.is-active .navbar-dropdown {
    display: block;
}
</style>