<div class="container is-fluid mb-6">
    <h1 class="title">EPS</h1>
    <h2 class="subtitle">Lista de EPS por Especialidad</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";
    ?>
    <div class="columns">
        <!-- Columna para el nombre de la categoría, con clase personalizada -->
        <div class="column name-column">
            <h2 class="title has-text-centered">Especialidad</h2>
            <?php
                $categorias=conexion(); 
                $categorias=$categorias->query("SELECT * FROM categoria");
                if($categorias->rowCount()>0){
                    $categorias=$categorias->fetchAll();
                    foreach($categorias as $row){
                        echo '<a href="index.php?vista=product_category&category_id='.$row['categoria_id'].'" class="button is-link is-inverted is-fullwidth">'.$row['categoria_nombre'].'</a>';
                    }
                }else{
                    echo '<p class="has-text-centered">No hay Especialidad registrada</p>';
                }
                $categorias=null;
            ?>
        </div>

        <!-- Columna para la categoría seleccionada (nombre y ubicación), con clase personalizada -->
        <div class="column location-column">
            <?php
                $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

                /*== Verificando categoria ==*/
                $check_categoria=conexion();
                $check_categoria=$check_categoria->query("SELECT * FROM categoria WHERE categoria_id='$categoria_id'");

                if($check_categoria->rowCount()>0){

                    $check_categoria=$check_categoria->fetch();

                    echo '
                        <h2 class="title has-text-centered">'.$check_categoria['categoria_nombre'].'</h2>
                        <p class="has-text-centered pb-6">'.$check_categoria['categoria_ubicacion'].'</p>
                    ';

                    require_once "./php/main.php";

                    # Eliminar producto #
                    if(isset($_GET['product_id_del'])){
                        require_once "./php/producto_eliminar.php";
                    }

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    }

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=product_category&category_id=$categoria_id&page=";
                    $registros=15;
                    $busqueda="";

                    # Paginador producto #
                    require_once "./php/producto_lista.php";

                }else{
                    echo '<h6 class="has-text-centered title"></h6>';
                }
                $check_categoria=null;
            ?>
        </div>
    </div>
</div>
<style>
    /* Ajuste el contenedor para hacer que las columnas sean más flexibles */
.container {
    width: 100%;
    justify-content: space-between;
    gap: 20px; /* Añade un espacio entre las columnas */
}

.column.name-column {
    flex: 1; /* Tomará el espacio disponible */
    max-width: 50%; /* La columna ocupará el 50% del ancho del contenedor */
    margin: 0 auto; /* Centra la columna horizontalmente */
    text-align: center; /* Centra el contenido dentro de la columna */
}

/* Columna para la ubicación de la categoría */
.column.location-column {
    flex: 2; /* Toma el 2/3 del espacio disponible */
    max-width: 100%; /* Asegura que no se expanda más allá de dos tercios del contenedor */
}

/* Ajustes adicionales para que la columna de ubicación ocupe más espacio en pantallas grandes */
@media (min-width: 1024px) {
    .column.name-column {
        flex: 1 1 33%;
    }
    
    .column.location-column {
        flex: 2 1 66%;
    }
}

/* Para pantallas pequeñas, las columnas ocuparán el 100% */
@media (max-width: 768px) {
    .column {
        flex: 1 1 100%;
    }
}

</style>
