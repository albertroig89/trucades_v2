<!-- Navbar -->
<div class="container position-sticky z-index-sticky top-0">
    <div class="row">
        <div class="col-12">
            <nav class="navbar custom-navbar navbar-expand-lg border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <!-- Logo -->
                    <a title="Desarrollado por Albert Roig" data-placement="bottom" href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/ARl_fnegre.png') }}" alt="Logo" class="navbar-logo">
                    </a>

                    <!-- Botón de menú para móviles -->
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon mt-2">
                            <span class="navbar-toggler-bar bar1"></span>
                            <span class="navbar-toggler-bar bar2"></span>
                            <span class="navbar-toggler-bar bar3"></span>
                        </span>
                    </button>

                    <!-- Menú de navegación -->
                    <div class="collapse navbar-collapse justify-content-center" id="navigation">
                        <ul class="navbar-nav mx-auto d-flex justify-content-center w-100">
                            <!-- Llamadas -->
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="custom-nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons me-2 text-md">call</i>
                                    Llamadas
                                    <img src="{{ asset('assets/img/down-arrow-white.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="custom-nav-dropdown dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('calls.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">add_ic_call</i>
                                            Nueva llamada
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('dashboard')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver llamadas
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('calls.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">add_ic_call</i>
                                            Nueva llamada
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('dashboard')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver llamadas
                                        </x-dropdown-link>
                                    </div>
                                </div>
                            </li>

                            <!-- Trabajos -->
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="custom-nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons me-2 text-md">work</i>
                                    Trabajos
                                    <img src="{{ asset('assets/img/down-arrow-white.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="custom-nav-dropdown dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('jobs.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">add</i>
                                            Nuevo trabajo
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.histjobs')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">work_history</i>
                                            Ver histórico de trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.histjobs2')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility_off</i>
                                            Ver histórico oculto
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.count')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">timer</i>
                                            Contador de trabajos
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('jobs.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">add</i>
                                            Nuevo trabajo
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.histjobs')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">work_history</i>
                                            Ver histórico de trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.histjobs2')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility_off</i>
                                            Ver histórico oculto
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('jobs.count')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">timer</i>
                                            Contador de trabajos
                                        </x-dropdown-link>
                                    </div>
                                </div>
                            </li>

                            <!-- Usuarios -->
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="custom-nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons me-2 text-md">person</i>
                                    Usuarios
                                    <img src="{{ asset('assets/img/down-arrow-white.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="custom-nav-dropdown dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('users.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">person_add</i>
                                            Nuevo usuario
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('users.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver usuarios
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('users.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">person_add</i>
                                            Nuevo usuario
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('users.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver usuarios
                                        </x-dropdown-link>
                                    </div>
                                </div>
                            </li>

                            <!-- Clientes -->
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="custom-nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons me-2 text-md">contacts</i>
                                    Clientes
                                    <img src="{{ asset('assets/img/down-arrow-white.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="custom-nav-dropdown dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('clients.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">person_add</i>
                                            Nuevo cliente
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('clients.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver clientes
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('clients.import')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">publish</i>
                                            Importar clientes
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('clients.create')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">person_add</i>
                                            Nuevo cliente
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('clients.index')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">visibility</i>
                                            Ver clientes
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('clients.import')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            <i class="material-icons me-2 text-md">publish</i>
                                            Importar clientes
                                        </x-dropdown-link>
                                    </div>
                                </div>
                            </li>

                                <!-- Settings Dropdown -->
                            <li class="nav-item dropdown dropdown-hover navbar-avatar mx-2">
                                <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuUser" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                        <img src="{{ auth()->user()->avatar }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                    @else
                                        <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                    @endif
                                </a>
                                <div class="custom-nav-dropdown dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuUser">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('profile.edit')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            {{ __('Perfil') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                             onclick="event.preventDefault();
                                                                            this.closest('form').submit();" class="custom-dropdown-item dropdown-item border-radius-md">
                                                {{ __('Salir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('profile.edit')" class="custom-dropdown-item dropdown-item border-radius-md">
                                            {{ __('Perfil') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <x-dropdown-link :href="route('logout')"
                                                             onclick="event.preventDefault();
                                                                            this.closest('form').submit();" class="custom-dropdown-item dropdown-item border-radius-md">
                                                {{ __('Salir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <!-- End Navbar -->
        </div>
    </div>
</div>

