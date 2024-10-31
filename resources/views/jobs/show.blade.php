<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Detalles del trabajo realizado</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <!-- Aquí comenzamos a mostrar los datos sin opción de edición -->
                                        <div class="form-group card-body">

                                            <!-- Empleado -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="user_id">Empleado:</label>
                                                <p class="form-control-plaintext">{{ $job->user->name ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Cliente -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="created_at">Fecha de creación:</label>
                                                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($job->created_at)->format('d-m-y H:i') ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Cliente -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="client_id">Cliente:</label>
                                                <p class="form-control-plaintext">{{ $job->client->name ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Cliente personalizado -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="clientname">Cliente personalizado:</label>
                                                <p class="form-control-plaintext">{{ $job->clientname ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Inicio del trabajo -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="inittime">Inicio del trabajo:</label>
                                                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($job->inittime)->format('d-m-Y H:i') }}</p>
                                            </div>

                                            <!-- Final del trabajo -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="endtime">Final del trabajo:</label>
                                                <p class="form-control-plaintext">{{ \Carbon\Carbon::parse($job->endtime)->format('d-m-Y H:i') }}</p>
                                            </div>

                                            <!-- Tiempo empleado -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="totalmin">Tiempo empleado:</label>
                                                <p class="form-control-plaintext">{{ $job->totalmin }} min</p>
                                            </div>

                                            <!-- Descripción del trabajo -->
                                            <div class="form-group input-group mb-4 input-group-static">
                                                <label for="job">Descripción del trabajo:</label>
                                                <p class="form-control-plaintext">{{ $job->job ?? 'N/A' }}</p>
                                            </div>

                                            <!-- Botón de regreso -->
                                            <div class="d-flex justify-content-end pt-3">
                                                <a href="{{ route('jobs.index') }}" class="btn btn-default btn-sm">Volver</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-app-layout>

