<div class="container is-fluid mb-4">
    <h1 class="title">Pacientes</h1>
    <h2 class="subtitle">Lista de Pacientes ACEPTADOS</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar producto #
        if (isset($_GET['pacientacept_id_del'])) {
            require_once "./php/pacienteaceptado_eliminar.php";
        }

        # Validar el parámetro 'page' #
        if (!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] <= 0) {
            $pagina = 1;
        } else {
            $pagina = (int) $_GET['page'];
        }

        # Limpiar el parámetro 'page' #
        $pagina = limpiar_cadena($pagina);

        # Configuración de la paginación #
        $url = "index.php?vista=pacientacept_list&page="; // Base de la URL para la paginación
        $registros = 10; // Número de registros por página
        $busqueda = ""; // Parámetro de búsqueda (vacío por ahora)

        # Incluir el archivo que genera la lista y la paginación #
        require_once "./php/pacienteaceptado_lista.php";
    ?>
</div>