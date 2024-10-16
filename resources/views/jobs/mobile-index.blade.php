<x-app-layout>
    <main>

        @include('layouts.partials.tablesheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="customcardm card my-4">
                        <div class="customcardm card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Trabajos realizados</h6>
                                <a href="{{ route('jobs.create') }}" type="button" class="float-end btn btn-ncall w-auto">Nuevo Trabajo</a>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex flex-wrap justify-content-start p-4 pt-0">
                                @forelse($jobs as $job)
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                                        <div class="callcard h-100 border-radius-xl shadow-sm" onclick="window.location='{{ route('jobs.show', ['job' => $job]) }}';">
                                            <div class="card-header callheadercard d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if($job->user->avatar)
                                                        <img src="{{ $job->user->avatar }}" alt="user-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @else
                                                        <img src="{{ asset('images/AR_fblanc.png') }}" alt="default-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @endif
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0">{{ $job->user->name }}</h6>
                                                        <p class="text-xs text-secondary">{{ $job->user->email }}</p>
                                                    </div>
                                                </div>
                                                <span class="badge badge-sm bg-dark">
                                                    {{ $job->totalmin }} min
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <h6>{{ $job->clientname }}</h6>
                                                <p class="text-sm font-weight-bold text-secondary">
                                                    {{ \Illuminate\Support\Str::limit($job->job, 250, '...') }}
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <a href="{{ route('jobs.edit', ['job' => $job]) }}" class="btn btn-default btn-sm w-auto">Editar</a>
                                                <form action="{{ route('jobs.destroy', $job) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-default btn-sm w-auto" onclick="return confirm('¿Seguro que quieres eliminar el trabajo?')" type="submit">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <li>No tienes trabajos realizados</li>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
