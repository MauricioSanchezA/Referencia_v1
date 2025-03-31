<?php
	require_once "../inc/session_start.php";

	require_once "main.php";

	/*== Almacenando datos ==*/
	$codigo=limpiar_cadena($_POST['producto_codigo']);
	$nombre=limpiar_cadena($_POST['producto_nombre']);

	$precio=limpiar_cadena($_POST['producto_precio']);
	$stock=limpiar_cadena($_POST['producto_stock']);
	$categoria=limpiar_cadena($_POST['producto_categoria']);


	/*== Verificando campos obligatorios ==*/
    if($codigo=="" || $nombre=="" || $precio=="" || $stock=="" || $categoria==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }


    /*== Verificando integridad de los datos ==*/
    if(verificar_datos("[a-zA-Z0-9- ]{1,70}",$codigo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CODIGO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE DE LA EPS no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$precio)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El MUNICIPIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}",$stock)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El DEPARTAMENTO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }


    /*== Verificando codigo ==*/
    $check_codigo=conexion();
    $check_codigo=$check_codigo->query("SELECT producto_codigo FROM producto WHERE producto_codigo='$codigo'");
    if($check_codigo->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El CODIGO ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_codigo=null;


    /*== Verificando nombre ==*/
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT producto_nombre FROM producto WHERE producto_nombre='$nombre'");
    if($check_nombre->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;


    /*== Verificando categoria ==*/
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT categoria_id FROM categoria WHERE categoria_id='$categoria'");
    if($check_categoria->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La ESPECIALIDAD seleccionada no existe
            </div>
        ';
        exit();
    }
    $check_categoria=null;


    /* Directorios de imagenes */
    $img_dir = '../img/producto/';

    /* Imagen predefinida */
    $producto_foto = './img/producto.png';  // La imagen siempre será la misma

    //echo $producto_foto;  // imprime la ruta de "./img/producto.png"

    /*== Comprobando si se ha seleccionado una imagen y asegurándose de que sea la correcta ==*/
    if (isset($_FILES['producto_foto']) && $_FILES['producto_foto']['name'] != "") {

        /* Comprobamos que el nombre del archivo sea exactamente 'producto.png' */
        if ($_FILES['producto_foto']['name'] != "producto.png") {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado no es la imagen correcta. Por favor, seleccione la imagen "producto.png".
                </div>
            ';
            exit();
        }

        /* Comprobando formato de las imagenes */
        if (mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/jpeg" && mime_content_type($_FILES['producto_foto']['tmp_name']) != "image/png") {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado es de un formato que no está permitido
                </div>
            ';
            exit();
        }

        /* Comprobando que la imagen no supere el peso permitido */
        if (($_FILES['producto_foto']['size'] / 1024) > 3072) {  // 3072 KB = 3MB
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    La imagen que ha seleccionado supera el límite de peso permitido
                </div>
            ';
            exit();
        }

        /* Extensión de la imagen */
        switch (mime_content_type($_FILES['producto_foto']['tmp_name'])) {
            case 'image/jpeg':
                $img_ext = ".jpg";
                break;
            case 'image/png':
                $img_ext = ".png";
                break;
        }

        /* Cambiando permisos al directorio */
        chmod($img_dir, 0777);

        /* Nombre de la imagen */
        $img_nombre = renombrar_fotos($nombre);  // Asegúrate de que esta función esté definida

        /* Nombre final de la imagen */
        $foto = $img_nombre . $img_ext;

        /* Moviendo imagen al directorio */
        if (!move_uploaded_file($_FILES['producto_foto']['tmp_name'], $img_dir . $foto)) {
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
                </div>
            ';
            exit();
        }

    } else {
        /* Si no se ha subido una imagen, usa la imagen predeterminada */
        $foto = "producto.png";  // La imagen que se guarda será la misma
    }

    /*== Guardando datos en la base de datos ==*/
    $guardar_producto = conexion();
    $guardar_producto = $guardar_producto->prepare("INSERT INTO producto(producto_codigo, producto_nombre, producto_precio, producto_stock, producto_foto, categoria_id, usuario_id) VALUES(:codigo, :nombre, :precio, :stock, :foto, :categoria, :usuario)");

    $marcadores = [
        ":codigo" => $codigo,
        ":nombre" => $nombre,
        ":precio" => $precio,
        ":stock" => $stock,
        ":foto" => $foto,
        ":categoria" => $categoria,
        ":usuario" => $_SESSION['id']
    ];

    $guardar_producto->execute($marcadores);

    if ($guardar_producto->rowCount() == 1) {
        echo '
            <div class="notification is-info is-light">
                <strong>¡EPS REGISTRADA!</strong><br>
                La EPS se registró con éxito
            </div>
        ';
    } else {
        /* Si hubo un error, eliminamos la imagen subida, si se subió una */
        if (isset($foto) && is_file($img_dir . $foto)) {
            chmod($img_dir . $foto, 0777);
            unlink($img_dir . $foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No se pudo registrar la EPS, por favor intente nuevamente
            </div>
        ';
    }

    $guardar_producto = null;
