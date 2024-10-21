// Función para detectar el tema y aplicar la clase dark
function applyTheme() {
    if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
}
// Aplicar el tema al cargar la página
applyTheme();
// Escuchar cambios en las preferencias del sistema y ajustar el tema
window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', applyTheme);


//Script para cambiar el logo y el favicon en funcion de si el tema es oscuro o claro
document.addEventListener("DOMContentLoaded", function() {
    const logo = document.querySelector('.footer-logo');
    const favicon = document.querySelector('link[rel="icon"]');

    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

    function updateThemeAssets() {
        if (prefersDarkScheme.matches) {
            if (logo) {
                logo.src = baseUrl + "images/ARl_fnegre.png";
            }
            if (favicon) {
                favicon.href = baseUrl + "images/AR_fnegre.png";
            }
        } else {
            if (logo) {
                logo.src = baseUrl + "images/ARl_fblanc.png";
            }
            if (favicon) {
                favicon.href = baseUrl + "images/AR_fblanc.png";
            }
        }
    }

    updateThemeAssets();
    prefersDarkScheme.addEventListener('change', updateThemeAssets);
});


//Script para asegurarse que los labels floten si el campo ya tiene un valor y que el color sea el adecuado al tema
document.addEventListener('DOMContentLoaded', function () {
    // Detectar el tema (oscuro o claro)
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

    // Función para determinar el color basado en el tema
    function getLabelColor() {
        return prefersDarkScheme.matches ? 'white' : '#344767';  // Blanco para oscuro, negro para claro
    }

    // Selecciona todos los elementos select y textarea en la página
    const inputs = document.querySelectorAll('select, textarea');

    // Itera sobre cada input y agrega los listeners de eventos
    inputs.forEach(function(input) {
        // Selecciona el label correspondiente basado en el atributo "for" del label
        const label = document.querySelector(`label[for="${input.id}"]`);

        if (label) {
            // Función para cambiar el color del label cuando el input tiene el foco
            input.addEventListener('focus', function() {
                label.style.color = getLabelColor();  // Cambiar color basado en el tema
            });

            // Función para restaurar el color del label cuando el input pierde el foco
            input.addEventListener('blur', function() {
                label.style.color = '';  // Restaurar el color original al perder el foco
            });
        }
    });

    // Escuchar cambios en el tema y actualizar los colores dinámicamente
    prefersDarkScheme.addEventListener('change', function() {
        inputs.forEach(function(input) {
            const label = document.querySelector(`label[for="${input.id}"]`);
            if (label && input === document.activeElement) {  // Solo actualizar si está enfocado
                label.style.color = getLabelColor();
            }
        });
    });
});


//Script para los colores del tema en el select2
$(document).ready(function() {
    // Detectar el tema (oscuro o claro)
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

    // Función para determinar el color basado en el tema
    function getLabelColor() {
        return prefersDarkScheme.matches ? 'white' : '#344767';  // Blanco para oscuro, negro para claro
    }

    // Inicializar select2
    $('.select2').select2({
        placeholder: "Selecciona un cliente"
    });

    // Manejar el evento cuando select2 se abre
    $('.select2').on('select2:open', function() {
        const label = document.querySelector(`label[for="${this.id}"]`);
        if (label) {
            label.style.color = getLabelColor();  // Cambiar color basado en el tema
        }
    });

    // Manejar el evento cuando select2 se cierra
    $('.select2').on('select2:close', function() {
        const label = document.querySelector(`label[for="${this.id}"]`);
        if (label) {
            label.style.color = '';  // Restaurar el color original cuando se cierra el select2
        }
    });

    // Escuchar cambios en el tema y actualizar los colores dinámicamente
    prefersDarkScheme.addEventListener('change', function() {
        $('.select2').each(function() {
            const label = document.querySelector(`label[for="${this.id}"]`);
            if (label && $(this).data('select2').isOpen()) {  // Solo actualizar si está abierto
                label.style.color = getLabelColor();
            }
        });
    });
});

