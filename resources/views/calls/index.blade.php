<x-app-layout>
    <main>

        @include('calls.partials.callsheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Llamadas pendientes</h6>
                                <a href="{{ route('calls.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nueva llamada</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                @if($calls->count())
                                    <table class="table custom-table align-items-center mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Empleado</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Estado</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nota</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Atendido por</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Intentos</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($calls as $call)


                                            <tr onclick="window.location='{{ route('jobs.jobfromcallindex', ['call' => $call]) }}';" class="custom-table-row">
                                                <th>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            @if($call->user->avatar)
                                                                <img src="{{ $call->user->avatar }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @else
                                                                <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $call->user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $call->user->email }}</p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                    <span class="badge badge-sm bg-{{ $call->stat->id == $uStat ? 'danger' : ($call->stat->id == $nStat ? 'success' : 'info') }}">
                                                        {{ $call->stat->title }}
                                                    </span>
                                                    </div>
                                                </td>
                                                <td scope="row">
                                                    <span class="text-secondary text-xs font-weight-bold">{{ \Carbon\Carbon::parse($call->created_at)->format('d-m-y H:i') }}</span>
                                                </td>
                                                <td>
                                                    <div class=" d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $call->clientname }}</h6>
                                                            @if (!empty($call->clientphone))
                                                                <p class="text-xs text-secondary mb-0">{{ $call->clientphone }}</p>
                                                            @else
                                                                @if (!empty($call->client))
                                                                    @php
                                                                        // Obtener los números de teléfono del cliente y unirlos en una sola línea separados por comas
                                                                        $phoneNumbers = $phones->where('client_id', $call->client->id)->pluck('phone')->implode(', ');
                                                                    @endphp
                                                                    @if (!empty($phoneNumbers))
                                                                        <p class="text-xs text-secondary mb-0">{{ $phoneNumbers }}</p>
                                                                    @else
                                                                        <p class="text-xs text-secondary mb-0">No hay teléfono</p>
                                                                    @endif
                                                                @else
                                                                    <p class="text-xs text-secondary mb-0">No hay teléfono</p>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 450px">
                                                    <p class="text-xs font-weight-bold mb-0">{{ \Illuminate\Support\Str::limit($call->callinf, 70, '...') }}</p>
                                                </td>
                                                @php
                                                    $user = $users->firstWhere('id', $call->user_id2);
                                                @endphp
                                                @if ($user)
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td><h6 class="mb-0 text-sm">0</h6></td>
                                                <td>
                                                    <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default btn-sm w-auto">Editar</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('calls.destroy', $call) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-default btn-sm w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h6 class="text-center text-secondary">No tienes llamadas pendientes</h6>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
