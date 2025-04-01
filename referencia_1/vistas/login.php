<div class="main-container">
    <div class="background-image"></div> <!-- Este es el contenedor de la imagen con opacidad -->
    
    <form class="box login" action="" method="POST" autocomplete="off">
        <h5 class="title is-5 has-text-centered is-uppercase">Sistema de Referencia</h5>

        <div class="field">
            <label class="label">Usuario</label>
            <div class="control">
                <input class="input" type="text" name="login_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
            </div>
        </div>

        <div class="field">
            <label class="label">Clave</label>
            <div class="control">
                <input class="input" type="password" name="login_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
            </div>
        </div>

        <p class="has-text-centered mb-4 mt-3">
            <button type="submit" class="button is-info is-rounded">Iniciar sesión</button>
        </p>

        <?php
            if (isset($_POST['login_usuario']) && isset($_POST['login_clave'])) {
                require_once "./php/main.php";
                require_once "./php/iniciar_sesion.php";
            }
        ?>
    </form>
</div>

<style>
    /* Contenedor para la imagen de fondo */
    .background-image {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: url('./img/doctor-6676747_1280.jpg'); /* Ruta de la imagen */
        background-size: cover; /* El fondo ocupa toda la pantalla */
        background-position: center center; /* Centra la imagen */
        background-attachment: fixed; /* Hace que la imagen se quede fija al hacer scroll */
        opacity: 0.5; /* Aplica opacidad solo a la imagen */
        z-index: -1; /* Pone la imagen detrás del formulario */
        box-shadow: inset 0 0 15px rgba(0, 0, 0, 0.5); /* Agrega sombra a la imagen */
    }

    /* Estilo para el contenedor principal */
    .main-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* El contenedor ocupa toda la altura de la pantalla */
        padding: 0 10px; /* Agrega margen en los lados */
        position: relative; /* Necesario para posicionar la imagen de fondo detrás */
    }

    /* Estilo para el formulario */
    .box.login {
        background-color: rgba(255, 255, 255, 1); /* Fondo blanco sin opacidad para el formulario */
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3); /* Agrega sombra al formulario */
        width: 100%;
        max-width: 400px; /* Limita el tamaño máximo del formulario */
        text-align: center;
        position: relative;
        z-index: 1; /* Asegura que el formulario esté encima de la imagen */
    }

    /* Estilo para el título */
    .title.is-5 {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    /* Estilo para los inputs */
    .input {
        margin-bottom: 20px; /* Espacio entre los campos */
        padding: 10px;
        font-size: 16px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    /* Estilo para el botón */
    .button.is-info {
        padding: 12px 20px;
        font-size: 16px;
        width: 100%;
        border-radius: 5px;
        cursor: pointer;
    }

    /* Cambia el color del botón cuando se pasa el ratón por encima */
    .button.is-info:hover {
        background-color: #4c8bdb;
    }
</style>
