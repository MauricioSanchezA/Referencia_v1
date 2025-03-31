<div class="container is-fluid mb-6">
    <h1 class="title">Contratos</h1>
    <h2 class="subtitle">Lista de Contratos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar categoria #
        if(isset($_GET['contrato_id_del'])){
            require_once "./php/contrato_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $categoria_id = (isset($_GET['contrato_id'])) ? $_GET['contrato_id'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=contrato_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador categoria #
        require_once "./php/contrato_lista.php";
    ?>
</div>