const formularios_ajax = document.querySelectorAll(".FormularioAjax");

function enviar_formulario_ajax(e) {
    e.preventDefault();

    let enviar = confirm("¿Quieres enviar el formulario?");

    if (enviar == true) {

        let data = new FormData(this);
        let method = this.getAttribute("method");
        let action = this.getAttribute("action");

        // Imprimir los datos del formulario en la consola
        for (let pair of data.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        let encabezados = new Headers();

        let config = {
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
    formularios.addEventListener("submit", enviar_formulario_ajax);
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
});

// Función para generar el código automáticamente al seleccionar "Aceptado"
function mostrarCamposAdicionales(estado) {
    if (estado === 'Aceptado') {
        // Mostrar los campos adicionales y generar el código
        document.getElementById('campos_adicionales').style.display = 'block';
        generarCodigo(); // Llamamos a la función para generar el código
    } else {
        // Ocultar los campos adicionales
        document.getElementById('campos_adicionales').style.display = 'none';
    }
}

// Función para generar un código único para los pacientes 'Aceptados'
function generarCodigo() {
    const fecha = new Date();
    const diaSemana = fecha.getDay();
    const dias = ["D", "L", "M", "W", "J", "V", "S"];
    const mes = fecha.getMonth();
    const meses = ["ENE", "FEB", "MAR", "ABR", "MAY", "JNI", "JLI", "AGS", "SEP", "OCT", "NOV", "DIC"];
    const diaDelMes = fecha.getDate();

    // Solicita el último código generado
    fetch('php/obtenerUltimoCodigo.php')
        .then(response => response.json())
        .then(data => {
            let consecutivo;
            if (data && data.ultimoCodigo) {
                const ultimoCodigo = data.ultimoCodigo;
                const consecutivoExtraido = parseInt(ultimoCodigo.substring(8, 10)); // Extraemos los 2 dígitos del consecutivo
                consecutivo = ("0" + (consecutivoExtraido + 1)).slice(-2);
            } else {
                consecutivo = "01";
            }

            const codigo = dias[diaSemana] + meses[mes] + ("0" + diaDelMes).slice(-2) + consecutivo + "D";
            document.getElementById('codigo_paciente').value = codigo;
        })
        .catch(error => {
            console.error('Error al obtener el último código:', error);
        });
}

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar la visibilidad de los campos dependiendo del estado actual
    mostrarCamposAdicionales(document.getElementById('estado_select').value);
});