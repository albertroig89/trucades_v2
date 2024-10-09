//Script para agregar teléfonos adicionales en los clientes
$(document).ready(function() {
    $("#add_phone").click(function(){
        var contador = $("input[type='text']").length;

        $(this).before('<div class="form-group input-group mb-4 input-group-static mt-4" style="position: relative;"><label class="form-label" for="phones'+ contador +'">Teléfono '+ contador +':</label><input name="phones[]" type="text" class="form-control" id="phones'+ contador +'"><button type="button" class="btn btn-default delete_phone mt-4">Borrar telèfon</button></div>');
    });
    $(document).on('click', '.delete_phone', function(){
        $(this).parent().remove();
    });
});


//Script para alternar el tipo de input entre "password" y "text"
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
