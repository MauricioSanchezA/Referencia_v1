<div class="home-container">
    <div class="container is-fluid">
        <h1 class="title">Principal</h1>
        <br>
        <h2 class="subtitle zoom-effect">¡Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION['apellido']; ?>!</h2>
    </div>
</div>

<style>
    /* Aplica imagen de fondo solo al contenedor de la página home */
.home-container {
    background-image: url('./img/doctor-6676747_1280.jpg'); /* Ruta de la imagen */
    background-size: cover;
    background-position: center center;
    background-attachment: fixed; /* Fija la imagen en su lugar al hacer scroll */
    opacity: 0.9; /* Aplica opacidad solo a la imagen */
    z-index: -1; /* Pone la imagen detrás del formulario */
    min-height: 100vh; /* Asegura que cubra toda la altura de la ventana */
    padding: 50px 0; /* Ajusta el padding según el espacio que necesites */
}

/* Estilo para el texto dentro de home-container */
.home-container .container {
    padding: 20px;
    border-radius: 10px; /* Bordes redondeados */
}

/* Efecto de zoom para el mensaje de bienvenida */
.zoom-effect {
    display: inline-block;
    transition: transform 0.3s ease-in-out;
}

.zoom-effect:hover {
    transform: scale(1.1); /* Efecto de zoom */
}
</style>