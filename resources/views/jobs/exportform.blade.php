<x-app-layout>
    <main>
        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de exportación de trabajos para facturación</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ route('jobs.export') }}" id="export-job" autocomplete="off">
                                            @csrf
                                            <div class="form-group card-body">
                                                <!-- Selección de Cliente -->
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="client_id">Cliente:</label>
                                                    <select class='form-control select2 @error('client_id') is-invalid @enderror' name='client_id' id='client_id'>
                                                        <option></option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ ($client->id) }}" {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                                                {{ $client->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('client_id')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('client_id') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <!-- Cliente personalizado -->
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label class="form-label" for="clientname">Cliente personalizado</label>
                                                    <input name="clientname" type="text" class="form-control @error('clientname') is-invalid @enderror" id="clientname" value="{{ old('clientname') }}">
                                                    @error('clientname')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('clientname') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <!-- Empleado -->
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="user_id">Empleado</label>
                                                    <select class="form-control @error('user_id') is-invalid @enderror" name="user_id" id="user_id">
                                                        <option value="">Selecciona un empleado</option>
                                                        @foreach ($users as $user)
                                                            <option class="form-control" value="{{ ($user->id) }}"
                                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('user_id')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('user_id') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>

                                                <!-- Fechas -->
                                                <div class="form-group input-group mb-4 input-group-static @error('initdate') has-error @enderror">
                                                    <label for="initdate">Fecha de inicio para la exportación *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" class="form-control datepicker-export @error('initdate') is-invalid @enderror" name="initdate" value="{{ old('initdate') }}" id="initdate" />
                                                        @error('initdate')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('initdate') }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static @error('enddate') has-error @enderror">
                                                    <label for="enddate">Fecha final para la exportación *</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" class="form-control datepicker-export @error('enddate') is-invalid @enderror" name="enddate" value="{{ old('enddate') }}" id="enddate" />
                                                        @error('enddate')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('enddate') }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <!-- Checkbox para seleccionar el tipo de exportación -->
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="export_from_history" name="export_from_history">
                                                    <label class="form-check-label" for="flexCheckDefault">Exportar trabajos del histórico</label>
                                                </div>
                                                <!-- Botones -->
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default btn-sm w-auto">Preparar exportación</button>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('jobs.index') }}" type="button" class="btn btn-default btn-sm w-auto">Volver</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
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

