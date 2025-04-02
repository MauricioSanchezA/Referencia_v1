<?php
    // Session management
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted
if (isset($_POST['modulo_buscador']) && $_POST['modulo_buscador'] === 'pacientacept') {
    if (!empty($_POST['txt_buscador'])) {
        $_SESSION['busqueda_pacienteacept'] = trim($_POST['txt_buscador']);
    } else {
        unset($_SESSION['busqueda_pacienteacept']);
    }
}
?>
<div class="container is-fluid mb-6">
    <h1 class="title">Pacientes</h1>
    <h2 class="subtitle">Buscar Paciente ACEPTADO</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        // Procesar el formulario de búsqueda
        if (isset($_POST['modulo_buscador'])) {
            require_once "./php/buscador.php";
        }

        // Verificar si hay una búsqueda activa
        if (!isset($_SESSION['busqueda_pacienteacept']) || empty($_SESSION['busqueda_pacienteacept'])) {
    ?>
    <div class="columns">
        <div class="column">
            <form action="" method="POST" autocomplete="off">
                <input type="hidden" name="modulo_buscador" value="pacientacept">
                <div class="field is-grouped">
                    <p class="control is-expanded">
                        <input class="input is-rounded" type="text" name="txt_buscador" placeholder="¿Qué estás buscando?" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,30}" maxlength="30">
                    </p>
                    <p class="control">
                        <button class="button is-info" type="submit">Buscar</button>
                    </p>
                </div>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <div class="columns">
        <div class="column">
            <form class="has-text-centered mt-6 mb-6" action="" method="POST" autocomplete="off">
                <input type="hidden" name="modulo_buscador" value="pacientacept">
                <input type="hidden" name="eliminar_buscador" value="pacientacept">
                <p>Estás buscando <strong>“<?php echo htmlspecialchars($_SESSION['busqueda_pacienteacept'], ENT_QUOTES, 'UTF-8'); ?>”</strong></p>
                <br>
                <button type="submit" class="button is-danger is-rounded">Eliminar búsqueda</button>
            </form>
        </div>
    </div>

    <?php
            // Eliminar paciente aceptado
            if (isset($_GET['pacientacept_id_del'])) {
                require_once "./php/pacienteaceptado_eliminar.php";
            }

            // Configurar la paginación
            if (!isset($_GET['page'])) {
                $pagina = 1;
            } else {
                $pagina = (int) $_GET['page'];
                if ($pagina <= 1) {
                    $pagina = 1;
                }
            }

            $pagina = limpiar_cadena($pagina);
            $url = "index.php?vista=pacientacept_search&page="; // URL base para la paginación
            $registros = 15;
            $busqueda = $_SESSION['busqueda_pacienteacept'];

            // Cargar la lista de pacientes aceptados
            require_once "./php/pacienteaceptado_lista.php";
        }
    ?>
</div>