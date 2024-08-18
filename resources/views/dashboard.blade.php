<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ $title }}

            <div class="row text-center py-3 mt-3">
                <div class="col-4 mx-auto">
                    <div class="nav-wrapper position-relative end-0">
                        <ul class="nav nav-pills nav-fill p-1" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1 active" data-bs-toggle="tab" href="#profile-tabs-simple" role="tab" aria-controls="profile" aria-selected="true">
                                    Classica
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link mb-0 px-0 py-1" data-bs-toggle="tab" href="#dashboard-tabs-simple" role="tab" aria-controls="dashboard" aria-selected="false">
                                    Mejorada
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <form class="float-right" method="GET" action="{{ url('/') }}">
                <select class="form-control" onchange="this.form.submit()" name="user_id" id="user_id">
                    @if ($allcalls == true)
                        <option class="" value="100">Totes les trucades</option>
                    @else
                        <option class="" value="{{ $usuari->id }}">{{ $usuari->name }}</option>
                        <option class="" value="100">Totes les trucades</option>
                    @endif
                    @foreach ($users as $user)
                        @if (auth()->id() != $user->id)
                            <option class="" value="{{ $user->id }}">{{ $user->name }}</option>
                        @elseif ($allcalls == true)
                            <option class="" value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach

                </select>
            </form>
        </h2>
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
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user1">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">John Michael</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">john@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Manager</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Organization</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-success">Online</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">23/04/18</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user2">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">Alexa Liras</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">alexa@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Programator</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Developer</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">11/01/19</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user3">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">Laurent Perrier</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">laurent@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Executive</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Projects</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-success">Online</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">19/09/17</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-3.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user4">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">Michael Levi</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">michael@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Programator</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Developer</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-success">Online</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">24/12/08</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-2.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user5">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">Richard Gran</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">richard@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Manager</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Executive</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">04/10/21</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                                <tr>--}}
{{--                                    <td>--}}
{{--                                        <div class="d-flex px-2 py-1">--}}
{{--                                            <div>--}}
{{--                                                <img src="../assets/img/team-4.jpg" class="avatar avatar-sm me-3 border-radius-lg" alt="user6">--}}
{{--                                            </div>--}}
{{--                                            <div class="d-flex flex-column justify-content-center">--}}
{{--                                                <h6 class="mb-0 text-sm">Miriam Eric</h6>--}}
{{--                                                <p class="text-xs text-secondary mb-0">miriam@creative-tim.com</p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
{{--                                    <td>--}}
{{--                                        <p class="text-xs font-weight-bold mb-0">Programator</p>--}}
{{--                                        <p class="text-xs text-secondary mb-0">Developer</p>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center text-sm">--}}
{{--                                        <span class="badge badge-sm bg-gradient-secondary">Offline</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle text-center">--}}
{{--                                        <span class="text-secondary text-xs font-weight-bold">14/09/20</span>--}}
{{--                                    </td>--}}
{{--                                    <td class="align-middle">--}}
{{--                                        <a href="javascript:;" class="text-secondary font-weight-bold text-xs" data-toggle="tooltip" data-original-title="Edit user">--}}
{{--                                            Edit--}}
{{--                                        </a>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
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

{{--    <div class="py-12">--}}
{{--        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">--}}
{{--            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">--}}
{{--                <div class="p-6 text-gray-900 dark:text-gray-100">--}}
{{--                    {{ __("No hay llamadas") }}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
</x-app-layout>
