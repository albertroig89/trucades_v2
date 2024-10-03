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
                                <a href="{{ route('jobs.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nuevo Trabajo</a>
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
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($jobs as $job)


                                            <tr class="custom-table-row">
                                                <th>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            @if($job->user->avatar)
                                                                <img src="{{ $job->user->avatar }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @else
                                                                <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $job->user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $job->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td scope="row">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-y H:i') }}</span>
                                                </td>
                                                <td>
                                                    <div class=" d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $job->clientname }}</h6>
{{--                                                            @if (!empty($call->clientphone))--}}
{{--                                                                <p class="text-xs text-secondary mb-0">{{ $call->clientphone }}</p>--}}
{{--                                                            @else--}}
{{--                                                                @if (!empty($call->client))--}}
{{--                                                                    @php--}}
{{--                                                                        // Obtener los números de teléfono del cliente y unirlos en una sola línea separados por comas--}}
{{--                                                                        $phoneNumbers = $phones->where('client_id', $call->client->id)->pluck('phone')->implode(', ');--}}
{{--                                                                    @endphp--}}
{{--                                                                    @if (!empty($phoneNumbers))--}}
{{--                                                                        <p class="text-xs text-secondary mb-0">{{ $phoneNumbers }}</p>--}}
{{--                                                                    @else--}}
{{--                                                                        <p class="text-xs text-secondary mb-0">No hay teléfono</p>--}}
{{--                                                                    @endif--}}
{{--                                                                @else--}}
{{--                                                                    <p class="text-xs text-secondary mb-0">No hay teléfono</p>--}}
{{--                                                                @endif--}}
{{--                                                            @endif--}}
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 450px">
                                                    <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($job->job, 70, '...') }}</p>
                                                </td>
{{--                                                @php--}}
{{--                                                    $user = $users->firstWhere('id', $call->user_id2);--}}
{{--                                                @endphp--}}
{{--                                                @if ($user)--}}
{{--                                                    <td>--}}
{{--                                                        <div class="d-flex px-2 py-1">--}}
{{--                                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>--}}
{{--                                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>--}}
{{--                                                            </div>--}}
{{--                                                        </div>--}}
{{--                                                    </td>--}}
{{--                                                @endif--}}
                                                <td><h6 class="mb-0 text-sm">0</h6></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->inittime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($job->endtime)->format('d-m-y H:i') }}</span></td>
                                                <td><span class="text-secondary text-xs font-weight-bold">{{ $job->totalmin }} min</span></td>
                                                <td>
                                                    <a href="{{ route('jobs.edit', ['job' => $job]) }}" type="button" class="btn btn-default btn-sm w-auto">Editar</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('calls.destroy', $job) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-default btn-sm w-auto" onclick="return confirm('Seguro que quieres eliminar el trabajo?')" type="submit">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <li>No tienes trabajos realizados</li>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
