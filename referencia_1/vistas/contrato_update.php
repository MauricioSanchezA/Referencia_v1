<div class="container is-fluid mb-6">
    <h1 class="title">Contratos</h1>
    <h2 class="subtitle">Actualizar Contratos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
    include "./inc/btn_back.php";

    require_once "./php/main.php";

    $id = (isset($_GET['contrato_id_up'])) ? $_GET['contrato_id_up'] : 0;
    $id = limpiar_cadena($id);

    /*== Verificando contrato ==*/
    $check_contrato = conexion();
    $check_contrato = $check_contrato->query("SELECT * FROM contrato WHERE contrato_id='$id'");

    if ($check_contrato->rowCount() > 0) {
        $datos = $check_contrato->fetch();
    ?>

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/contrato_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">

        <input type="hidden" name="contrato_id" value="<?php echo $datos['contrato_id']; ?>" required>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Contrato</label>
                    <input class="input" type="text" name="contrato_nombre" placeholder="Ingrese nombre nuevo del contrato" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['contrato_nombre']; ?>">
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button type="submit" class="button is-success is-rounded">Actualizar</button>
        </p>
    </form>
    <?php
    } else {
        include "./inc/error_alert.php";
    }
    $check_contrato = null;
    ?>
</div>