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
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="row d-flex flex-wrap justify-content-start p-4 pt-0">
                                @forelse($histjobs as $histjob)
                                    <div class="col-lg-3 col-md-4 col-sm-12 mb-4">
                                        <div class="callcard h-100 border-radius-xl shadow-sm" onclick="window.location='{{ route('jobs.show', ['job' => $histjob]) }}';">
                                            <div class="card-header callheadercard d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center">
                                                    @if($histjob->avatar)
                                                        <img src="{{ asset($histjob->avatar) }}" alt="user-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @else
                                                        <img src="{{ asset('images/AR_fblanc.png') }}" alt="default-avatar" class="avatar avatar-sm me-3 border-radius-lg">
                                                    @endif
                                                    <div class="d-flex flex-column">
                                                        <h6 class="mb-0">{{ $histjob->username }}</h6>
                                                        <p class="text-xs text-secondary">{{ $histjob->email }}</p>
                                                    </div>
                                                </div>
                                                <span class="badge badge-sm bg-dark">
                                                    {{ $histjob->totalmin }} min
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <h6>{{ $histjob->clientname }}</h6>
                                                <p class="text-sm font-weight-bold text-secondary">
                                                    {{ \Illuminate\Support\Str::limit($histjob->job, 250, '...') }}
                                                </p>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between">
                                                <form action="{{ route('histjobs.destroy', $histjob) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-default btn-sm w-auto" onclick="return confirm('¿Seguro que quieres eliminar el trabajo?')" type="submit">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <h6 class="text-center text-secondary">No tienes trabajos realizados</h6>
                                @endforelse
                            </div>
                        </div>
                        <div class="row text-center py-2">
                            <div class="col-4 mx-auto">
                                {{ $histjobs->links('components.bootstrap-5-pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>
