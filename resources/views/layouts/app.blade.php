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

{{--        <!-- Nucleo Icons -->--}}
{{--        <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />--}}
{{--        <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />--}}

        <!-- Font Awesome Icons -->
        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

        <!-- Material Icons -->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

        <!-- CSS Files -->
        <link id="pagestyle" href="{{asset('assets/css/material-kit.css')}}" rel="stylesheet" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/styles.css') }}" media="screen" /> <!--ESTILS PROPIS-->

        {{--Favicon--}}
        <link rel="icon" href="{{ asset('images/AR_fnegre.png') }}" type="image/png">

        {{--    Este script comprueba si el navegador utiliza o no el modo oscuro para adaptar el tema de la app--}}
{{--        <script defer>--}}
{{--            document.addEventListener('DOMContentLoaded', () => {--}}
{{--                if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {--}}
{{--                    document.body.classList.add('dark-version');--}}
{{--                }--}}
{{--            });--}}
{{--        </script>--}}

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
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="custom-header">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
                {{ $slot }}
        </div>


        <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('assets/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>


    </body>
    @include('layouts.footer')
</html>
