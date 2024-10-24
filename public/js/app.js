// Script para agregar teléfonos adicionales en los clientes
$(document).ready(function() {
    $("#add_phone").click(function() {
        // Contar el número de inputs de teléfonos addicionales (inicia desde 0 en el formulario de creacion)
        var currentCount = $(".phone-input-additional").length;

        // Número para mostrar en el label (inicia desde 1)
        var displayIndex = currentCount + 2;

        // Crear nuevo HTML para el teléfono adicional
        var newPhoneInput = `
            <div class="form-group input-group mb-4 input-group-static mt-4 is-focus" style="position: relative;">
                <label class="form-label" for="phones${currentCount}">Teléfono ${displayIndex}:</label>
                <input name="phones[]" type="text" class="form-control phone-input phone-input-additional" id="phones${currentCount}">
                <div class="button">
                    <button type="button" class="btn btn-default delete_phone btn-sm mt-2">Borrar teléfono</button>
                </div>
                <!-- Error message for additional phones -->
<!--                @if($errors->has('phones.' + currentCount))-->
<!--                    <div class="invalid-feedback">-->
<!--                        <small>{{ $errors->first('phones.' + currentCount) }}</small>-->
<!--                    </div>-->
<!--                @endif-->
            </div>`;

        // Añadir el nuevo teléfono justo después del último input de teléfono
        $(".phone-input").last().closest('.form-group').after(newPhoneInput);

        // Reactivar la funcionalidad de Bootstrap para los labels flotantes
        $(`#phones${currentCount}`).on('focus', function() {
            $(this).closest('.form-group').addClass('is-focused');
        }).on('blur', function() {
            if ($(this).val() === '') {
                $(this).closest('.form-group').removeClass('is-focused');
            }
        });
    });

    // Eliminar teléfonos adicionales
    $(document).on('click', '.delete_phone', function() {
        $(this).closest('.form-group').remove();
    });
});






// Script para alternar el tipo de input entre "password" y "text"
document.addEventListener('DOMContentLoaded', function () {
    const passwordInput = document.getElementById('password');
    const passwordConfirmInput = document.getElementById('password_confirmation');
    const toggleIcon = document.getElementById('toggleIcon');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

    // Alternar visibilidad del campo de contraseña principal
    if (passwordInput && toggleIcon) {
        toggleIcon.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    }

    // Alternar visibilidad del campo de confirmación de contraseña
    if (passwordConfirmInput && toggleConfirmIcon) {
        toggleConfirmIcon.addEventListener('click', function () {
            const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmInput.setAttribute('type', type);
            this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
        });
    }
});



//Script para inicializar el select2
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



//Script para evitar que el clic se propague a otros elementos al eliminar elemento
document.addEventListener('DOMContentLoaded', function () {
    // Escuchar eventos de clic en los botones de eliminar
    document.querySelectorAll('button[type="submit"]').forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Evitar que el clic se propague a otros elementos
            event.stopPropagation();
        });
    });
});

// Script para cambiar la vista de la página con links en lugar de botones
document.addEventListener('DOMContentLoaded', function () {
    // Verificar si el enlace para "Escritorio" existe antes de agregar el evento
    const desktopViewLink = document.getElementById('desktop-view');
    if (desktopViewLink) {
        desktopViewLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir comportamiento predeterminado
            console.log('Enviando preferencia de vista: Escritorio');
            document.getElementById('desktop').value = 1; // Setear el valor del campo oculto
            document.getElementById('view-preference-form').submit(); // Enviar formulario
        });
    }

    // Verificar si el enlace para "Móvil" existe antes de agregar el evento
    const mobileViewLink = document.getElementById('mobile-view');
    if (mobileViewLink) {
        mobileViewLink.addEventListener('click', function(event) {
            event.preventDefault(); // Prevenir comportamiento predeterminado
            console.log('Enviando preferencia de vista: Móvil');
            document.getElementById('desktop').value = 0; // Setear el valor del campo oculto
            document.getElementById('view-preference-form').submit(); // Enviar formulario
        });
    }
});


