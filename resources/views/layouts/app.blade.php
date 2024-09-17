<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Llamadas') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

        <!-- Scripts al final del body -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/datetimepicker@2.5.4/jquery.datetimepicker.full.min.js"></script>

        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <!-- CSS Files -->
        <link id="pagestyle" href="{{asset('assets/css/material-kit.css')}}" rel="stylesheet" /> <!--Theme styles-->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> <!-- Select2 Styles-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" media="screen" /> <!--Custom styles-->

        {{--Favicon--}}
        <link rel="icon" href="{{ asset('images/AR_fnegre.png') }}" type="image/png">

        <script>
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
        </script>

    </head>
    <body class="custom body font-sans antialiased">
        <div class="page-container">
            <div class="content-wrap">
                @include('layouts.navigation')

                <!-- Page Heading -->
                @isset($header)
                    <header class="custom-header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset
                @isset($tablesheader)
                    <header class="custom-header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $tablesheader }}
                        </div>
                    </header>
                @endisset
                @isset($callsheader)
                    <header class="custom-header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $callsheader }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                {{ $slot }}
            </div>
            @include('layouts.footer')
        </div>

        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>
    </body>



    {{-- Script for add more phones in the same client --}}
    <script>
        $(document).ready(function() {
            $("#add_phone").click(function(){
                var contador = $("input[type='text']").length;

                $(this).before('<div><label for="phones'+ contador +'">Telèfon:</label><input type="text" class="form-control" aria-describedby="clientHelp" placeholder="977 70 70 70" id="phones'+ contador +'" name="phones[]"/><br><button type="button" class="btn btn-default delete_phone float-right">Borrar telèfon</button></div>');
            });
            $(document).on('click', '.delete_phone', function(){
                $(this).parent().remove();
            });
        });
    </script>

    {{-- Script for datetimepicker --}}
    <script>
        $.datetimepicker.setLocale('es');

        $('#inittime').datetimepicker({
            format:'d-m-y H:i',
            mask:'39-19-99 29:59'
        });

        $('#endtime').datetimepicker({
            format:'d-m-y H:i',
            mask:'39-19-99 29:59'
        });

        $('#inittime2').datetimepicker({
            format:'d-m-y H:i',
        });

        $('#endtime2').datetimepicker({
            format:'d-m-y H:i',
        });
    </script>

    {{-- Script for password toggle icon --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            toggleIcon.addEventListener('click', function () {
                // Alternar el tipo de input entre "password" y "text"
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                // Cambiar el ícono entre "visibility" y "visibility_off"
                this.textContent = type === 'password' ? 'visibility' : 'visibility_off';
            });
        });
    </script>

    {{-- Script for labels filled on focus --}}
    <script>
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
    </script>

    {{-- Script for label color on focus in forms, only for select and textarea --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Selecciona todos los elementos select y textarea en la página
            const inputs = document.querySelectorAll('select, textarea');

            // Itera sobre cada input y agrega los listeners de eventos
            inputs.forEach(function(input) {
                // Selecciona el label correspondiente basado en el atributo "for" del label
                const label = document.querySelector(`label[for="${input.id}"]`);

                if (label) {
                    // Función para cambiar el color del label cuando el input tiene el foco
                    input.addEventListener('focus', function() {
                        label.style.color = 'white';  // Cambiar a blanco al obtener el foco
                    });

                    // Función para restaurar el color del label cuando el input pierde el foco
                    input.addEventListener('blur', function() {
                        label.style.color = '';  // Restaurar el color original al perder el foco
                    });
                }
            });
        });
    </script>

    {{-- Script para cambiar el color de los labels del select2 --}}
    <script>
        $(document).ready(function() {
            // Inicializar select2
            $('.select2').select2({
                placeholder: "Selecciona un cliente"
            });

            // Manejar el evento cuando select2 se abre
            $('.select2').on('select2:open', function() {
                const label = document.querySelector(`label[for="${this.id}"]`);
                if (label) {
                    label.style.color = 'white';  // Cambiar a blanco cuando el select2 está abierto
                }
            });

            // Manejar el evento cuando select2 se cierra
            $('.select2').on('select2:close', function() {
                const label = document.querySelector(`label[for="${this.id}"]`);
                if (label) {
                    label.style.color = '';  // Restaurar el color original cuando se cierra el select2
                }
            });
        });
    </script>

    <script>
        function changeViewPreference(isDesktop) {
            const form = document.getElementById('view-preference-form');
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'desktop';
            input.value = isDesktop ? 'true' : 'false';

            // Eliminar el input existente antes de agregar uno nuevo
            const existingInput = form.querySelector('input[name="desktop"]');
            if (existingInput) {
                form.removeChild(existingInput);
            }

            form.appendChild(input);
            form.submit();
        }
    </script>




    {{--    Script for client selector select2--}}
{{--    <script>--}}
{{--        $(function(){--}}
{{--            $('.select2').select2({--}}
{{--                placeholder: "Selecciona un cliente",--}}
{{--            }).on('change', function(e) {--}}
{{--                var data = $(".select2 option:selected").text().trim();  // Eliminar espacios adicionales--}}
{{--                $("#clientname").val(data);--}}
{{--                $("#clientphone").prop("disabled", true);--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    Script for add more phones in the same client--}}
{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            $("#add_phone").click(function(){--}}
{{--                var contador = $("input[type='text']").length;--}}

{{--                $(this).before('<div><label for="phones'+ contador +'">Telèfon:</label><input type="text" class="form-control" aria-describedby="clientHelp" placeholder="977 70 70 70" id="phones'+ contador +'" name="phones[]"/><br><button type="button" class="btn btn-default delete_phone float-right">Borrar telèfon</button></div>');--}}
{{--            });--}}
{{--            $(document).on('click', '.delete_phone', function(){--}}
{{--                $(this).parent().remove();--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    Script for datetimepicker--}}
{{--    <script>--}}
{{--        $.datetimepicker.setLocale('es');--}}

{{--        $('#inittime').datetimepicker({--}}
{{--            format:'d-m-y H:i',--}}
{{--            mask:'39-19-99 29:59'--}}
{{--        });--}}

{{--        $('#endtime').datetimepicker({--}}
{{--            format:'d-m-y H:i',--}}
{{--            mask:'39-19-99 29:59'--}}
{{--        });--}}

{{--        $('#inittime2').datetimepicker({--}}
{{--            format:'d-m-y H:i',--}}
{{--        });--}}

{{--        $('#endtime2').datetimepicker({--}}
{{--            format:'d-m-y H:i',--}}
{{--        });--}}
{{--    </script>--}}

{{--Script for password toggle icon--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            const passwordInput = document.getElementById('password');--}}
{{--            const toggleIcon = document.getElementById('toggleIcon');--}}
{{--            toggleIcon.addEventListener('click', function () {--}}
{{--                // Alternar el tipo de input entre "password" y "text"--}}
{{--                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';--}}
{{--                passwordInput.setAttribute('type', type);--}}
{{--                // Cambiar el ícono entre "visibility" y "visibility_off"--}}
{{--                this.textContent = type === 'password' ? 'visibility' : 'visibility_off';--}}
{{--            });--}}
{{--        });--}}

{{--        // document.getElementById('toggleIcon').addEventListener('click', function (e) {--}}
{{--        //     const passwordField = document.getElementById('password');--}}
{{--        //     const icon = document.getElementById('toggleIcon');--}}
{{--        //--}}
{{--        //     // Alternar el tipo de input entre password y text--}}
{{--        //     if (passwordField.type === 'password') {--}}
{{--        //         passwordField.type = 'text';--}}
{{--        //         icon.textContent = 'visibility_off'; // Cambiar icono a "visibility_off"--}}
{{--        //     } else {--}}
{{--        //         passwordField.type = 'password';--}}
{{--        //         icon.textContent = 'visibility'; // Cambiar icono a "visibility"--}}
{{--        //     }--}}
{{--        // });--}}
{{--    </script>--}}

{{--Script for labels filled on focus--}}
{{--    <script>--}}
{{--        $(function(){--}}
{{--            // Inicialización de select2 y escucha del evento 'change'--}}
{{--            $('.select2').select2({--}}
{{--                placeholder: "Selecciona un cliente",--}}
{{--            }).on('change', function(e) {--}}
{{--                var data = $(".select2 option:selected").text().trim();  // Eliminar espacios adicionales--}}
{{--                $("#clientname").val(data);--}}
{{--                $("#clientphone").prop("disabled", true);--}}

{{--                // Si el campo clientname se llena, agregamos la clase 'is-filled'--}}
{{--                if ($("#clientname").val() !== '') {--}}
{{--                    $("#clientname").closest('.input-group').addClass('is-filled');--}}
{{--                }--}}
{{--            });--}}

{{--            // Script para asegurarse que los labels floten si el campo ya tiene un valor--}}
{{--            document.querySelectorAll('.form-control').forEach(function(input) {--}}
{{--                if (input.value !== '') {--}}
{{--                    input.closest('.input-group').classList.add('is-filled');--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}

{{--    Script for label color on focus in forms, only for select and textarea--}}
{{--    <script>--}}
{{--        document.addEventListener('DOMContentLoaded', function () {--}}
{{--            // Selecciona todos los elementos select y textarea en la página--}}
{{--            const inputs = document.querySelectorAll('select, textarea');--}}

{{--            // Itera sobre cada input y agrega los listeners de eventos--}}
{{--            inputs.forEach(function(input) {--}}
{{--                // Selecciona el label correspondiente basado en el atributo "for" del label--}}
{{--                const label = document.querySelector(`label[for="${input.id}"]`);--}}

{{--                if (label) {--}}
{{--                    // Función para cambiar el color del label cuando el input tiene el foco--}}
{{--                    input.addEventListener('focus', function() {--}}
{{--                        label.style.color = 'white';  // Cambiar a blanco al obtener el foco--}}
{{--                    });--}}

{{--                    // Función para restaurar el color del label cuando el input pierde el foco--}}
{{--                    input.addEventListener('blur', function() {--}}
{{--                        label.style.color = '';  // Restaurar el color original al perder el foco--}}
{{--                    });--}}
{{--                }--}}
{{--            });--}}
{{--        });--}}
{{--    </script>--}}


{{--    <script>--}}
{{--        $(document).ready(function() {--}}
{{--            // Inicializar select2--}}
{{--            $('.select2').select2({--}}
{{--                placeholder: "Selecciona un cliente"--}}
{{--            });--}}

{{--            // Cambiar color del label cuando select2 recibe el foco--}}
{{--            $('.select2').on('select2:open', function() {--}}
{{--                const label = document.querySelector(`label[for="${this.id}"]`);--}}
{{--                if (label) {--}}
{{--                    label.style.color = 'white';  // Cambiar a blanco cuando el select2 está abierto--}}
{{--                }--}}
{{--            });--}}

{{--            // Restaurar el color cuando select2 pierde el foco--}}
{{--            $('.select2').on('select2:close', function() {--}}
{{--                const label = document.querySelector(`label[for="${this.id}"]`);--}}
{{--                if (label) {--}}
{{--                    label.style.color = '';  // Restaurar el color original--}}
{{--                }--}}
{{--            });--}}

{{--            // Rellenar el campo clientname al seleccionar un cliente--}}
{{--            $('.select2').on('change', function() {--}}
{{--                var data = $(".select2 option:selected").text().trim();  // Eliminar espacios adicionales--}}
{{--                $("#clientname").val(data).closest('.input-group').addClass('is-filled');--}}
{{--                $("#clientphone").prop("disabled", true);--}}
{{--            });--}}
{{--        });--}}

{{--    </script>--}}


</html>
