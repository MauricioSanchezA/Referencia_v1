<?php
	$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
	$inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

	if(isset($busqueda) && $busqueda!=""){

		$consulta_datos="SELECT * FROM paciente WHERE paciente_numdoc LIKE '%$busqueda%' OR paciente_nombre LIKE '%$busqueda%' OR paciente_apellido LIKE '%$busqueda%' ORDER BY paciente_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(paciente_id) FROM paciente WHERE paciente_numdoc LIKE '%$busqueda%' OR paciente_nombre LIKE '%$busqueda%' OR paciente_apellido LIKE '%$busqueda%'";

	}else{

		$consulta_datos="SELECT * FROM paciente ORDER BY paciente_nombre ASC LIMIT $inicio,$registros";

		$consulta_total="SELECT COUNT(paciente_id) FROM paciente";
		
	}

	$conexion=conexion();

	$datos = $conexion->query($consulta_datos);
	$datos = $datos->fetchAll();

	$total = $conexion->query($consulta_total);
	$total = (int) $total->fetchColumn();

	$Npaginas =ceil($total/$registros);

	$tabla.='
	<div class="table-container">
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th>#</th>
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
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
	';

	if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows['paciente_tipodoc'].'</td>
                    <td>'.$rows['paciente_numdoc'].'</td>
                    <td>'.$rows['paciente_nacimiento'].'</td>
                    <td>'.$rows['paciente_nombre'].'</td>
                    <td>'.$rows['paciente_apellido'].'</td>
                    <td>'.$rows['paciente_eps'].'</td>
                    <td>'.$rows['paciente_contrato'].'</td>
                    <td>'.$rows['paciente_especialidad'].'</td>
                    <td>'.$rows['paciente_novedad'].'</td>
                    <td>'.$rows['paciente_estado'].'</td>
                    <td>'.$rows['paciente_oxigeno'].'</td>
                    <td>
                        <a href="index.php?vista=pacient_update&pacient_id_up='.$rows['paciente_id'].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&pacient_id_del='.$rows['paciente_id'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="13">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}


	$tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando pacientes <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
