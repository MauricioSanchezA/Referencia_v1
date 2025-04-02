<div class="container is-fluid mb-4">
    <h1 class="title">EPS</h1>
    <h2 class="subtitle">Lista de EPS</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar producto #
        if (isset($_GET['product_id_del'])) {
            require_once "./php/producto_eliminar.php";
        }

        # Validar el parámetro 'page' #
        if (!isset($_GET['page']) || !is_numeric($_GET['page']) || $_GET['page'] <= 0) {
            $pagina = 1;
        } else {
            $pagina = (int) $_GET['page'];
        }

        # Validar el parámetro 'categoria_id' #
        $categoria_id = (isset($_GET['product_id']) && is_numeric($_GET['product_id'])) ? (int) $_GET['product_id'] : 0;

        # Limpiar el parámetro 'page' #
        $pagina = limpiar_cadena($pagina);

        # Configuración de la paginación #
        $url = "index.php?vista=product_list&page="; // Base de la URL para la paginación
        $registros = 10; // Número de registros por página
        $busqueda = ""; // Parámetro de búsqueda (vacío por ahora)

        # Incluir el archivo que genera la lista y la paginación #
        require_once "./php/producto_lista.php";
    ?>
</div>