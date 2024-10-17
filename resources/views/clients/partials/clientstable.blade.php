@if($clients->count())
    <table class="table custom-table align-items-center mb-0">
        <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id de cliente</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Correo electrónico</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
        </tr>
        </thead>
        <tbody>
        @foreach ($clients as $client)
            <tr class="custom-table-row">
                <th>
                    <div class="d-flex px-2 py-1">
                        <div>
                            <h6 class="mb-0 text-sm">{{ $loop->iteration }}-</h6>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $client->name }}</h6>
                            @php
                                $phoneNumbers = $phones->where('client_id', $client->id)->pluck('phone')->implode(', ');
                            @endphp
                            @if (!empty($phoneNumbers))
                                <p class="text-xs text-secondary mb-0">{{ $phoneNumbers }}</p>
                            @else
                                <p class="text-xs text-secondary mb-0">No hay teléfono</p>
                            @endif
                        </div>
                    </div>
                </th>
                <td>
                    <h6 class="text-secondary text-xs font-weight-bold">{{ $client->id }}</h6>
                </td>
                <td>
                    <div class="d-flex flex-column justify-content-center">
                        <h6 class="mb-0 text-sm">{{ $client->email }}</h6>
                    </div>
                </td>
                <td>
                    <a href="{{ route('clients.edit', ['client' => $client]) }}" type="button" class="btn btn-default btn-sm w-auto">Editar</a>
                </td>
                <td>
                    <form action="{{ route('clients.destroy', $client) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-default btn-sm w-auto" onclick="return confirm('Seguro que quieres eliminar el cliente?')" type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@else
    <h6 class="text-center text-secondary">No hay clientes registrados</h6>
@endif
