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
                @isset($clientsheader)
                    <header class="custom-header">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $clientsheader }}
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

        {{--Script para determinar rutas absolutas para las imagenes que se cargan desde app.js--}}
        <script>
            const baseUrl = "{{ asset('') }}";  // Definir baseUrl para app.js
        </script>
        {{--Scripts propios para el funcionamiento de la pagina--}}
        <script src="{{ asset('js/app.js') }}"></script>
    </body>

</html>
