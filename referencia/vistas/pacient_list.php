<div class="container is-fluid mb-4">
    <h1 class="title">Pacientes</h1>
    <h2 class="subtitle">Lista de Pacientes PENDIENTES</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar producto #
        if(isset($_GET['pacient_id_del'])){
            require_once "./php/paciente_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }

        $paciente_id = (isset($_GET['paciente_id'])) ? $_GET['paciente_id'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=pacient_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador producto #
        require_once "./php/paciente_lista.php";
    ?>
</div>