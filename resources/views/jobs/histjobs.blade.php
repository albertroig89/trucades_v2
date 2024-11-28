<x-app-layout>
    <main>

        @include('layouts.partials.tablesheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Trabajos realizados</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                @if($histjobs->count())
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($histjobs as $histjob)
                                            <tr onclick="window.location='{{ route('jobs.show', ['job' => $histjob]) }}';" class="custom-table-row">
                                                <th>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            @if($histjob->avatar)
                                                                <img src="{{ asset($histjob->avatar) }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @else
                                                                <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $histjob->username }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $histjob->email }}</p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td scope="row">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($histjob->created_at)->format('d-m-y H:i') }}</span>
                                                </td>
                                                <td>
                                                    <div class=" d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $histjob->clientname }}</h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 450px">
                                                    <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($histjob->job, 70, '...') }}</p>
                                                </td>
                                                <td><h6 class="mb-0 text-sm">{{  $histjob->attempts }}</h6></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($histjob->inittime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($histjob->endtime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ $histjob->totalmin }} min</span></td>
                                                <td>
                                                    <a href="{{ route('jobs.edit', ['job' => $histjob]) }}" type="button" class="btn btn-default btn-sm w-auto">Editar</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('jobs.destroy', $histjob) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-default btn-sm w-auto" onclick="return confirm('¿Seguro que quieres eliminar el trabajo del historico?')" type="submit">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h6 class="text-center text-secondary">No tienes trabajos en el histórico</h6>
                                @endif
                            </div>
                        </div>
                        <div class="row text-center py-2">
                            <div class="col-4 mx-auto">
                                {{ $histjobs->links('components.bootstrap-5-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
