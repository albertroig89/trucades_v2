// Script para agregar teléfonos adicionales en los clientes
$(document).ready(function() {
    // Verificar si estamos en el formulario de creación/edición de clientes
    if ($('form#create-client, form#edit-client').length) {
        // Función para mostrar errores de validación si existen
        function showValidationErrors() {
            if (typeof validationErrors !== 'undefined' && validationErrors.phones) {
                validationErrors.phones.forEach((error, index) => {
                    // Seleccionar el input del teléfono correspondiente
                    const inputField = $(`input[name="phones[${index}]"]`);

                    // Verificar si el input existe
                    if (inputField.length) {
                        // Mostrar mensaje de error debajo del input
                        inputField.addClass('is-invalid'); // Añadir clase de error
                        inputField.next('.error-message').show().find('small').text(error[0]);
                    }
                });
            }
        }

        // Llamar a la función para mostrar errores de validación si existen
        showValidationErrors();

        // Agregar teléfono adicional al hacer clic en "Añadir Teléfono"
        $("#add_phone").click(function() {
            // Contar el número de inputs de teléfonos adicionales
            var currentCount = $(".phone-input-additional").length;

            // Número para mostrar en el label
            var displayIndex = currentCount + 2;

            // Crear nuevo HTML para el teléfono adicional
            var newPhoneInput = `
                <div class="form-group input-group mb-4 input-group-static mt-4 is-focus" style="position: relative;">
                    <label class="form-label" for="phones_${currentCount}">Teléfono ${displayIndex}:</label>
                    <input name="phones[${currentCount}]" type="text" class="form-control phone-input phone-input-additional" id="phones_${currentCount}">
                    <div class="button">
                        <button type="button" class="btn btn-default delete_phone btn-sm mt-2">Borrar teléfono</button>
                    </div>
                    <div class="invalid-feedback error-message" style="display: none;">
                        <small></small>
                    </div>
                </div>`;

            // Añadir el nuevo teléfono justo después del último input de teléfono
            $(".phone-input").last().closest('.form-group').after(newPhoneInput);

            // Reactivar la funcionalidad de Bootstrap para los labels flotantes
            $(`#phones_${currentCount}`).on('focus', function() {
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
    }
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

//Script para los estilos de cambio de vista "animacion"
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


//Script para funcionamiento del flatpickr para los trabajos
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

//Script para funcionamiento del flatpickr para las exportaciones
document.addEventListener("DOMContentLoaded", function() {
    const datepickersExport = document.querySelectorAll(".datepicker-export");
    datepickersExport.forEach(function(datepicker) {
        flatpickr(datepicker, {
            enableTime: false, // No habilitar la hora
            dateFormat: "d-m-Y", // Solo fecha
            locale: flatpickr.l10ns.es, // Aplica el idioma español
            minDate: new Date(new Date().setMonth(new Date().getMonth() - 6)), // Seis meses antes de hoy
            maxDate: new Date().setHours(23, 59, 59, 999), // Establece la fecha límite al final del día de hoy
            defaultDate: datepicker.value ? new Date(datepicker.value) : new Date(), // Fecha actual sin segundos
        });
    });
});

// Script para la exportación de trabajos para impresión en pestaña nueva
document.addEventListener('DOMContentLoaded', function() {
    const exportForm = document.querySelector('form[data-action-url]');
    const exportFormatSelect = document.getElementById('export_format');

    if (exportForm && exportFormatSelect) {
        exportForm.addEventListener('submit', function(event) {
            // Verificar si se seleccionó la opción de imprimir
            if (exportFormatSelect.value === 'print') {
                // Cambiar el atributo target a "_blank" para imprimir en una nueva pestaña
                exportForm.setAttribute('target', '_blank');
            } else {
                // Asegurarse de que las demás acciones no se realicen en una nueva pestaña
                exportForm.removeAttribute('target');
            }
        });
    }
});

// Script para mostrar alert de confirmación en caso de querer eliminar los trabajos después de la exportación
function confirmDeleteAfterExport() {
    // Obtener el checkbox
    const deleteAfterExportCheckbox = document.getElementById("delete_after_export");

    // Verificar si la casilla está marcada
    if (deleteAfterExportCheckbox && deleteAfterExportCheckbox.checked) {
        // Mostrar el alert de confirmación
        return confirm("¿Estás seguro de que deseas eliminar los registros después de la exportación?");
    }

    return true; // Si no está marcado, permitir el envío
}

// Script para recargar la página después de la exportación si se seleccionó "eliminar después de exportar"
document.addEventListener('DOMContentLoaded', function() {
    const exportForm = document.getElementById('export-form');
    const deleteAfterExportCheckbox = document.getElementById('delete_after_export');

    if (exportForm && deleteAfterExportCheckbox) {
        exportForm.addEventListener('submit', function(event) {
            // Verificar si se seleccionó eliminar después de exportar
            if (deleteAfterExportCheckbox.checked) {
                // Retrasar la recarga de la página para dar tiempo a la exportación
                setTimeout(function() {
                    window.location.reload();
                }, 10000); // Recargar después de 10 segundos
            }
        });
    }
});

//Script para mostrar un alert de confirmacion cuando se seleccione eliminar en el select de exportacion
document.addEventListener('DOMContentLoaded', function () {
    // Obtener los elementos necesarios
    const exportForm = document.querySelector('form[data-action-url]');
    const exportFormatSelect = document.getElementById('export_format');

    if (exportForm && exportFormatSelect) {
        // Agregar un evento para confirmar cuando se seleccione 'Eliminar'
        exportForm.addEventListener('submit', function (event) {
            if (exportFormatSelect.value === 'delete') {
                const confirmDelete = confirm("¿Estás seguro de que deseas eliminar permanentemente todos los registros seleccionados?");
                if (!confirmDelete) {
                    event.preventDefault(); // Cancelar el envío del formulario si el usuario cancela
                }
            }
        });
    }
});

