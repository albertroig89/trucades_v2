@if ($call->stat->id === $nStat)
    @if ($call->user->name === "Global")
        <tr class="normalStateGlobal">
            <th scope="row">{{ \Carbon\Carbon::parse($call->created_at)->format('d-m-y H:i') }}</th>
            <td>{{ $call->user->name }}</td>
            <td>{{ $call->clientname }}</td>
            <td class="nota">{{ $call->callinf }}</td>
            @if (!empty($call->clientphone))
                <td>{{ $call->clientphone }}</td>
            @else
                <td>
                    @if (!empty($call->client))
                        @foreach ($phones as $phone)
                            @if ($phone->client_id === $call->client->id)
                                {{ $phone->phone }}
                            @endif
                        @endforeach
                    @else
                        No hi ha telèfon
                    @endif
                </td>
            @endif
            @foreach ($users as $user)
                @if ($user->id === $call->user_id2)
                    <td>{{ $user->name }}</td>
                @endif
            @endforeach
            <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>
            <td><a class="btn btn-link" href="{{ route('calls.edit', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">edit</i></a></td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-link" onclick="return confirm('Segur que vols eliminar la trucada?')" type="submit"><i class="material-icons opacity-6 me-2 text-md">delete</i></button>
                </form>
            </td>
        </tr>
    @elseif ($call->user->department->title === "Administracio")
        <tr class="normalStateAdm">
            <th scope="row">{{ \Carbon\Carbon::parse($call->created_at)->format('d-m-y H:i') }}</th>
            <td>{{ $call->user->name }}</td>
            <td>{{ $call->clientname }}</td>
            <td class="nota">{{ $call->callinf }}</td>
            @if (!empty($call->clientphone))
                <td>{{ $call->clientphone }}</td>
            @else
                <td>
                    @if (!empty($call->client))
                        @foreach ($phones as $phone)

                            @if ($phone->client_id === $call->client->id)
                                {{ $phone->phone }}
                            @endif
                        @endforeach
                    @else
                        No hi ha telèfon
                    @endif
                </td>
            @endif
            @foreach ($users as $user)
                @if ($user->id === $call->user_id2)
                    <td>{{ $user->name }}</td>
                @endif
            @endforeach
            <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>
            <td><a class="btn btn-link" href="{{ route('calls.edit', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">edit</i></a></td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-link" onclick="return confirm('Segur que vols eliminar la trucada?')" type="submit"><i class="material-icons opacity-6 me-2 text-md">delete</i></button>
                </form>
            </td>
        </tr>
    @else
{{--        Line of table for normal calls--}}
        <tr>
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
                    <img title="Normal" src="{{ asset('images/normal.png') }}" class="avatar-sm">
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
                                    @foreach ($phones as $phone)
                                        @dd $phones
                                        @if ($phone->client_id === $call->client->id)
                                            <p class="text-xs text-secondary mb-0">{{ $phone->phone }}</p>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-xs text-secondary mb-0">No hay teléfono</p>
                                @endif
                        @endif
                    </div>
                </div>
            </td>
            <td>
                <p class="text-xs font-weight-bold mb-0">{{ $call->callinf }}</p>
            </td>
            @foreach ($users as $user)
                @if ($user->id === $call->user_id2)
                    <td>
                        <div class="d-flex px-2 py-1">
                            <div class="d-flex flex-column justify-content-center">
                                <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                @endif
            @endforeach
            <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>
            <td><a class="btn btn-link" href="{{ route('calls.edit', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">edit</i></a></td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-link" onclick="return confirm('Segur que vols eliminar la trucada?')" type="submit"><i class="material-icons opacity-6 me-2 text-md">delete</i></button>
                </form>
            </td>
        </tr>
    @endif
@elseif ($call->stat->id === $uStat)
    <tr class="urgentState">
        <th scope="row">{{ \Carbon\Carbon::parse($call->created_at)->format('d-m-y H:i') }}</th>
        <td>{{ $call->user->name }}</td>
        <td>{{ $call->clientname }}</td>
        <td class="nota">{{ $call->callinf }}</td>
        @if (!empty($call->clientphone))
            <td>{{ $call->clientphone }}</td>
        @else
            <td>
                @if (!empty($call->client))
                    @foreach ($phones as $phone)

                        @if ($phone->client_id === $call->client->id)
                            {{ $phone->phone }}
                        @endif
                    @endforeach
                @else
                    No hi ha telèfon
                @endif
            </td>
        @endif
        @foreach ($users as $user)
            @if ($user->id === $call->user_id2)
                <td>{{ $user->name }}</td>
            @endif
        @endforeach
        <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>
        <td><a class="btn btn-link" href="{{ route('calls.edit', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">edit</i></a></td>

        <td>

            <form action="{{ route('calls.destroy', $call) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-link" onclick="return confirm('Segur que vols eliminar la trucada?')" type="submit"><i class="material-icons opacity-6 me-2 text-md">delete</i></button>
            </form>
        </td>
    </tr>
@elseif ($call->stat->id === $pStat)
    <tr class="pendingState">
        <th scope="row">{{ \Carbon\Carbon::parse($call->created_at)->format('d-m-y H:i') }}</th>
        <td>{{ $call->user->name }}</td>
        <td>{{ $call->clientname }}</td>
        <td class="nota">{{ $call->callinf }}</td>
        @if (!empty($call->clientphone))
            <td>{{ $call->clientphone }}</td>
        @else
            <td>
                @if (!empty($call->client))
                    @foreach ($phones as $phone)

                        @if ($phone->client_id === $call->client->id)
                            {{ $phone->phone }}
                        @endif
                    @endforeach
                @else
                    No hi ha telèfon
                @endif
            </td>
        @endif
        @foreach ($users as $user)
            @if ($user->id === $call->user_id2)
                <td>{{ $user->name }}</td>
            @endif
        @endforeach

        <td>
            <a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}">
                <i class="material-icons opacity-6 me-2 text-md">add</i>
            </a>
        </td>
        <td>
            <a class="btn btn-link" href="{{ route('calls.edit', ['call' => $call]) }}">
                <i class="material-icons opacity-6 me-2 text-md">edit</i>
            </a>
        </td>
        <td>
            <form action="{{ route('calls.destroy', $call) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-link" onclick="return confirm('Seguro que quieres borrar la llamada?')" type="submit">
                    <i class="material-icons opacity-6 me-2 text-md">delete</i>
                </button>
            </form>
        </td>
    </tr>
@endif
