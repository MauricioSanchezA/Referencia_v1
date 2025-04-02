<?php
    // Validar el parámetro 'page' recibido desde la URL
    $pagina = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $pagina = ($pagina > 0) ? $pagina : 1;

    // Calcular el inicio para la consulta SQL
    $inicio = ($pagina > 0) ? (($pagina * $registros) - $registros) : 0;

    // Inicializar la tabla
    $tabla = "";

    // Construir las consultas SQL
    if (isset($busqueda) && $busqueda != "") {
        $consulta_datos = "SELECT * FROM paciente_aceptado 
                           WHERE paciente_numdoc LIKE :busqueda 
                              OR paciente_nombre LIKE :busqueda 
                              OR paciente_apellido LIKE :busqueda 
                           ORDER BY paciente_nombre ASC 
                           LIMIT :inicio, :registros";

        $consulta_total = "SELECT COUNT(paciente_id) 
                           FROM paciente_aceptado 
                           WHERE paciente_numdoc LIKE :busqueda 
                              OR paciente_nombre LIKE :busqueda 
                              OR paciente_apellido LIKE :busqueda";
    } else {
        $consulta_datos = "SELECT * FROM paciente_aceptado 
                           ORDER BY paciente_nombre ASC 
                           LIMIT :inicio, :registros";

        $consulta_total = "SELECT COUNT(paciente_id) 
                           FROM paciente_aceptado";
    }

    // Conexión a la base de datos
    $conexion = conexion();

    // Preparar y ejecutar la consulta de datos
    $stmt_datos = $conexion->prepare($consulta_datos);
    if (isset($busqueda) && $busqueda != "") {
        $stmt_datos->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
    }
    $stmt_datos->bindValue(':inicio', $inicio, PDO::PARAM_INT);
    $stmt_datos->bindValue(':registros', $registros, PDO::PARAM_INT);
    $stmt_datos->execute();
    $datos = $stmt_datos->fetchAll();

    // Preparar y ejecutar la consulta total
    $stmt_total = $conexion->prepare($consulta_total);
    if (isset($busqueda) && $busqueda != "") {
        $stmt_total->bindValue(':busqueda', "%$busqueda%", PDO::PARAM_STR);
    }
    $stmt_total->execute();
    $total = (int)$stmt_total->fetchColumn();

    // Calcular el número total de páginas
    $Npaginas = ceil($total / $registros);

    // Construir la tabla
    $tabla .= '
    <div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
                    <th>Codigo</th>
                    <th>Tipo ID</th>
                    <th>Identificacion</th>
                    <th>Fecha Nacimiento</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>EPS</th>
                    <th>Contrato EPS</th>
                    <th>Especialidad</th>
                    <th>Novedades</th>
                    <th>Estado</th>
                    <th>Oxigeno</th>
                    <th>Numero cama</th>
                    <th>Remitido Por</th>
                    <th>Dia creación</th>
                    <th>Fecha entrada</th>
                    <th>Fecha salida</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
    ';

    if ($total >= 1 && $pagina <= $Npaginas) {
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach ($datos as $rows) {
            $tabla .= '
                <tr class="has-text-centered">
                    <td>' . $contador . '</td>
                    <td>' . $rows['codigo'] . '</td>
                    <td>' . $rows['paciente_tipodoc'] . '</td>
                    <td>' . $rows['paciente_numdoc'] . '</td>
                    <td>' . $rows['paciente_nacimiento'] . '</td>
                    <td>' . $rows['paciente_nombre'] . '</td>
                    <td>' . $rows['paciente_apellido'] . '</td>
                    <td>' . $rows['paciente_eps'] . '</td>
                    <td>' . $rows['paciente_contrato'] . '</td>
                    <td>' . $rows['paciente_especialidad'] . '</td>
                    <td>' . $rows['paciente_novedad'] . '</td>
                    <td>' . $rows['paciente_estado'] . '</td>
                    <td>' . $rows['paciente_oxigeno'] . '</td>
                    <td>' . $rows['num_cama'] . '</td>
                    <td>' . $rows['remitido_por'] . '</td>
                    <td>' . $rows['dia_creacion'] . '</td>
                    <td>' . $rows['fecha_entrada'] . '</td>
                    <td>' . $rows['fecha_salida'] . '</td>
                    <td>
                        <a href="index.php?vista=pacientacept_update&pacientacept_id_up=' . $rows['paciente_id'] . '" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="' . $url . $pagina . '&pacientacept_id_del=' . $rows['paciente_id'] . '" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
        }
        $pag_final = $contador - 1;
    } else {
        if ($total >= 1) {
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="20">
                        <a href="' . $url . '1" class="button is-link is-rounded is-small mt-4 mb-4">
                            Haga clic acá para recargar el listado
                        </a>
                    </td>
                </tr>
            ';
        } else {
            $tabla .= '
                <tr class="has-text-centered">
                    <td colspan="20">
                        No hay registros en el sistema
                    </td>
                </tr>
            ';
        }
    }

    $tabla .= '</tbody></table></div>';

    if ($total > 0 && $pagina <= $Npaginas) {
        $tabla .= '<p class="has-text-right">Mostrando pacientes aceptados <strong>' . $pag_inicio . '</strong> al <strong>' . $pag_final . '</strong> de un <strong>total de ' . $total . '</strong></p>';
    }

    $conexion = null;
    echo $tabla;

    if ($total >= 1 && $pagina <= $Npaginas) {
        echo paginador_tablas($pagina, $Npaginas, $url, 7);
    }
?>