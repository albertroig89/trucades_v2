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
                    $phoneNumbers = $phones->where('client_id', $client->id)->pluck('phone')->implode(', ');
                @endphp
                <p class="text-sm font-weight-bold text-secondary">{{ $phoneNumbers ?: 'No hay teléfono' }}</p>
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
    <h6 class="text-center text-secondary">No hay clientes registrados</h6>
@endforelse
