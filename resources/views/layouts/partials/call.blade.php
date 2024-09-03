@if ($call->stat->id === $nStat)
    @if ($call->user->name === "Global")
        {{--Line of table for global calls--}}
        <tr onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';" class="custom-table-row">
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
                    <img title="Global" src="{{ asset('images/global.png') }}" class="avatar-sm">
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
{{--            <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>--}}
            <td><h6 class="mb-0 text-sm">0</h6></td>
{{--            <a href="{{ route('calls.jobfromcall', ['call' => $call]) }}" type="button" class="float-end btn btn-ncall w-auto">Crear</a>--}}
{{--            <td><a class="btn btn-link" href="{{ route('calls.jobfromcall', ['call' => $call]) }}"><i class="material-icons opacity-6 me-2 text-md">add</i></a></td>--}}
            <td>
                <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default w-auto">Editar</a>
            </td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-default w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @elseif ($call->user->department->title === "Administracio")
        {{--Line of table for administrative calls--}}
        <tr onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';" class="custom-table-row">
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
                    <img title="Normal" src="{{ asset('images/admin.png') }}" class="avatar-sm">
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
                <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default w-auto">Editar</a>
            </td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-default w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @else
    {{--Line of table for normal calls--}}
        <tr onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';" class="custom-table-row">
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
                <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default w-auto">Editar</a>
            </td>
            <td>
                <form action="{{ route('calls.destroy', $call) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button class="btn btn-default w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @endif
@elseif ($call->stat->id === $uStat)
    {{--Line of table for urgent calls--}}
    <tr onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';" class="custom-table-row">
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
                <img title="Urgente" src="{{ asset('images/urgent.png') }}" class="avatar-sm">
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
        <td><h6 class="mb-0 text-sm ">0</h6></td>
        <td>
            <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default w-auto">Editar</a>
        </td>
        <td>
            <form action="{{ route('calls.destroy', $call) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-default w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
@elseif ($call->stat->id === $pStat)
    {{--Line of table for pending calls--}}
    <tr onclick="window.location='{{ route('calls.jobfromcall', ['call' => $call]) }}';" class="custom-table-row">
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
                <img title="Pendiente" src="{{ asset('images/pending.png') }}" class="avatar-sm">
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
            <a href="{{ route('calls.edit', ['call' => $call]) }}" type="button" class="btn btn-default w-auto">Editar</a>
        </td>
        <td>
            <form action="{{ route('calls.destroy', $call) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <button class="btn btn-default w-auto" onclick="return confirm('Seguro que quieres eliminar la llamada?')" type="submit">Eliminar</button>
            </form>
        </td>
    </tr>
@endif
