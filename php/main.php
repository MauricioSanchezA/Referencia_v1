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
	function paginador_tablas($pagina, $Npaginas, $url, $botones) {
		// Verificar si hay más de una página
		if ($Npaginas <= 1) {
			return ''; // No se necesita paginación
		}

		$tabla = '<nav class="pagination is-centered is-rounded" role="navigation" aria-label="pagination">';

		// Botón "Anterior"
		if ($pagina <= 1) {
			$tabla .= '<a class="pagination-previous is-disabled" disabled>Anterior</a>';
		} else {
			$tabla .= '<a class="pagination-previous" href="' . $url . ($pagina - 1) . '">Anterior</a>';
		}

		$tabla .= '<ul class="pagination-list">';

		// Mostrar el primer enlace siempre
		if ($pagina > 1) {
			$tabla .= '<li><a class="pagination-link" href="' . $url . '1">1</a></li>';
			if ($pagina > 2) {
				$tabla .= '<li><span class="pagination-ellipsis">&hellip;</span></li>';
			}
		}

		// Mostrar enlaces de páginas cercanas
		$ci = 0;
		for ($i = max(1, $pagina - $botones); $i <= min($Npaginas, $pagina + $botones); $i++) {
			if ($pagina == $i) {
				$tabla .= '<li><a class="pagination-link is-current" href="' . $url . $i . '">' . $i . '</a></li>';
			} else {
				$tabla .= '<li><a class="pagination-link" href="' . $url . $i . '">' . $i . '</a></li>';
			}
			$ci++;
		}

		// Mostrar el último enlace siempre
		if ($pagina < $Npaginas - 1) {
			$tabla .= '<li><span class="pagination-ellipsis">&hellip;</span></li>';
		}
		if ($pagina < $Npaginas) {
			$tabla .= '<li><a class="pagination-link" href="' . $url . $Npaginas . '">' . $Npaginas . '</a></li>';
		}

		$tabla .= '</ul>';

		// Botón "Siguiente"
		if ($pagina >= $Npaginas) {
			$tabla .= '<a class="pagination-next is-disabled" disabled>Siguiente</a>';
		} else {
			$tabla .= '<a class="pagination-next" href="' . $url . ($pagina + 1) . '">Siguiente</a>';
		}

		$tabla .= '</nav>';
		return $tabla;
	}

	# Obtener el último código generado #
	function obtenerUltimoCodigo() {
		$conexion = conexion();
		$sql = "SELECT codigo FROM paciente_aceptado WHERE fecha = CURDATE() ORDER BY codigo DESC LIMIT 1";
		$stmt = $conexion->prepare($sql);
		$stmt->execute();
		
		if ($stmt->rowCount() > 0) {
			$codigo = $stmt->fetch(PDO::FETCH_ASSOC);
			return $codigo['codigo'];
		} else {
			return null;
		}
	}