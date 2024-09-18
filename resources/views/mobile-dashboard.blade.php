<x-app-layout>
    <main>

        @include('calls.partials.callsheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcardm card my-4">
                        <div class="customcardm card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Llamadas pendientes</h6>
                                <a href="{{ route('calls.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nueva llamada</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex flex-wrap justify-content-start p-4 pt-0">
                                @forelse($calls as $call)
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                                        <div class="callcard h-100 border-radius-xl shadow-sm" onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';">
                                            <div class="card-header callheadercard d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if($call->user->avatar)
                                                        <img src="{{ $call->user->avatar }}" alt="user-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @else
                                                        <img src="{{ asset('images/AR_fblanc.png') }}" alt="default-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @endif
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0">{{ $call->user->name }}</h6>
                                                        <p class="text-xs text-secondary">{{ $call->user->email }}</p>
                                                    </div>
                                                </div>
                                                <span class="badge badge-sm bg-{{ $call->stat->id == $uStat ? 'danger' : ($call->stat->id == $nStat ? 'success' : 'warning') }}">
                                                    {{ $call->stat->title }}
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <h6 class="text-sm">{{ $call->clientname }}</h6>
                                                <p class="text-xs text-secondary">
                                                    @if (!empty($call->clientphone))
                                                        {{ $call->clientphone }}
                                                    @else
                                                        @if (!empty($call->client))
                                                            @php
                                                                $phoneNumbers = $phones->where('client_id', $call->client->id)->pluck('phone')->implode(', ');
                                                            @endphp
                                                            {{ $phoneNumbers ?: 'No hay teléfono' }}
                                                        @else
                                                            No hay teléfono
                                                        @endif
                                                    @endif
                                                </p>
                                                <p class="text-sm font-weight-bold text-secondary">
                                                    {{ \Illuminate\Support\Str::limit($call->callinf, 250, '...') }}
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('calls.edit', ['call' => $call]) }}" class="btn btn-sm btn-default">Editar</a>
                                                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button class="btn btn-sm btn-default" onclick="return confirm('¿Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <li>No tienes llamadas pendientes</li>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

