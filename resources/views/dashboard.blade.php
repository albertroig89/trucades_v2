<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}
            <form class="float-end" method="GET" action="{{ url('/') }}">
                <select class="form-control-lg" onchange="this.form.submit()" name="user_id" id="user_id">
                    @if ($allcalls == true)
                        <option value="100">Todas las llamadas</option>
                    @else
                        <option value="{{ $usuari->id }}">{{ $usuari->name }}</option>
                        <option value="100">Todas las llamadas</option>
                    @endif
                    @foreach ($users as $user)
                        @if (auth()->id() != $user->id)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @elseif ($allcalls == true)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach

                </select>
            </form>
        </h2>
        <div class="row text-center py-3 mt-3">
            <div class="col-4 mx-auto">
                <div class="nav-wrapper position-relative end-0">
                    <ul class="nav nav-pills nav-fill" role="tablist">
                        <li class="nav-item" style="width: 15px; height: auto;">
                            <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-simple" role="tab" aria-controls="profile" aria-selected="true">
                                Escritorio
                            </a>
                        </li>
                        <li class="nav-item" style="width: 15px; height: auto;">
                            <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard" aria-selected="false">
                                Móvil
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                            <h6 class="text-white text-capitalize ps-3">Llamadas pendientes</h6>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            @if($calls->count())
                            <table class="table align-items-center mb-0">
                                <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fecha</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Empleado</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Cliente</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nota</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Teléfono</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Atendido por</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($calls as $call)
                                    @include('layouts.partials.call')
                                @endforeach
                                </tbody>
                            </table>
                            @else
                                <li>No tienes llamadas pendientes</li>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
