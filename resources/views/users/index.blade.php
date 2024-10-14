<x-app-layout>
    <main>

        @include('layouts.partials.tablesheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Usuarios registrados</h6>
                                <a href="{{ route('users.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nuevo usuario</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                @if($users->count())
                                    <table class="table custom-table align-items-center mb-0">
                                        <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Usuario</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Id de usuario</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Departamento</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Editar usuario</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Eliminar usuario</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($users as $user)
                                            <tr class="custom-table-row">
                                                <th>
                                                    <div class="d-flex px-2 py-1">
                                                        <div>
                                                            @if($user->avatar)
                                                                <img src="{{ $user->avatar }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @else
                                                                <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                                            @endif
                                                        </div>
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $user->name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ $user->email }}</p>
                                                        </div>
                                                    </div>
                                                </th>
                                                <td>
                                                    <h6 class="text-secondary text-xs font-weight-bold">{{ $user->id }}</h6>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column justify-content-center">
                                                        <h6 class="mb-0 text-sm">{{ $user->department->title }}</h6>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('users.edit', ['user' => $user]) }}" type="button" class="btn btn-default btn-sm w-auto">Editar</a>
                                                </td>
                                                <td>
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-default btn-sm w-auto" onclick="return confirm('Seguro que quieres eliminar el usuario?')" type="submit">Eliminar</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <li>No hay usuarios</li>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
