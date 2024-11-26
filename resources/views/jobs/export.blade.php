<x-app-layout>
    <main>
        @include('layouts.partials.header')

        <div class="container-fluid py-4">
            <div class="row form-card-position">
                <div class="col-12">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3 d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <h6 class="text-white ps-3">Exportar trabajos realizados entre {{ $initdate }} y el {{ $enddate }}
                                        @if ($client)
                                            para el cliente "{{ $client->name }}"
                                        @endif

                                        @if ($user)
                                            por el usuario "{{ $user->name }}"
                                        @endif
                                    </h6>
                                </div>
                                <form action="{{ route('jobs.exportperform') }}" target="_blank" id="export-form" data-action-url="{{ route('jobs.exportperform') }}" class="d-flex flex-column flex-md-row align-items-start align-items-md-center gap-3 w-100 w-md-auto" onsubmit="return confirmDeleteAfterExport();">
                                    @csrf
                                    <input type="hidden" name="initdate" value="{{ request('initdate') }}">
                                    <input type="hidden" name="enddate" value="{{ request('enddate') }}">
                                    <input type="hidden" name="client_id" value="{{ request('client_id') }}">
                                    <input type="hidden" name="user_id" value="{{ request('user_id') }}">
                                    <div class="format-select-container form-group mb-0 me-3 d-inline-flex align-items-center">
                                        <select class="format-select form-control form-control-sm" name="export_format" id="export_format" required>
                                            <option value="">Elige un formato</option>
                                            <option value="pdf">PDF</option>
                                            <option value="excel">Excel</option>
                                            <option value="csv">CSV</option>
                                            <option value="print">Imprimir</option>
                                            <option value="delete">Eliminar</option>
                                        </select>
                                    </div>
                                    <div class="form-check me-3 mb-0 d-flex align-items-center mb-0 gap-2">
                                        <input class="form-check-input mb-1" type="checkbox" name="delete_after_export" id="delete_after_export">
                                        <label class="form-check-label text-white mb-0 font-weight-bold" for="delete_after_export">
                                            Eliminar después de exportar
                                        </label>
                                    </div>
                                    <div class="text-md-end ms-md-auto">
                                        <button type="submit" class="btn btn-default btn-sm w-auto me-md-3">Exportar Trabajos</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                @if($jobs->count())
                                    <table class="table custom-table align-items-center mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Empleado</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Trabajo realizado</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Intentos</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Inicio del trabajo</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Final del trabajo</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tiempo empleado</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $currentClient = null;
                                            $totalMinutesClient = 0;
                                            $currentClientName = '';
                                        @endphp

                                        @foreach ($jobs as $job)
                                            @if ($currentClient !== $job->client_id)
                                                @if ($currentClient !== null)
                                                    <!-- Mostrar el total de minutos para el cliente anterior -->
                                                    <tr class="export-totals">
                                                        <td colspan="7">Minutos totales para "{{ $currentClientName }}"</td>
                                                        <td>
                                                            {{ $totalMinutesClient }} min
                                                            ({{ number_format($totalMinutesClient / 60, 2) }} horas)
                                                        </td>
                                                    </tr>
                                                @endif
                                                @php
                                                    $currentClient = $job->client_id;
                                                    $currentClientName = $job->clientname;
                                                    $totalMinutesClient = 0;
                                                @endphp
                                            @endif

                                            <!-- Mostrar cada trabajo -->
                                            <tr>
                                                <th>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            @if($job->user->avatar)
                                                                <img src="{{ asset($job->user->avatar) }}" alt="avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @else
                                                                <img src="{{ asset('images/AR_fblanc.png') }}" alt="avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $job->user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $job->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-y H:i') }}</span>
                                                </td>
                                                <td>
                                                    <div class=" d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $job->clientname }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 450px">
                                                    <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($job->job, 70, '...') }}</p>
                                                </td>
                                                <td><h6 class="mb-0 text-sm">{{ $job->attempts }}</h6></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->inittime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->endtime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ $job->totalmin }} min</span></td>
                                            </tr>

                                            @php
                                                $totalMinutesClient += $job->totalmin;
                                            @endphp
                                        @endforeach

                                        <!-- Mostrar el total para el último cliente -->
                                        @if ($currentClient !== null)
                                            <tr class="export-totals">
                                                <td colspan="7">Minutos totales para "{{ $currentClientName }}"</td>
                                                <td>
                                                    {{ $totalMinutesClient }} min
                                                    ({{ number_format($totalMinutesClient / 60, 2) }} horas)
                                                </td>
                                            </tr>
                                        @endif

                                        <!-- Mostrar el total global solo si se está en la última página -->
                                        @if($jobs->hasMorePages() == false)
                                            <tr class="export-totals">
                                                <td colspan="7"><strong>Tiempo total de todos los trabajos:</strong></td>
                                                <td>
                                                    <strong>{{ $totalMinutes }} minutos ({{ $totalHours }} horas)</strong>
                                                </td>
                                            </tr>
                                        @endif
                                        </tbody>
                                    </table>
                                @elseif (session('success'))
                                    <h6 class="text-center alert alert-success m-4">{{ session('success') }}</h6>
                                @else
                                    <!-- Mostrar el mensaje de éxito si existe -->
                                    <h6 class="text-center text-secondary m-4">No se encontraron trabajos para los filtros especificados.</h6>
                                @endif
                            </div>
                        </div>
                        <div class="row text-center py-2">
                            <div class="col-4 mx-auto">
                                {{ $jobs->links('components.bootstrap-5-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>


