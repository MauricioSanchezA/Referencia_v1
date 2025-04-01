<script>
    document.addEventListener('DOMContentLoaded', () => {

        // Get all "navbar-burger" elements
        const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

        // Check if there are any navbar burgers
        if ($navbarBurgers.length > 0) {

            // Add a click event on each of them
            $navbarBurgers.forEach( el => {
                el.addEventListener('click', () => {

                // Get the target from the "data-target" attribute
                const target = el.dataset.target;
                const $target = document.getElementById(target);

                // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
                el.classList.toggle('is-active');
                $target.classList.toggle('is-active');

                });
            });
        }
    });

    // Obtener el enlace "Buscar" y el submenú
    const buscarLink = document.querySelector('.navbar-link'); 
    const subMenu = document.getElementById('sub-menu-buscar');
    
    // Añadir un evento de clic al enlace "Buscar"
    buscarLink.addEventListener('click', function(event) {
        // Evitar que se siga el enlace
        event.preventDefault();
        
        // Comprobar si el submenú ya está visible o no
        if (subMenu.style.display === "none" || subMenu.style.display === "") {
            // Si está oculto, mostrar el submenú
            subMenu.style.display = "block";
        } else {
            // Si está visible, ocultarlo
            subMenu.style.display = "none";
        }
    });

    // Añadir evento de clic para cerrar el submenú si se hace clic fuera de él
    window.addEventListener('click', function(event) {
        if (!buscarLink.contains(event.target) && !subMenu.contains(event.target)) {
            subMenu.style.display = "none"; // Cerrar el submenú si se hace clic fuera de él
        }
    });
    
</script>
<script src="./js/ajax.js"></script>