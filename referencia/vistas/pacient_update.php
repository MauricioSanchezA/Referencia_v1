<div class="container is-fluid mb-6">
	<h1 class="title">Pacientes</h1>
	<h2 class="subtitle">Actualizar Pacientes</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		include "./inc/btn_back.php";
		require_once "./php/main.php";

		$id = (isset($_GET['pacient_id_up'])) ? $_GET['pacient_id_up'] : 0;
		$id=limpiar_cadena($id);

		/*== Verificando categoria ==*/
    	$check_paciente=conexion();
    	$check_paciente=$check_paciente->query("SELECT * FROM paciente WHERE paciente_id='$id'");

        if($check_paciente->rowCount()>0){
        	$datos=$check_paciente->fetch();
	?>

    <form action="./php/paciente_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">
    <!-- Campo oculto para el ID del paciente -->
    <input type="hidden" name="paciente_id" value="<?php echo $datos['paciente_id']; ?>" required>
    <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Tipo documento</label>
                    <div class="select">
                        <select name="paciente_tipodoc" required value="<?php echo $datos['paciente_tipodoc']; ?>" >
                            <option value="CC">Cédula de ciudadanía</option>
                            <option value="TI">Tarjeta de Identidad</option>
                            <option value="CE">Cédula de Extranjeria</option>
                            <option value="CN">Cédula de Nacionalización</option>
                            <option value="ME">Menor de edad</option>
                            <option value="PE">Permiso Especial Permanencia</option>
                            <option value="PT">Permiso Temporal</option>
                            <option value="PP">Pasaporte</option>
                            <option value="NU">Numero Único Identificacion Personal</option>
                            <option value="RC">Registro Civil</option>
                            <option value="CD">Carnet Diplomático</option>
                            <option value="SC">Salvoconducto</option>
                            <option value="AS">Adulto sin identificación</option>
                            <option value="OT">Otro</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Numero Documento</label>
                    <input class="input" type="number" name="paciente_numdoc" maxlength="15" required value="<?php echo $datos['paciente_numdoc']; ?>" >
                </div>
            </div>
              <div class="column">
                <div class="control">
                    <label>Fecha Nacimiento</label>
                    <input class="input" type="date" name="paciente_nacimiento" required value="<?php echo $datos['paciente_nacimiento']; ?>" >
                </div>
            </div>
        </div>
        <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="paciente_nombre" placeholder="Ingrese nombre nuevo" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="<?php echo $datos['paciente_nombre']; ?>" >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Apellido</label>
				  	<input class="input" type="text" name="paciente_apellido" placeholder="Ingrese apellido nuevo" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['paciente_apellido']; ?>" >
				</div>
		  	</div>
		</div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>EPS</label>
                    <input class="input" type="text" id="paciente_eps" name="paciente_eps" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required value="<?php echo $datos['paciente_eps']; ?>" >
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <input class="input" type="text" id="paciente_especialidad" name="paciente_especialidad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required value="<?php echo $datos['paciente_especialidad']; ?>" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Contrato</label>
                    <input class="input" type="text" id="paciente_contrato" name="paciente_contrato" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required value="<?php echo $datos['paciente_contrato']; ?>" >
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Novedades</label>
                    <input class="input" type="text" name="paciente_novedad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 +\-_/()¿?,.]{3,500}" maxlength="500" required value="<?php echo $datos['paciente_novedad']; ?>" >
                </div>
            </div>
        </div>
        <div class="columns">
        <div class="column">
            <div class="control">
                <label>Fecha de actualización</label>
                <input class="input" type="date" name="dia_creacion" required value="<?php echo $datos['dia_creacion']; ?>" >
            </div>
        </div>
        <div class="column">
            <label>Necesita Oxígeno</label>
            <div class="control">
                <div class="select">
                    <select name="paciente_oxigeno" required value="<?php echo $datos['paciente_oxigeno']; ?>" >
                        <option value="Si">Si</option>
                        <option value="No">No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="column">
            <label>Estado</label>
            <div class="control">
                <div class="select">
                    <select name="paciente_estado" id="estado_select" onchange="mostrarCamposAdicionales(this.value)" required>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Cerrado">Cerrado</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Campos adicionales para "Aceptado" -->
    <div class="columns" id="campos_adicionales" style="display:none;">
    <div class="column">
        <div class="control">
            <label>Código</label>
            <input class="input" type="text" name="codigo" id="codigo_paciente" required>
        </div>
    </div>

    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Numero de Cama</label>
                <input class="input" type="text" name="num_cama" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Remitido Por</label>
                <input class="input" type="text" name="remitido_por">
            </div>
        </div>
    </div>
    <div class="columns">
        <div class="column">
            <div class="control">
                <label>Fecha de Entrada</label>
                <input class="input" type="date" name="fecha_entrada" required>
            </div>
        </div>
        <div class="column">
            <div class="control">
                <label>Fecha de Salida</label>
                <input class="input" type="date" name="fecha_salida" required>
            </div>
        </div>
    </div>
</div>

        <!-- Hidden fields for foreign keys -->
        <input type="hidden" id="categoria_id" name="categoria_id" required value="<?php echo $datos['categoria_id']; ?>" >
        <input type="hidden" id="producto_id" name="producto_id" required value="<?php echo $datos['producto_id']; ?>" >
		<p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
	</form>
	<?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_paciente=null;
	?>
</div>
<!-- Include jQuery and jQuery UI for autocomplete -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- Include the custom ajax.js file -->
<script>
const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault();

    let enviar = confirm("¿Quieres enviar el formulario?");
    if (enviar == true) {
        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        let config = {
            method: method,
            headers: new Headers(),
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action, config)
            .then(respuesta => respuesta.text())
            .then(respuesta => {
                let contenedor = document.querySelector(".form-rest");
                contenedor.innerHTML = respuesta;

                // Limpiar el formulario después de recibir la respuesta
                this.reset();  // limpia todos los campos del formulario

                // Limpiar el mensaje después de 3 segundos
                setTimeout(() => {
                    contenedor.innerHTML = '';
                }, 3000);
                setTimeout(() => {
                    let pagina = "<?php echo isset($_GET['page']) ? limpiar_cadena($_GET['page']) : 1; ?>";
                    let url = "index.php?vista=pacient_update&page=" + pagina;
                    window.location.href = url;
                }, 3000);
            });
    }
}

