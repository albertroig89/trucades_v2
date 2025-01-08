<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exportación de Trabajos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: small;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #9d9d9d;
            padding: 5px;
        }
        th {
            background-color: #D9D9D9;
            text-align: left;
        }
        td:nth-child(5), td:nth-child(6) {
            white-space: nowrap;
        }
        .total-row {
            background-color: #E3E3E3;
            font-weight: bold;
        }
        @media print {
            th {
                -webkit-print-color-adjust: exact; /* Asegura que se impriman colores en algunos navegadores */
                color-adjust: exact; /* Asegura que se impriman colores */
            }
            .total-row {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
                background-color: #E3E3E3 !important; /* Forzar el color de fondo para impresión */
            }
        }
    </style>
    {{--Favicon--}}
    <link rel="icon" href="{{ asset('images/AR_fnegre.png') }}" type="image/png">
</head>
<header>
    <div>
        <div>
            <div>
                <h2>
                    {{ $title }}
                </h2>
            </div>
        </div>
    </div>
</header>
<body>
<table>
    <thead>
    <tr>
        <th>Empleado</th>
        <th>Cliente</th>
        <th>Trabajo realizado</th>
        <th>Intentos</th>
        <th>Inicio del trabajo</th>
        <th>Fin del trabajo</th>
        <th>Tiempo empleado</th>
    </tr>
    </thead>
    <tbody>
    @php
        $currentClientName = null;
        $totalMinutesClient = 0;
    @endphp

    @foreach ($jobs as $job)
        @if ($currentClientName !== $job->clientname)
            @if ($currentClientName !== null)
                <!-- Mostrar el total de minutos para el cliente anterior -->
                <tr class="total-row">
                    <td colspan="5">Minutos totales para "{{ $currentClientName }}"</td>
                    <td colspan="2">
                        {{ $totalMinutesClient }} min
                        ({{ number_format($totalMinutesClient / 60, 2) }} horas)
                    </td>
                </tr>
            @endif
            <!-- Reiniciar valores para el nuevo cliente -->
            @php
                $currentClientName = $job->clientname;
                $totalMinutesClient = 0;
            @endphp
        @endif

        <!-- Mostrar cada trabajo -->
        <tr>
            <td>{{ $isFromHistory ? $job->username : $job->user->name }}</td>
            <td>{{ $job->clientname }}</td>
            <td>{{ $job->job }}</td>
            <td>{{ $job->attempts }}</td>
            <td>{{ \Carbon\Carbon::parse($job->inittime)->format('d-m-y H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($job->endtime)->format('d-m-y H:i') }}</td>
            <td>{{ $job->totalmin }} min</td>
        </tr>

        <!-- Sumar los minutos al total del cliente actual -->
        @php
            $totalMinutesClient += $job->totalmin;
        @endphp
    @endforeach

    <!-- Mostrar el total para el último cliente -->
    @if ($currentClientName !== null)
        <tr class="total-row">
            <td colspan="5">Minutos totales para "{{ $currentClientName }}"</td>
            <td colspan="2">
                {{ $totalMinutesClient }} min
                ({{ number_format($totalMinutesClient / 60, 2) }} horas)
            </td>
        </tr>
    @endif
    </tbody>
</table>
<!-- Mostrar el total de minutos y horas al final del PDF -->
<div style="margin-top: 20px; font-size: large">
    <strong>Tiempo total de todos los trabajos: {{ $totalMinutes }} minutos ({{ $totalHours }} horas)</strong>
</div>

@if (isset($print) && $print)
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
@endif
</body>
</html>


