<?php
	
	# Conexion a la base de datos #
	function conexion(){
		$pdo = new PDO('mysql:host=localhost;dbname=pdo', 'root', '');
		return $pdo;
	}


	# Verificar datos #
	function verificar_datos($filtro,$cadena){
		if(preg_match("/^".$filtro."$/", $cadena)){
			return false;
        }else{
            return true;
        }
	}


	# Limpiar cadenas de texto #
	function limpiar_cadena($cadena){
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		$cadena=str_ireplace("<script>", "", $cadena);
		$cadena=str_ireplace("</script>", "", $cadena);
		$cadena=str_ireplace("<script src", "", $cadena);
		$cadena=str_ireplace("<script type=", "", $cadena);
		$cadena=str_ireplace("SELECT * FROM", "", $cadena);
		$cadena=str_ireplace("DELETE FROM", "", $cadena);
		$cadena=str_ireplace("INSERT INTO", "", $cadena);
		$cadena=str_ireplace("DROP TABLE", "", $cadena);
		$cadena=str_ireplace("DROP DATABASE", "", $cadena);
		$cadena=str_ireplace("TRUNCATE TABLE", "", $cadena);
		$cadena=str_ireplace("SHOW TABLES;", "", $cadena);
		$cadena=str_ireplace("SHOW DATABASES;", "", $cadena);
		$cadena=str_ireplace("<?php", "", $cadena);
		$cadena=str_ireplace("?>", "", $cadena);
		$cadena=str_ireplace("--", "", $cadena);
		$cadena=str_ireplace("^", "", $cadena);
		$cadena=str_ireplace("<", "", $cadena);
		$cadena=str_ireplace("[", "", $cadena);
		$cadena=str_ireplace("]", "", $cadena);
		$cadena=str_ireplace("==", "", $cadena);
		$cadena=str_ireplace(";", "", $cadena);
		$cadena=str_ireplace("::", "", $cadena);
		$cadena=trim($cadena);
		$cadena=stripslashes($cadena);
		return $cadena;
	}


	# Funcion renombrar fotos #
	function renombrar_fotos($nombre){
		$nombre=str_ireplace(" ", "_", $nombre);
		$nombre=str_ireplace("/", "_", $nombre);
		$nombre=str_ireplace("#", "_", $nombre);
		$nombre=str_ireplace("-", "_", $nombre);
		$nombre=str_ireplace("$", "_", $nombre);
		$nombre=str_ireplace(".", "_", $nombre);
		$nombre=str_ireplace(",", "_", $nombre);
		$nombre=$nombre."_".rand(0,100);
		return $nombre;
	}


	# Funcion paginador de tablas #
	function paginador_tablas($pagina,$Npaginas,$url,$botones){
		$tabla='<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		if($pagina<=1){
			$tabla.='
			<a class="pagination-previous is-disabled" disabled >Anterior</a>
			<ul class="pagination-list">';
		}else{
			$tabla.='
			<a class="pagination-previous" href="'.$url.($pagina-1).'" >Anterior</a>
			<ul class="pagination-list">
				<li><a class="pagination-link" href="'.$url.'1">1</a></li>
				<li><span class="pagination-ellipsis">&hellip;</span></li>
			';
		}

		$ci=0;
		for($i=$pagina; $i<=$Npaginas; $i++){
			if($ci>=$botones){
				break;
			}
			if($pagina==$i){
				$tabla.='<li><a class="pagination-link is-current" href="'.$url.$i.'">'.$i.'</a></li>';
			}else{
				$tabla.='<li><a class="pagination-link" href="'.$url.$i.'">'.$i.'</a></li>';
			}
			$ci++;
		}

		if($pagina==$Npaginas){
			$tabla.='
			</ul>
			<a class="pagination-next is-disabled" disabled >Siguiente</a>
			';
		}else{
			$tabla.='
				<li><span class="pagination-ellipsis">&hellip;</span></li>
				<li><a class="pagination-link" href="'.$url.$Npaginas.'">'.$Npaginas.'</a></li>
			</ul>
			<a class="pagination-next" href="'.$url.($pagina+1).'" >Siguiente</a>
			';
		}

		$tabla.='</nav>';
		return $tabla;
	}

	// Función para generar el código con el consecutivo
	function generarCodigo($conexion) {
    // Obtener la fecha actual
    $fecha = new DateTime();
    $diaSemana = $fecha->format('w');  // Día de la semana (0 = Domingo, 1 = Lunes, ..., 6 = Sábado)
    $mes = $fecha->format('n') - 1;   // Mes (0 = Enero, 1 = Febrero, ..., 11 = Diciembre)
    $diaDelMes = $fecha->format('d');  // Día del mes

    // Días y meses en formato abreviado
    $dias = ["D", "L", "M", "W", "J", "V", "S"];
    $meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JNI", "JLI", "AGS", "SEP", "OCT", "NOV", "DIC"];

    // Consulta para obtener el último código generado hoy
    $sql = "SELECT codigo FROM paciente_aceptado WHERE DATE(fecha_creacion) = CURDATE() ORDER BY codigo DESC LIMIT 1";
    $result = $conexion->query($sql);

    // Verificar si hay un código generado hoy
    if ($result->num_rows > 0) {
        // Obtener el último código generado
        $row = $result->fetch_assoc();
        $ultimoCodigo = $row['codigo'];

        // Extraer el consecutivo del último código (los 2 dígitos antes de la "D")
        $ultimoConsecutivo = (int) substr($ultimoCodigo, -3, 2);
        $consecutivo = str_pad($ultimoConsecutivo + 1, 2, '0', STR_PAD_LEFT);
    } else {
        // Si no hay registros hoy, comenzamos con D01
        $consecutivo = "01";
    }

    // Generar el código en el formato deseado
    $codigo = $dias[$diaSemana] . $meses[$mes] . str_pad($diaDelMes, 2, '0', STR_PAD_LEFT) . $consecutivo . "D";

    return $codigo;
}