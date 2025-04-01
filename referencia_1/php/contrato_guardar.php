<?php
require_once "main.php";

/*== Almacenando datos ==*/
$nombre = limpiar_cadena($_POST['contrato_nombre']);

/*== Verificando campos obligatorios ==*/
if ($nombre == "") {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No has llenado todos los campos que son obligatorios
        </div>
    ';
    exit();
}

/*== Verificando integridad de los datos ==*/
if (verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}", $nombre)) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE DEL CONTRATO no coincide con el formato solicitado
        </div>
    ';
    exit();
}

/*== Verificando nombre ==*/
$check_nombre = conexion();
$check_nombre = $check_nombre->query("SELECT contrato_nombre FROM contrato WHERE contrato_nombre='$nombre'");
if ($check_nombre->rowCount() > 0) {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            El NOMBRE DEL CONTRATO ingresado ya se encuentra registrado, por favor elija otro
        </div>
    ';
    exit();
}
$check_nombre = null;

/*== Guardando datos ==*/
$guardar_contrato = conexion();
$guardar_contrato = $guardar_contrato->prepare("INSERT INTO contrato(contrato_nombre) VALUES(:nombre)");

$marcadores = [
    ":nombre" => $nombre
];

$guardar_contrato->execute($marcadores);

if ($guardar_contrato->rowCount() == 1) {
    echo '
        <div class="notification is-info is-light">
            <strong>¡CONTRATO REGISTRADO!</strong><br>
            El contrato se registró con éxito
        </div>
    ';
} else {
    echo '
        <div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>
            No se pudo registrar el contrato, por favor intente nuevamente
        </div>
    ';
}
$guardar_contrato = null;
?>