document.addEventListener('DOMContentLoaded', function () {
    console.log("Script de actualización del moving-tab se ha cargado.");

    const desktopViewLink = document.getElementById('desktop-view');
    const mobileViewLink = document.getElementById('mobile-view');
    const desktopInput = document.getElementById('desktop');
    const viewPreferenceForm = document.getElementById('view-preference-form');
    const navWrapper = document.querySelector('.nav-wrapper .nav-pills');

    if (desktopViewLink && mobileViewLink && desktopInput && navWrapper) {
        let movingDiv;

        // Crear el `moving-tab` una sola vez
        if (!navWrapper.querySelector('.moving-tab')) {
            movingDiv = document.createElement('div');
            movingDiv.classList.add('moving-tab', 'position-absolute', 'nav-link');
            movingDiv.style.transition = '.5s ease';
            navWrapper.appendChild(movingDiv);
            console.log("Se ha creado el moving-tab.");
        } else {
            movingDiv = navWrapper.querySelector('.moving-tab');
        }

        const updateViewState = () => {
            console.log("Actualizando el moving-tab.");

            // Obtener el enlace activo en función de la clase "active"
            const activeLink = document.querySelector('.nav-link.active');

            if (activeLink && movingDiv) {
                // Actualizar el moving-tab para que coincida con el enlace activo
                const offsetWidth = activeLink.offsetWidth;
                const offsetLeft = activeLink.offsetLeft;

                movingDiv.style.width = `${offsetWidth}px`;
                movingDiv.style.transform = `translate3d(${offsetLeft}px, 0, 0)`;

                console.log(`Moving-tab actualizado: width=${offsetWidth}, left=${offsetLeft}`);
            } else {
                console.log("No se encontró el enlace activo o el moving-tab.");
            }
        };

        // Inicializar estado después de la carga completa del DOM
        updateViewState();

        // Eventos para cambiar la vista
        desktopViewLink.addEventListener('click', function (event) {
            event.preventDefault();
            console.log('Enviando preferencia de vista: Escritorio');
            desktopInput.value = 1;
            viewPreferenceForm.submit();
        });

        mobileViewLink.addEventListener('click', function (event) {
            event.preventDefault();
            console.log('Enviando preferencia de vista: Móvil');
            desktopInput.value = 0;
            viewPreferenceForm.submit();
        });

        // Actualizar `moving-tab` al redimensionar la ventana
        window.addEventListener('resize', function () {
            updateViewState();
        });

        // Forzar la actualización del moving-tab después de un pequeño retraso
        window.addEventListener('load', function () {
            setTimeout(() => {
                console.log("Página cargada completamente, actualizando estado.");
                updateViewState();
            }, 200);
        });
    } else {
        console.log("No se encontraron todos los elementos necesarios para actualizar el moving-tab.");
    }
});

//Scripts AJAX para buscar clientes de forma dinamica
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search-client');
    const resultsContainer = document.getElementById('resultsContainer');

    if (searchInput && resultsContainer) {
        searchInput.addEventListener('input', debounce(function () {
            const searchValue = this.value;

            // Determinar el tipo de vista actual (escritorio o móvil)
            let viewType = 'clientstable'; // Valor predeterminado

            const desktopViewLink = document.getElementById('desktop-view');
            const mobileViewLink = document.getElementById('mobile-view');

            // Verificamos si las pestañas existen y cuál tiene la clase 'active'
            if (desktopViewLink && desktopViewLink.classList.contains('active')) {
                viewType = 'clientstable';
            } else if (mobileViewLink && mobileViewLink.classList.contains('active')) {
                viewType = 'clientcards';
            }

            // Hacer la solicitud fetch
            fetch(`/clients/search?search=${encodeURIComponent(searchValue)}&viewType=${viewType}`, {
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.html) {
                        resultsContainer.innerHTML = data.html;
                    }
                })
                .catch(error => console.error('Error:', error));
        }, 300));
    }
});

// Función debounce para optimizar las búsquedas
function debounce(func, delay) {
    let debounceTimer;
    return function () {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}


//Script para funcionamiento del flatpickr
document.addEventListener("DOMContentLoaded", function() {
    const datepickers = document.querySelectorAll(".datepicker");
    datepickers.forEach(function(datepicker) {
        flatpickr(datepicker, {
            enableTime: true,
            dateFormat: "d-m-Y H:i", // Formato similar al que ya tienes
            time_24hr: true,         // Para mostrar el tiempo en formato 24 horas
            minuteIncrement: 15,     // Intervalo de 15 minutos
            locale: flatpickr.l10ns.es, // Aplica el idioma español
            minDate: new Date(new Date().setMonth(new Date().getMonth() - 6)), // Seis meses antes de hoy
            maxDate: new Date().setHours(23, 59, 59, 999), // Establece la fecha límite al final del día de hoy
            defaultDate: datepicker.value ? new Date(datepicker.value) : new Date().setSeconds(0, 0), // Ajusta para quitar segundos
        });
    });
});
