<x-app-layout>
    <main>

        @include('layouts.partials.callheader')

        <div class="container-fluid py-4">
            <div class="row">
                <div class=" col-12">
                    <div class="callcard card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Llamadas pendientes</h6>
                                <a href="" type="button" class="float-end btn btn-ncall w-auto">Nueva llamada</a>
                            </div>
                        </div>
                        <div class=" card-body px-0 pb-2">
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
    </main>
</x-app-layout>
