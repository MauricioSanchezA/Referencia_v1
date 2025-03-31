<?php
$inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;
$tabla = "";

$campos = "producto.producto_id,producto.producto_codigo,producto.producto_nombre,producto.producto_precio,producto.producto_stock,producto.producto_foto,producto.categoria_id,producto.usuario_id,categoria.categoria_id,categoria.categoria_nombre,usuario.usuario_id,usuario.usuario_nombre,usuario.usuario_apellido";

if (isset($busqueda) && $busqueda != "") {

    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id WHERE producto.producto_codigo LIKE '%$busqueda%' OR producto.producto_nombre LIKE '%$busqueda%' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto WHERE producto_codigo LIKE '%$busqueda%' OR producto_nombre LIKE '%$busqueda%'";

} elseif ($categoria_id > 0) {

    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id WHERE producto.categoria_id = '$categoria_id' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto WHERE categoria_id = '$categoria_id'";

} else {

    $consulta_datos = "SELECT $campos FROM producto INNER JOIN categoria ON producto.categoria_id = categoria.categoria_id INNER JOIN usuario ON producto.usuario_id = usuario.usuario_id ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";

    $consulta_total = "SELECT COUNT(producto_id) FROM producto";
}

$conexion = conexion();

$datos = $conexion->query($consulta_datos);
$datos = $datos->fetchAll();

$total = $conexion->query($consulta_total);
$total = (int)$total->fetchColumn();

$Npaginas = ceil($total / $registros);

if ($total >= 1 && $pagina <= $Npaginas) {
    $contador = $inicio + 1;
    $pag_inicio = $inicio + 1;

    // Inicia la tabla HTML
    $tabla .= '
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Código</th>
                    <th>Nombre EPS</th>
                    <th>Municipio</th>
                    <th>Departamento</th>
                    <th>Especialidad</th>
                    <th>Registrado Por</th>
                    <th colspan="3">Opciones</th>
                </tr>
            </thead>
            <tbody>
    ';

    foreach ($datos as $rows) {
        $tabla .= '
            <tr class="has-text-centered">
                <td>' . $contador . '</td>
                <td>' . $rows['producto_codigo'] . '</td>
                <td>' . $rows['producto_nombre'] . '</td>
                <td>' . $rows['producto_precio'] . '</td>
                <td>' . $rows['producto_stock'] . '</td>
                <td>' . $rows['categoria_nombre'] . '</td>
                <td>' . $rows['usuario_nombre'] . ' ' . $rows['usuario_apellido'] . '</td>
                <td>
                    <a href="index.php?vista=product_img&product_id_up=' . $rows['producto_id'] . '" class="button is-link is-rounded is-small">Imagen</a>
                </td>
                <td>
                    <a href="index.php?vista=product_update&product_id_up=' . $rows['producto_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                </td>
                <td>
                    <a href="' . $url . $pagina . '&product_id_del=' . $rows['producto_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
        ';
        $contador++;
    }

    $pag_final = $contador - 1;

    // Cierra la tabla
    $tabla .= '</tbody></table></div>';
} else {
    if ($total >= 1) {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="5">
                    <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                        Haga clic acá para recargar el listado
                    </a>
                </td>
            </tr>
        ';
    } else {
        $tabla .= '
            <tr class="has-text-centered">
                <td colspan="5">
                    No hay registros en el sistema
                </td>
            </tr>
        ';
    }
}

if ($total > 0 && $pagina <= $Npaginas) {
    $tabla .= '<p class="has-text-right">Mostrando productos <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
}

$conexion = null;
echo $tabla;

if ($total >= 1 && $pagina <= $Npaginas) {
    echo paginador_tablas($pagina, $Npaginas, $url, 7);
}
?>
