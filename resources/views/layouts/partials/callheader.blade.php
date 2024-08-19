<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mt-4">
        {{ $title }}
        <form class="float-end" method="GET" action="{{ url('/') }}">
            <select class="form-select form-select-lg" aria-label=".form-select-lg example" onchange="this.form.submit()" name="user_id" id="user_id">
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
