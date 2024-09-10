<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Llamadas') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

        <!--     Fonts and icons     -->
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

{{--    Script for client selector select2--}}
    <script>
        $(function(){
            $('.select2').select2({
                placeholder: "Selecciona un cliente",
            }).on('change', function(e) {
                var data = $(".select2 option:selected").text();
                $("#clientname").val(data);
                $("#clientphone").prop("disabled", true);
            });
        });
    </script>

{{--    Script for add more phones in the same client--}}
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

{{--    Script for datetimepicker--}}
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

{{--    Script for avatar upload--}}
{{--    <script>--}}
{{--        function updateFileName() {--}}
{{--            const input = document.getElementById('avatar');--}}
{{--            const fileChosen = document.getElementById('file-chosen');--}}

{{--            if (input.files.length > 0) {--}}
{{--                fileChosen.textContent = input.files[0].name;--}}
{{--            } else {--}}
{{--                fileChosen.textContent = 'Ningún archivo seleccionado';--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
{{--</html>--}}
