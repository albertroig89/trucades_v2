<x-app-layout>
    <main>

        @include('clients.partials.clientsheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcardm card my-4">
                        <div class="customcardm card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Clientes registrados</h6>
                                <a href="{{ route('clients.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nuevo cliente</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex flex-wrap justify-content-start p-4 pt-0">
                                @forelse($clients as $client)
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                                        <div class="callcard h-100 border-radius-xl shadow-sm">
                                            <div class="card-header callheadercard d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0">{{ $loop->iteration }}-{{ $client->name }}</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <p class="text-sm font-weight-bold text-secondary">Id de cliente: {{ $client->id }}</p>
                                                @php
                                                    // Obtener los números de teléfono del cliente y unirlos en una sola línea separados por comas
                                                    $phoneNumbers = $phones->where('client_id', $client->id)->pluck('phone')->implode(', ');
                                                @endphp
                                                @if (!empty($phoneNumbers))
                                                    <p class="text-sm font-weight-bold text-secondary">Teléfonos: {{ $phoneNumbers }}</p>
                                                @else
                                                    <p class="text-sm font-weight-bold text-secondary">No hay teléfono</p>
                                                @endif
                                                <p class="text-sm font-weight-bold text-secondary">Email: {{ $client->email }}</p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('clients.edit', ['client' => $client]) }}" class="btn btn-default btn-sm w-auto">Editar</a>
                                                <form action="{{ route('clients.destroy', $client) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-default btn-sm w-auto" onclick="return confirm('¿Seguro que quieres eliminar el cliente?')" type="submit">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <li>No hay clientes</li>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
