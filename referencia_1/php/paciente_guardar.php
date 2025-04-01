<?php
    require_once "./main.php";

    /*== Almacenando datos ==*/
    $tipodoc = limpiar_cadena($_POST['paciente_tipodoc']);
    $numdoc = limpiar_cadena($_POST['paciente_numdoc']);
    $nacimiento = limpiar_cadena($_POST['paciente_nacimiento']);
    $nombre = limpiar_cadena($_POST['paciente_nombre']);
    $apellido = limpiar_cadena($_POST['paciente_apellido']);
    $eps = limpiar_cadena($_POST['paciente_eps']);
    $contrato = limpiar_cadena($_POST['paciente_contrato']);
    $especialidad = limpiar_cadena($_POST['paciente_especialidad']);
    $pac_novedad = limpiar_cadena($_POST['paciente_novedad']);
    $estado = limpiar_cadena($_POST['paciente_estado']);
    $oxigeno = limpiar_cadena($_POST['paciente_oxigeno']);
    $categoria_id = limpiar_cadena($_POST['categoria_id']);
    $producto_id = limpiar_cadena($_POST['producto_id']);
    $dia_creacion = date('Y-m-d');  // Esto establecerá la fecha actual en el formato YYYY-MM-DD

    /*== Verificando campos obligatorios ==*/
    if ($tipodoc == "" || $numdoc == "" || $nacimiento == "" || $nombre == "" || $apellido == "" || $eps == "" || $contrato == "" || $especialidad == "" || $pac_novedad == "" || $estado == "" || $oxigeno == "" || $categoria_id == "" || $producto_id == "") {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    /*== Verificando integridad de los datos ==*/
    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $nombre)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $apellido)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El APELLIDO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $eps)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La EPS no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $contrato)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CONTRATO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}", $especialidad)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La ESPECIALIDAD no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,500}", $pac_novedad)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La NOVEDAD no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}", $estado)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El ESTADO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if ($oxigeno !== 'Si' && $oxigeno !== 'No') {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El campo OXÍGENO debe ser "Si" o "No"
            </div>
        ';
        exit();
    }

    /*== Verificando si la EPS existe en la base de datos ==*/
    $check_eps = conexion();
    $check_eps = $check_eps->prepare("SELECT producto_nombre FROM producto WHERE producto_nombre = :eps");
    $check_eps->execute([':eps' => $eps]);

    if ($check_eps->rowCount() == 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La EPS ingresada no existe en la base de datos
            </div>
        ';
        exit();
    }
    $check_eps = null;

    /*== Guardando datos ==*/
    $guardar_paciente = conexion();
    $guardar_paciente = $guardar_paciente->prepare("INSERT INTO paciente(paciente_tipodoc, paciente_numdoc, paciente_nacimiento, paciente_nombre, paciente_apellido, paciente_eps, paciente_contrato, paciente_especialidad, paciente_novedad, paciente_estado, paciente_oxigeno, categoria_id, producto_id, dia_creacion) VALUES(:tipodoc, :numdoc, :nacimiento, :nombre, :apellido, :eps, :contrato, :especialidad, :pac_novedad, :estado, :oxigeno, :categoria_id, :producto_id, :dia_creacion)");

    $marcadores = [
        ":tipodoc" => $tipodoc,
        ":numdoc" => $numdoc,
        ":nacimiento" => $nacimiento,
        ":nombre" => $nombre,
        ":apellido" => $apellido,
        ":eps" => $eps,
        ":contrato" => $contrato,
        ":especialidad" => $especialidad,
        ":pac_novedad" => $pac_novedad,
        ":estado" => $estado,
        ":oxigeno" => $oxigeno,
        ":categoria_id" => $categoria_id,
        ":producto_id" => $producto_id,
        ":dia_creacion" => $dia_creacion,
    ];

    $guardar_paciente->execute($marcadores);

    if ($guardar_paciente->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡PACIENTE REGISTRADO!</strong><br>
                El paciente se registró con éxito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar el paciente, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_paciente = null;
    
?>
