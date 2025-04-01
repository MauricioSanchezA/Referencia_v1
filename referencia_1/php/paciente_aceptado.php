<?php
    require_once "main.php";

    /*== Almacenando id ==*/
    if (!isset($_POST['paciente_id'])) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se ha enviado el ID del paciente
            </div>
        ';
        exit();
    }
    $id = limpiar_cadena($_POST['paciente_id']);
    // Mostrar los datos recibidos
    var_dump($_POST);

    /*== Verificando paciente ==*/
    $check_paciente_aceptado = conexion();
    $check_paciente_aceptado = $check_paciente_aceptado->query("SELECT * FROM paciente WHERE paciente_id='$id'");

    if ($check_paciente_aceptado->rowCount() <= 0) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El paciente no existe en el sistema
            </div>
        ';
        exit();
    } else {
        $datos = $check_paciente_aceptado->fetch();
    }
    $check_paciente_aceptado = null;

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
    $dia_creacion = date('Y-m-d');
    $codigo = limpiar_cadena($_POST['codigo']);
    $num_cama = limpiar_cadena($_POST['num_cama']);
    $remitido_por = limpiar_cadena($_POST['remitido_por']);
    $fecha_entrada = date('Y-m-d');
    $fecha_salida = date('Y-m-d');
    $categoria_id = limpiar_cadena($_POST['categoria_id']);
    $producto_id = limpiar_cadena($_POST['producto_id']);

    /*== Verificando campos obligatorios ==*/
    if ($tipodoc == "" || $numdoc == "" || $nacimiento == "" || $nombre == "" || $apellido == "" || $eps == "" || $contrato == "" || $especialidad == "" || $pac_novedad == "" || $estado == "" || $oxigeno == "" || $dia_creacion == "" || $codigo == "" || $num_cama == "" || $remitido_por == "" || $fecha_entrada == "" || $fecha_salida == "" || $categoria_id == "" || $producto_id == "") {
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
                La EPS no coincide con el formato solicitado
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

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,500}", $pac_novedad)) {
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

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,500}", $num_cama)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NUMERO DE CAMA no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if (verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,500}", $remitido_por)) {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El REMITIDO POR no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Actualizar datos ==*/
    $actualizar_paciente_aceptado = conexion();
    $actualizar_paciente_aceptado = $actualizar_paciente_aceptado->prepare("UPDATE paciente_aceptado SET paciente_tipodoc=:tipodoc, paciente_numdoc=:numdoc, paciente_nacimiento=:nacimiento, paciente_nombre=:nombre, paciente_apellido=:apellido, paciente_eps=:eps, paciente_contrato=:contrato, paciente_especialidad=:especialidad, paciente_novedad=:pac_novedad, paciente_estado=:estado, paciente_oxigeno=:oxigeno, categoria_id=:categoria_id, producto_id=:producto_id, dia_creacion=:dia_creacion, codigo=:codigo, num_cama=:num_cama, remitido_por=:remitido_por, fecha_entrada=:fecha_entrada, fecha_salida=:fecha_salida WHERE paciente_id=:id");

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
        ":id" => $id,
        ":dia_creacion" => $dia_creacion,
        ":codigo" => $codigo,
        ":num_cama" => $num_cama,
        ":remitido_por" => $remitido_por,
        ":fecha_entrada" => $fecha_entrada,
        ":fecha_salida" => $fecha_salida
    ];

    if ($actualizar_paciente_aceptado->execute($marcadores)) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡PACIENTE ACEPTADO Y ACTUALIZADO!</strong><br>
                El paciente se actualizo con exito
            </div>
        ';
    } else {
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el paciente, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_paciente_aceptado = null;