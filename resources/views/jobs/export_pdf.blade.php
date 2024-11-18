<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exportación de Trabajos</title>
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
                border: 1px solid #ddd;
                padding: 5px;
            }
            th {
                background-color: #f2f2f2;
                text-align: left;
            }
            td:nth-child(5), td:nth-child(6) {
                white-space: nowrap;
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
                $currentClientId = null;
                $totalMinutesClient = 0;
            @endphp

            @foreach ($jobs as $job)
                @if ($currentClientId !== $job->client_id)
                    @if ($currentClientId !== null)
                        <!-- Mostrar el total de minutos para el cliente anterior -->
                        <tr style="background-color: #f2f2f2;">
                            <td colspan="5" style="font-weight: bold;">Minutos totales para "{{ $currentClientName }}"</td>
                            <td colspan="2" style="font-weight: bold;">
                                {{ $totalMinutesClient }} min
                                ({{ number_format($totalMinutesClient / 60, 2) }} horas)
                            </td>
                        </tr>
                    @endif
                    <!-- Reiniciar valores para el nuevo cliente -->
                    @php
                        $currentClientId = $job->client_id;
                        $currentClientName = $job->clientname;
                        $totalMinutesClient = 0;
                    @endphp
                @endif

                <!-- Mostrar cada trabajo -->
                <tr>
                    <td>{{ $job->user->name }}</td>
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
            @if ($currentClientId !== null)
                <tr style="background-color: #f2f2f2;">
                    <td colspan="5" style="font-weight: bold;">Minutos totales para "{{ $currentClientName }}"</td>
                    <td colspan="2" style="font-weight: bold;">
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

