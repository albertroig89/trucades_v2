<x-appforms-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de creación de llamadas</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ url('/calls') }}" id="call-form" method="post" autocomplete="off">
                                            {!! csrf_field() !!}

                                            <div class="card-body">
                                                <div class="input-group mb-4 input-group-static">
                                                    <label for="selector-clients">Cliente:</label>
                                                    <select class='form-control select2' name='client_id' id='client_id'>
                                                        <option></option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ ($client->id) }}">{{ $client->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="input-group mb-4 input-group-static">
                                                    <input class="form-control" name="clientname" id="clientname">
                                                </div>
                                                <div class="input-group mb-4 input-group-static">
                                                    <label class="form-label">Teléfono</label>
                                                    <input class="form-control" name="clientphone" id="clientphone">
                                                </div>
                                                <div class="input-group mb-4 input-group-static">
                                                    <label for="user_id2">Atendido por:</label>
                                                    <select class="form-control" name="user_id2" id="user_id2">
                                                        <option value="{{ auth()->id() }}">{{ auth()->user()->name }}</option>
                                                        @foreach ($users as $user)
                                                            @if (auth()->id() != $user->id))
                                                            <option class="form-control" value="{{ ($user->id) }}">{{ $user->name }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Example invalid custom select feedback</div>
                                                </div>
                                                <div class="input-group mb-4 input-group-static">
                                                    <label for="callinf">Información de la llamada</label>
                                                    @if ($errors->has('callinf'))
                                                        <textarea name="callinf" class="form-control is-invalid" id="callinf" rows="2">{{ old('callinf') }}</textarea>
                                                    @elseif ($errors->any())
                                                        <textarea name="callinf" class="form-control is-valid" id="callinf" rows="2">{{ old('callinf') }}</textarea>
                                                        <div class="valid-feedback">
                                                            Correcto!
                                                        </div>
                                                    @else
                                                        <textarea name="callinf" class="form-control" id="callinf">{{ old('callinf') }}</textarea>
                                                    @endif
                                                </div>

                                                <div class="input-group mb-4 input-group-static">
                                                    <label for="user_id">Empleado:</label>
                                                    <select class="form-control" name="user_id" id="user_id">
                                                        <option value="">Selecciona un empleado</option>
                                                        @foreach ($users as $user)
                                                            <option class="form-control" value="{{ ($user->id) }}">{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <div class="invalid-feedback">Porfavor selecciona un empleado</div>
                                                </div>
                                                <div class="input-group mb-4 input-group-static">
                                                    <label for="stat_id">Estado:</label>
                                                    <select class='form-control' name='stat_id' id='stat_id'>
                                                        <option value="2">Normal</option>
                                                        @foreach ($stats as $stat)
                                                            @if ($stat->id != $nStat)
                                                                <option value="{{ ($stat->id) }}">{{ $stat->title }}</option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default">Crear</button>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('dashboard') }}" type="button" class="btn btn-default">Volver</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        @if ($errors->any())
                                            <br>
                                            <div class="col-md-12">
                                                <div class="alert alert-danger">
                                                    <h5>Porfavor corrige los errores mencionados arriba {{ $errors }}</h5>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-appforms-layout>
