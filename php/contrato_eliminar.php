<?php
require_once "main.php";

/*== Almacenando datos ==*/
$contrato_id_del = limpiar_cadena($_GET['contrato_id_del']);

/*== Verificando contrato ==*/
$check_contrato = conexion();
$check_contrato = $check_contrato->query("SELECT contrato_id FROM contrato WHERE contrato_id='$contrato_id_del'");

if ($check_contrato->rowCount() == 1) {
    $eliminar_contrato = conexion();
    $eliminar_contrato = $eliminar_contrato->prepare("DELETE FROM contrato WHERE contrato_id=:id");

    $eliminar_contrato->execute([":id" => $contrato_id_del]);

    if ($eliminar_contrato->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡CONTRATO ELIMINADO!</strong><br>
                Los datos del contrato se eliminaron con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo eliminar el contrato, por favor intente nuevamente
            </div>
        ';
    }
    $eliminar_contrato = null;
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El contrato que intenta eliminar no existe
        </div>
    ';
}
$check_contrato = null;
?>