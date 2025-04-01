<div class="container is-fluid mb-6">
	<h1 class="title">EPS</h1>
	<h2 class="subtitle">Nueva EPS</h2>
</div>

<div class="container pb-6 pt-6">
	<?php
		require_once "./php/main.php";
	?>

	<div class="form-rest mb-6 mt-6"></div>

	<form action="./php/producto_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Código</label>
				  	<input class="input" type="text" name="producto_codigo" placeholder="Ingrese el codigo de la EPS" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Nombre</label>
				  	<input class="input" type="text" name="producto_nombre" placeholder="Ingrese nombre de la EPS" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
		<div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Municipio</label>
				  	<input class="input" type="text" name="producto_precio" placeholder="Ingrese MUNICIPIO de la EPS" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="125" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Departamento</label>
				  	<input class="input" type="text" name="producto_stock" placeholder="Ingrese DEPARTAMENTO de la EPS" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="125" required >
				</div>
		  	</div>
		  	<div class="column">
				<label>Especialidad</label><br>
		    	<div class="select is-rounded">
				  	<select name="producto_categoria" >
				    	<option value="" selected="">Seleccione una opción</option>
				    	<?php
    						$categorias=conexion();
    						$categorias=$categorias->query("SELECT * FROM categoria");
    						if($categorias->rowCount()>0){
    							$categorias=$categorias->fetchAll();
    							foreach($categorias as $row){
    								echo '<option value="'.$row['categoria_id'].'" >'.$row['categoria_nombre'].'</option>';
				    			}
				   			}
				   			$categorias=null;
				    	?>
				  	</select>
				</div>
		  	</div>
		</div>

		<!-- Eliminamos el campo file y solo dejamos el campo oculto -->
		<input type="hidden" name="producto_foto" value="./img/producto.png">

		<p class="has-text-centered">
			<button type="submit" class="button is-info is-rounded">Guardar</button>
		</p>
	</form>
</div>

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
</script>
