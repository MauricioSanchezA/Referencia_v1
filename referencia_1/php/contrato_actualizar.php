<?php
	require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['contrato_id']);


    /*== Verificando contrato ==*/
	$check_contrato=conexion();
	$check_contrato=$check_contrato->query("SELECT * FROM contrato WHERE contrato_id='$id'");

    if($check_contrato->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El contrato no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_contrato->fetch();
    }
    $check_contrato=null;

    /*== Almacenando datos ==*/
    $nombre=limpiar_cadena($_POST['contrato_nombre']);

    /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE DEL CONTRATO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    /*== Verificando nombre ==*/
    if($nombre!=$datos['contrato_nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT contrato_nombre FROM contrato WHERE contrato_nombre='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                El NOMBRE DEL CONTRATO ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }


    /*== Actualizar datos ==*/
    $actualizar_contrato=conexion();
    $actualizar_contrato=$actualizar_contrato->prepare("UPDATE contrato SET contrato_nombre=:nombre WHERE contrato_id=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":id"=>$id
    ];

    if($actualizar_contrato->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡CONTRATO ACTUALIZADO!</strong><br>
                El contrato se actualizo con exito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo actualizar el contrato, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_contrato=null;