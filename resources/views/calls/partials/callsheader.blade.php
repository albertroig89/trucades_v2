<x-slot name="callsheader">
    <div>
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
            <h2 class="font-semibold text-xl leading-tight mt-4">
                {{ $title }}
            </h2>
            <form class="float-end" method="GET" action="{{ route('calls.index') }}">
                <select class="form-select form-select-lg text-secondary" aria-label=".form-select-lg example" onchange="this.form.submit()" name="user_id" id="user_id">
                    @if ($allcalls == true)
                        <option value="100">Todas las llamadas</option>
                    @else
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
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
        </div>
        <div class="row text-center viewselector">
            <div class="col-4 mx-auto">
                <div class="nav-wrapper position-relative end-0">
                    <form id="view-preference-form" action="{{ route('changeViewPreference') }}" method="POST">
                        @csrf
                        <input type="hidden" name="desktop" id="desktop" value="">
                    </form>

                    <ul class="nav nav-custom nav-pills nav-fill" role="tablist">
                        <li class="nav-item">
                            <a href="#" id="desktop-view" class="nav-link mb-0 px-0 py-1 {{ auth()->user()->desktop ? 'active' : '' }}">
                                Escritorio
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" id="mobile-view" class="nav-link mb-0 px-0 py-1 {{ !auth()->user()->desktop ? 'active' : '' }}">
                                Móvil
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>



    </div>
</x-slot>
