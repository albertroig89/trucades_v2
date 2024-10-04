import './bootstrap';
import 'bootstrap-icons/font/bootstrap-icons.css';
import Alpine from 'alpinejs';
import $ from 'jquery';
import 'jquery-datetimepicker';

window.Alpine = Alpine;

Alpine.start();


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





$(document).ready(function() {
    $("#add_phone").click(function(){
        var contador = $("input[type='text']").length;

        $(this).before('<div class="form-group input-group mb-4 input-group-static mt-4" style="position: relative;"><label class="form-label" for="phones'+ contador +'">Teléfono '+ contador +':</label><input name="phones[]" type="text" class="form-control" id="phones'+ contador +'"><button type="button" class="btn btn-default delete_phone mt-4">Borrar telèfon</button></div>');
    });
    $(document).on('click', '.delete_phone', function(){
        $(this).parent().remove();
    });
});


// $(document).ready(function () {
//     if ($('#inittime').length) {
//         $('#inittime').datetimepicker({
//             format: 'd-m-y H:i',
//             mask: '39-19-99 29:59'
//         });
//     }
//
//     if ($('#endtime').length) {
//         $('#endtime').datetimepicker({
//             format: 'd-m-y H:i',
//             mask: '39-19-99 29:59'
//         });
//     }
//
//     if ($('#inittime2').length) {
//         $('#inittime2').datetimepicker({
//             format: 'd-m-y H:i'
//         });
//     }
//
//     if ($('#endtime2').length) {
//         $('#endtime2').datetimepicker({
//             format: 'd-m-y H:i'
//         });
//     }
//
//     // Establecer la configuración regional si es necesario
//     if ($.datetimepicker) {
//         $.datetimepicker.setLocale('es');
//     }
// });


document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    // Verifica si los elementos existen antes de añadir el listener
    if (passwordInput && toggleIcon) {
        toggleIcon.addEventListener('click', function () {
            // Alternar el tipo de input entre "password" y "text"
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            // Cambiar el ícono entre "visibility" y "visibility_off"
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    }
});



$(function(){
    // Inicialización de select2 y escucha del evento 'change'
    $('.select2').select2({
        placeholder: "Selecciona un cliente",
    }).on('change', function(e) {
        var data = $(".select2 option:selected").text().trim();  // Eliminar espacios adicionales
        $("#clientname").val(data);
        $("#clientphone").prop("disabled", true);

        // Si el campo clientname se llena, agregamos la clase 'is-filled'
        if ($("#clientname").val() !== '') {
            $("#clientname").closest('.input-group').addClass('is-filled');
        }
    });

    // Script para asegurarse que los labels floten si el campo ya tiene un valor
    document.querySelectorAll('.form-control').forEach(function(input) {
        if (input.value !== '') {
            input.closest('.input-group').classList.add('is-filled');
        }
    });
});



document.addEventListener('DOMContentLoaded', function () {
    // Detectar el tema (oscuro o claro)
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

    // Función para determinar el color basado en el tema
    function getLabelColor() {
        return prefersDarkScheme.matches ? 'white' : 'black';  // Blanco para oscuro, negro para claro
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


$(document).ready(function() {
    // Detectar el tema (oscuro o claro)
    const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)");

    // Función para determinar el color basado en el tema
    function getLabelColor() {
        return prefersDarkScheme.matches ? 'white' : 'black';  // Blanco para oscuro, negro para claro
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


document.addEventListener('DOMContentLoaded', function () {
    // Escuchar eventos de clic en los botones de eliminar
    document.querySelectorAll('button[type="submit"]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Evitar que el clic se propague a otros elementos
            event.stopPropagation();
        });
    });
});
