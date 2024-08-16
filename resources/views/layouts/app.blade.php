<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Llamadas') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    {{--        <link rel="preconnect" href="https://fonts.bunny.net">--}}
    {{--        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />--}}

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="{{asset('assets/css/nucleo-icons.css')}}" rel="stylesheet" />
    <link href="{{asset('assets/css/nucleo-svg.css')}}" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->

    {{--Favicon--}}
    <link rel="icon" href="{{ asset('images/AR_fnegre.png') }}" type="image/png">

    <link id="pagestyle" href="{{asset('assets/css/material-kit.css?v=3.0.4')}}" rel="stylesheet" />

</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        {{ $slot }}
    </main>
</div>


<script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>


{{--        <!--   Core JS Files   -->--}}
{{--        <script src="{{ asset('assets/js/core/popper.min.js') }}" type="text/javascript"></script>--}}
{{--        <script src="{{ asset('assets/js/core/bootstrap.min.js') }}" type="text/javascript"></script>--}}
{{--        <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>--}}

{{--        <!--  Plugin for TypedJS, full documentation here: https://github.com/inorganik/CountUp.js -->--}}
{{--        <script src="{{ asset('assets/js/plugins/countup.min.js') }}"></script>--}}

{{--        <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>--}}

{{--        <script src="{{ asset('assets/js/plugins/prism.min.js') }}"></script>--}}
{{--        <script src="{{ asset('assets/js/plugins/highlight.min.js') }}"></script>--}}

{{--        <!--  Plugin for Parallax, full documentation here: https://github.com/dixonandmoe/rellax -->--}}
{{--        <script src="{{ asset('assets/js/plugins/rellax.min.js') }}"></script>--}}
{{--        <!--  Plugin for TiltJS, full documentation here: https://gijsroge.github.io/tilt.js/ -->--}}
{{--        <script src="{{ asset('assets/js/plugins/tilt.min.js') }}"></script>--}}
{{--        <!--  Plugin for Selectpicker - ChoicesJS, full documentation here: https://github.com/jshjohnson/Choices -->--}}
{{--        <script src="{{ asset('assets/js/plugins/choices.min.js') }}"></script>--}}

{{--        <!-- Control Center for Material UI Kit: parallax effects, scripts for the example pages etc -->--}}
{{--        <!--  Google Maps Plugin    -->--}}

{{--        <script src="Google API Key"></script>--}}
{{--        <script src="{{ asset('assets/js/material-kit.min.js?v=3.0.4') }}" type="text/javascript"></script>--}}

{{--        <script type="text/javascript">--}}

{{--            if (document.getElementById('state1')) {--}}
{{--                const countUp = new CountUp('state1', document.getElementById("state1").getAttribute("countTo"));--}}
{{--                if (!countUp.error) {--}}
{{--                    countUp.start();--}}
{{--                } else {--}}
{{--                    console.error(countUp.error);--}}
{{--                }--}}
{{--            }--}}
{{--            if (document.getElementById('state2')) {--}}
{{--                const countUp1 = new CountUp('state2', document.getElementById("state2").getAttribute("countTo"));--}}
{{--                if (!countUp1.error) {--}}
{{--                    countUp1.start();--}}
{{--                } else {--}}
{{--                    console.error(countUp1.error);--}}
{{--                }--}}
{{--            }--}}
{{--            if (document.getElementById('state3')) {--}}
{{--                const countUp2 = new CountUp('state3', document.getElementById("state3").getAttribute("countTo"));--}}
{{--                if (!countUp2.error) {--}}
{{--                    countUp2.start();--}}
{{--                } else {--}}
{{--                    console.error(countUp2.error);--}}
{{--                }--}}
{{--            }--}}
{{--        </script>--}}







</body>
</html>
