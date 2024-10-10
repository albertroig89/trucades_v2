//Scripts para inicializar datetimepicker
$(document).ready(function () {
    // Obtener los valores antiguos si existen
    // var oldInitTime = '{{ old('inittime') }}';
    // var oldEndTime = '{{ old('endtime') }}';

    // Inicialización para el campo inittime
    $('#inittime').datetimepicker({
        format: 'd-m-Y H:i',                // Formato de fecha: día-mes-año hora:minuto
        // mask:'39-19-99 29:59',
        startDate: new Date(new Date().getTime() - 60 * 60 * 1000),              // Establece la fecha de inicio como la fecha actual - 1 hora
        step: 30                            // Intervalo de 30 minutos para la selección de la hora
    });

    // Establecer el valor si existe uno viejo
    // if (oldInitTime) {
    //     $('#inittime').val(oldInitTime);
    // }

    // Inicialización para el campo endtime
    $('#endtime').datetimepicker({
        format: 'd-m-Y H:i',                // Mismo formato para endtime
        // mask:'39-19-99 29:59',
        startDate: new Date(),              // La fecha de inicio también será hoy
        step: 30                            // Intervalo de 30 minutos para la hora
    });

    // Establecer el valor si existe uno viejo
    // if (oldEndTime) {
    //     $('#endtime').val(oldEndTime);
    // }
});
