<?php
    /*== Función para limpiar cadena ==*/
    $pacient_id_del = limpiar_cadena($_GET['pacient_id_del']);

    /*== Almacenando datos ==*/
    $pacient_id_del=limpiar_cadena($_GET['pacient_id_del']);

    /*== Verificando usuario ==*/
    $check_paciente=conexion();
    $check_paciente=$check_paciente->query("SELECT paciente_id FROM paciente WHERE paciente_id='$pacient_id_del'");
    
    if ($check_paciente->rowCount() == 1) {
        $eliminar_paciente = conexion();
        $eliminar_paciente = $eliminar_paciente->prepare("DELETE FROM paciente WHERE paciente_id=:id");
    
        $eliminar_paciente->execute([":id" => $pacient_id_del]);
    
        if ($eliminar_paciente->rowCount() == 1) {
            echo '
                <div class="notification is-info is-light">
                    <strong>¡PACIENTE ELIMINADO!</strong><br>
                    Los datos del paciente se eliminaron con éxito
                </div>
            ';
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No se pudo eliminar el paciente, por favor intente nuevamente
                </div>
            ';
        }
        $eliminar_paciente = null;
        } else {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    El paciente que intenta eliminar no existe
                </div>
            ';
        }
        $check_paciente = null;
    ?>
    