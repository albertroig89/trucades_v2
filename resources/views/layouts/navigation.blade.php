<!-- Navbar -->
<div class="container position-sticky z-index-sticky top-0"><div class="row"><div class="col-12" style="background-color: grey">
            <nav class="navbar navbar-expand-lg  blur border-radius-xl top-0 z-index-fixed shadow position-absolute my-3 py-2 start-0 end-0 mx-4">
                <div class="container-fluid">
                    <a  title="Diseñado por Albert Roig" data-placement="bottom" href="{{ route('dashboard') }}">
                        <img src="{{ asset('images/AR_fblanc.png') }}" alt="Logo" class="navbar-logo">
                    </a>
                    <button class="navbar-toggler shadow-none ms-2" type="button" data-bs-toggle="collapse" data-bs-target="#navigation" aria-controls="navigation" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon mt-2">
                        <span class="navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                      </span>
                    </button>
                    <div class="collapse navbar-collapse pt-3 pb-2 py-lg-0" id="navigation">
                        <ul class="navbar-nav navbar-nav-hover ms-lg-12 ps-lg-5 w-100">
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons opacity-6 me-2 text-md">work</i>
                                    Trabajos
                                    <img src="{{ asset('assets/img/down-arrow-dark.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">add</i>
                                            Nuevo trabajo
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            Ver trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">work_history</i>
                                            Ver historico de trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility_off</i>
                                            Ver historico oculto
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">timer</i>
                                            Contador de trabajos
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">add</i>
                                            Nuevo trabajo
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            Ver trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">work_history</i>
                                            Ver historico de trabajos
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility_off</i>
                                            Ver historico oculto
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">timer</i>
                                            Contador de trabajos
                                        </x-dropdown-link>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons opacity-6 me-2 text-md">person</i>
                                    Usuarios
                                    <img src="{{ asset('assets/img/down-arrow-dark.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">person_add</i>
                                            Nuevo usuario
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('users.index')" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            {{ __('Ver usuarios') }}
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">person_add</i>
                                            Nuevo usuario
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('users.index')" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            {{ __('Ver usuarios') }}
                                        </x-dropdown-link>
                                    </div>

                                </div>
                            </li>

                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <x-dropdown-link class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuPages" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="material-icons opacity-6 me-2 text-md">contacts</i>
                                    Clientes
                                    <img src="{{ asset('assets/img/down-arrow-dark.svg') }}" alt="down-arrow" class="arrow ms-auto">
                                </x-dropdown-link>
                                <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuPages">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">person_add</i>
                                            Nuevo cliente
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            Ver clientes
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">publish</i>
                                            Importar clientes
                                        </x-dropdown-link>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">add</i>
                                            Nuevo cliente
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">visibility</i>
                                            Ver clientes
                                        </x-dropdown-link>
                                        <x-dropdown-link href="javascript:;" class="dropdown-item border-radius-md">
                                            <i class="material-icons opacity-6 me-2 text-md">publish</i>
                                            Importar clientes
                                        </x-dropdown-link>
                                    </div>

                                </div>
                            </li>
                            <li class="nav-item ms-lg-auto my-auto ms-3 ms-lg-0">

                                <!-- Settings Dropdown -->
                            <li class="nav-item dropdown dropdown-hover mx-2">
                                <a class="nav-link ps-2 d-flex cursor-pointer align-items-center" id="dropdownMenuUser" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(Auth::user()->avatar)
                                    <img src="{{ Auth::user()->avatar }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">

                                    @else
                                    <img src="{{ asset('images/AR_fblanc.png') }}" alt="down-arrow" class="avatar avatar-sm me-3 border-radius-lg">
                                    @endif
                                </a>
                                <div class="dropdown-menu dropdown-menu-animation ms-n3 dropdown-md p-3 border-radius-lg mt-0 mt-lg-3" aria-labelledby="dropdownMenuUser">
                                    <div class="d-none d-lg-block">
                                        <x-dropdown-link :href="route('profile.edit')" class="dropdown-item border-radius-md">
                                            {{ __('Perfil') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                             onclick="event.preventDefault();
                                                                            this.closest('form').submit();" class="dropdown-item border-radius-md">
                                                {{ __('Salir') }}
                                            </x-dropdown-link>
                                        </form>
                                    </div>

                                    <div class="d-lg-none">
                                        <x-dropdown-link :href="route('profile.edit')" class="dropdown-item border-radius-md">
                                            {{ __('Perfil') }}
                                        </x-dropdown-link>

                                        <form method="POST" action="{{ route('logout') }}" class="dropdown-item border-radius-md">
                                            @csrf

                                            <x-dropdown-link :href="route('logout')"
                                                             onclick="event.preventDefault();
                                                                            this.closest('form').submit();">
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
        </div></div></div>