formularios_ajax.forEach(formulario => {
    formulario.addEventListener("submit", enviar_formulario_ajax);
});

$(function() {
    $("#paciente_eps").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "./php/get_productos.php",
                dataType: "json",
                data: {
                    term: request.term,
                    type: 'producto'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nombre,
                            value: item.nombre,
                            id: item.id
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#producto_id").val(ui.item.id);
        }
    });

    $("#paciente_especialidad").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "./php/get_productos.php",
                dataType: "json",
                data: {
                    term: request.term,
                    type: 'categoria'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nombre,
                            value: item.nombre,
                            id: item.id
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#categoria_id").val(ui.item.id);
        }
    });

    $("#paciente_contrato").autocomplete({
        source: function(request, response) {
            $.ajax({
                url: "./php/get_productos.php",
                dataType: "json",
                data: {
                    term: request.term,
                    type: 'contrato'
                },
                success: function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.nombre,
                            value: item.nombre,
                            id: item.id
                        };
                    }));
                }
            });
        },
        minLength: 2,
        select: function(event, ui) {
            $("#contrato_id").val(ui.item.id);
        }
    });
});
document.addEventListener('DOMContentLoaded', function() {
    // Get the current date
    var currentDate = new Date();
    var year = currentDate.getFullYear();
    var month = ("0" + (currentDate.getMonth() + 1)).slice(-2);  // Add leading zero if needed
    var day = ("0" + currentDate.getDate()).slice(-2);  // Add leading zero if needed
    
    // Set the current date in the 'dia_creacion' field
    document.getElementById("dia_creacion").value = year + "-" + month + "-" + day;
});

// Función para mostrar los campos adicionales al cambiar el estado
function mostrarCamposAdicionales(estado) {
    const camposAdicionales = document.getElementById('campos_adicionales');
    if (estado === 'Aceptado') {
        camposAdicionales.style.display = 'block';
        generarCodigo(); // Genera el código automáticamente
    } else {
        camposAdicionales.style.display = 'none';
    }
}

function generarCodigo() {
    const fecha = new Date();
    const diaSemana = fecha.getDay(); // 0 = Domingo, 1 = Lunes, ..., 6 = Sábado
    const dias = ["D", "L", "M", "W", "J", "V", "S"];
    const mes = fecha.getMonth(); // 0 = Enero, 1 = Febrero, ..., 11 = Diciembre
    const meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JNI", "JLI", "AGS", "SEP", "OCT", "NOV", "DIC"];
    const diaDelMes = fecha.getDate();

    // Realizamos una solicitud AJAX para obtener el último código generado
    fetch('obtenerUltimoCodigo.php')
        .then(response => response.json())
        .then(data => {
            let consecutivo;

            // Si ya existen códigos generados hoy
            if (data && data.ultimoCodigo) {
                // Extraemos el número del consecutivo del último código generado
                const ultimoCodigo = data.ultimoCodigo;
                const consecutivoExtraido = parseInt(ultimoCodigo.substring(8, 10)); // Extraemos los 2 dígitos del consecutivo
                consecutivo = ("0" + (consecutivoExtraido + 1)).slice(-2); // Incrementamos y aseguramos que tenga 2 dígitos
            } else {
                // Si no existen códigos hoy, comenzamos con D01
                consecutivo = "01";
            }

            // Generamos el código final con el consecutivo
            const codigo = dias[diaSemana] + meses[mes] + ("0" + diaDelMes).slice(-2) + consecutivo + "D";

            // Asignamos el código generado al campo
            document.getElementById('codigo_paciente').value = codigo;
        })
        .catch(error => {
            console.error('Error al obtener el último código:', error);
        });
}

</script>