<?php
require_once "main.php";

// Establecer la conexión a la base de datos
$conexion = conexion();

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

// Recibir los datos del formulario y validarlos
if (isset($_POST['paciente_id'])) {
    $id = limpiar_cadena($_POST['paciente_id']);
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
    $dia_creacion = date('Y-m-d');

    // Validación de campos obligatorios
    if ($tipodoc == "" || $numdoc == "" || $nacimiento == "" || $nombre == "" || $apellido == "" || $eps == "" || $contrato == "" || $especialidad == "" || $pac_novedad == "" || $estado == "" || $oxigeno == "" || $categoria_id == "" || $producto_id == "" || $dia_creacion == "") {
        echo '<div class="notification is-danger is-light">
            <strong>¡Ocurrio un error inesperado!</strong><br>No has llenado todos los campos que son obligatorios
        </div>';
        exit();
    }

    // Conectar a la base de datos
    $conexion = conexion();

    // Primero, verificar si estamos actualizando en estado "Pendiente"
    if ($estado == 'Pendiente') {
        try {
            // Actualizar los datos en la tabla 'paciente' para el estado "Pendiente"
            $actualizar_paciente = $conexion->prepare("UPDATE paciente SET
                paciente_tipodoc = :tipodoc,
                paciente_numdoc = :numdoc,
                paciente_nacimiento = :nacimiento,
                paciente_nombre = :nombre,
                paciente_apellido = :apellido,
                paciente_eps = :eps,
                paciente_contrato = :contrato,
                paciente_especialidad = :especialidad,
                paciente_novedad = :pac_novedad,
                paciente_estado = :estado,
                paciente_oxigeno = :oxigeno,
                categoria_id = :categoria_id,
                producto_id = :producto_id,
                dia_creacion = :dia_creacion
                WHERE paciente_id = :id");

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
                ":dia_creacion" => $dia_creacion
            ];

            // Ejecutar la actualización en la tabla paciente
            if ($actualizar_paciente->execute($marcadores)) {
                echo '<div class="notification is-info is-light">
                    <strong>¡ACTUALIZACIÓN REALIZADA!</strong><br>El paciente se actualizó correctamente en estado "Pendiente".
                </div>';
            } else {
                echo '<div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>No se pudo actualizar el paciente en estado "Pendiente".
                </div>';
            }
        } catch (Exception $e) {
            echo '<div class="notification is-danger is-light">
                <strong>¡Error en la base de datos!</strong><br>' . $e->getMessage() . '
            </div>';
        }
    }

    // Ahora, si el estado cambia a "Aceptado"
    if ($estado == 'Aceptado') {
        try {
            // Verificar que el paciente está en "Pendiente" antes de moverlo a "Aceptado"
            $verificar_estado = $conexion->prepare("SELECT * FROM paciente WHERE paciente_id = :id AND paciente_estado = 'Pendiente'");
            $verificar_estado->bindParam(':id', $id, PDO::PARAM_INT);
            $verificar_estado->execute();

            if ($verificar_estado->rowCount() > 0) {
                // Recibir los campos adicionales para "Aceptado"
                $codigo = limpiar_cadena($_POST['codigo']);
                $num_cama = limpiar_cadena($_POST['num_cama']);
                $remitido_por = limpiar_cadena($_POST['remitido_por']);
                $fecha_entrada = limpiar_cadena($_POST['fecha_entrada']);
                $fecha_salida = limpiar_cadena($_POST['fecha_salida']);

                // Validación de campos adicionales
                if (empty($codigo) || empty($num_cama) || empty($remitido_por) || empty($fecha_entrada) || empty($fecha_salida)) {
                    echo '<div class="notification is-danger is-light">
                        <strong>¡Ocurrio un error inesperado!</strong><br>Por favor, completa todos los campos adicionales para "Aceptado".
                    </div>';
                    exit();
                }

                // Insertar en la tabla 'paciente_aceptado'
                $insertar_aceptado = $conexion->prepare("INSERT INTO paciente_aceptado 
                    (paciente_id, paciente_tipodoc, paciente_numdoc, paciente_nacimiento, paciente_nombre, paciente_apellido, paciente_eps, 
                    paciente_contrato, paciente_especialidad, paciente_novedad, paciente_estado, paciente_oxigeno, 
                    categoria_id, producto_id, dia_creacion, codigo, num_cama, remitido_por, fecha_entrada, fecha_salida)
                    VALUES 
                    (:id, :tipodoc, :numdoc, :nacimiento, :nombre, :apellido, :eps, :contrato, :especialidad, :pac_novedad, :estado, 
                    :oxigeno, :categoria_id, :producto_id, :dia_creacion, :codigo, :num_cama, :remitido_por, :fecha_entrada, :fecha_salida)");

                $marcadores_aceptado = [
                    ":id" => $id,
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
                    ":codigo" => $codigo,
                    ":num_cama" => $num_cama,
                    ":remitido_por" => $remitido_por,
                    ":fecha_entrada" => $fecha_entrada,
                    ":fecha_salida" => $fecha_salida
                ];

                // Ejecutar la inserción en la tabla paciente_aceptado
                $insertar_aceptado->execute($marcadores_aceptado);

                // Eliminar los datos del paciente de la tabla 'paciente'
                $eliminar_paciente = $conexion->prepare("DELETE FROM paciente WHERE paciente_id = :id");
                $eliminar_paciente->bindParam(':id', $id, PDO::PARAM_INT);
                $eliminar_paciente->execute();

                echo '<div class="notification is-info is-light">
                    <strong>¡PACIENTE TRANSFERIDO A ACEPTADO!</strong><br>El paciente fue transferido correctamente.
                </div>';
            } else {
                echo '<div class="notification is-danger is-light">
                    <strong>¡Error!</strong><br>El paciente no está en estado "Pendiente".
                </div>';
            }
        } catch (Exception $e) {
            echo '<div class="notification is-danger is-light">
                <strong>¡Error en la base de datos!</strong><br>' . $e->getMessage() . '
            </div>';
        }
    }

    // Finalmente, si el estado cambia de "Aceptado" a "Pendiente"
    if ($estado == 'Pendiente' && !empty($id)) {
        try {
            // Verificar que el paciente esté en "Aceptado"
            $verificar_aceptado = $conexion->prepare("SELECT * FROM paciente_aceptado WHERE paciente_id = :id");
            $verificar_aceptado->bindParam(':id', $id, PDO::PARAM_INT);
            $verificar_aceptado->execute();

            if ($verificar_aceptado->rowCount() > 0) {
                // Obtener los datos desde paciente_aceptado
                $paciente = $verificar_aceptado->fetch(PDO::FETCH_ASSOC);

                // Insertar de nuevo en paciente
                $insertar_paciente = $conexion->prepare("INSERT INTO paciente
                    (paciente_id, paciente_tipodoc, paciente_numdoc, paciente_nacimiento, paciente_nombre, paciente_apellido, paciente_eps,
                    paciente_contrato, paciente_especialidad, paciente_novedad, paciente_estado, paciente_oxigeno, 
                    categoria_id, producto_id, dia_creacion)
                    VALUES
                    (:id, :tipodoc, :numdoc, :nacimiento, :nombre, :apellido, :eps, :contrato, :especialidad, :pac_novedad, :estado, 
                    :oxigeno, :categoria_id, :producto_id, :dia_creacion)");

                $marcadores_paciente = [
                    ":id" => $paciente['paciente_id'],
                    ":tipodoc" => $paciente['paciente_tipodoc'],
                    ":numdoc" => $paciente['paciente_numdoc'],
                    ":nacimiento" => $paciente['paciente_nacimiento'],
                    ":nombre" => $paciente['paciente_nombre'],
                    ":apellido" => $paciente['paciente_apellido'],
                    ":eps" => $paciente['paciente_eps'],
                    ":contrato" => $paciente['paciente_contrato'],
                    ":especialidad" => $paciente['paciente_especialidad'],
                    ":pac_novedad" => $paciente['paciente_novedad'],
                    ":estado" => $paciente['paciente_estado'],
                    ":oxigeno" => $paciente['paciente_oxigeno'],
                    ":categoria_id" => $paciente['categoria_id'],
                    ":producto_id" => $paciente['producto_id'],
                    ":dia_creacion" => $paciente['dia_creacion']
                ];

                $insertar_paciente->execute($marcadores_paciente);

                // Eliminar del estado 'Aceptado'
                $eliminar_aceptado = $conexion->prepare("DELETE FROM paciente_aceptado WHERE paciente_id = :id");
                $eliminar_aceptado->bindParam(':id', $id, PDO::PARAM_INT);
                $eliminar_aceptado->execute();

                echo '<div class="notification is-info is-light">
                    <strong>¡PACIENTE TRANSFERIDO A PENDIENTE!</strong><br>El paciente fue transferido de nuevo a "Pendiente".
                </div>';
            } else {
                echo '<div class="notification is-danger is-light">
                    <strong>¡Error!</strong><br>El paciente no está en estado "Aceptado".
                </div>';
            }
        } catch (Exception $e) {
            echo '<div class="notification is-danger is-light">
                <strong>¡Error en la base de datos!</strong><br>' . $e->getMessage() . '
            </div>';
        }
    }
}
?>




