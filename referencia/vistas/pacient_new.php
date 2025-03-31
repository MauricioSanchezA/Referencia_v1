<div class="container is-fluid mb-6">
    <h1 class="title">Pacientes</h1>
    <h2 class="subtitle">Nuevo Paciente</h2>
</div>
<div class="container pb-6 pt-6">

    <div class="form-rest mb-6 mt-6"></div>

    <form action="./php/paciente_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Tipo documento</label>
                    <div class="select">
                        <select name="paciente_tipodoc" required>
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
                    <input class="input" type="number" name="paciente_numdoc" maxlength="15" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Fecha Nacimiento</label>
                    <input class="input" type="date" name="paciente_nacimiento" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input class="input" type="text" name="paciente_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="45" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input class="input" type="text" name="paciente_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="45" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>EPS</label>
                    <input class="input" type="text" id="paciente_eps" name="paciente_eps" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Especialidad</label>
                    <input class="input" type="text" id="paciente_especialidad" name="paciente_especialidad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Contrato</label>
                    <input class="input" type="text" id="paciente_contrato" name="paciente_contrato" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,40}" maxlength="45" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Novedades</label>
                    <input class="input" type="text" name="paciente_novedad" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9 ]{3,500}" maxlength="500" required>
                </div>
            </div>
        </div>

        <div class="columns">
            <div class="column">
            <label>Estado</label>
                <div class="control">
                    <div class="select">
                        <select name="paciente_estado" required>
                            <option value="Pendiente">Pendiente</option>
                            <!--<option value="Aceptado">Aceptado</option>
                            <option value="Cerrado">Cerrado</option>-->
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
            <label>Necesita Oxigeno</label>
                <div class="control">
                    <div class="select">
                        <select name="paciente_oxigeno" required>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Fecha de Creación</label>
                    <input class="input" type="date" name="dia_creacion" id="dia_creacion" required readonly>
                </div>
            </div>
        </div>

        <!-- Hidden fields for foreign keys -->
        <input type="hidden" id="categoria_id" name="categoria_id" required>
        <input type="hidden" id="producto_id" name="producto_id" required>

        <p class="has-text-centered">
            <button type="submit" class="button is-info is-rounded">Guardar</button>
        </p>
    </form>
</div>

<!-- Include jQuery and jQuery UI for autocomplete -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<!-- Include the custom ajax.js file -->
<script>
const formularios_ajax=document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e){
    e.preventDefault();

    let enviar=confirm("Quieres enviar el formulario");

    if(enviar==true){

        let data= new FormData(this);
        let method=this.getAttribute("method");
        let action=this.getAttribute("action");

        let encabezados= new Headers();

        let config={ 
            method: method,
            headers: encabezados,
            mode: 'cors',
            cache: 'no-cache',
            body: data
        };

        fetch(action,config)
        .then(respuesta => respuesta.text())
        .then(respuesta =>{ 
            let contenedor=document.querySelector(".form-rest");
            contenedor.innerHTML = respuesta;

            // Limpiar el formulario después de recibir la respuesta
            this.reset();  // limpia todos los campos del formulario

            // Limpiar el mensaje después de 3 segundos
            setTimeout(() => {
                contenedor.innerHTML = '';
            }, 3000);
        });
    }

}

formularios_ajax.forEach(formularios => {
    formularios.addEventListener("submit",enviar_formulario_ajax);
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

</script>