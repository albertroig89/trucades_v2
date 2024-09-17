<x-app-layout>
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
                                            <div class="form-group card-body">
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
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label class="form-label" for="clientname">Cliente personalizado</label>
                                                    <input name="clientname" type="text" class="form-control @error('clientname') is-invalid @enderror" id="clientname" value="{{ old('clientname') }}">
                                                    @error('clientname')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('clientname') }}</small>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label class="form-label" for="clientphone">Teléfono</label>
                                                    <input name="clientphone" type="text" class="form-control @error('clientphone') is-invalid @enderror" id="clientphone" value="{{ old('clientphone') }}">
                                                    @error('clientphone')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('clientphone') }}</small>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="callinf">Información de la llamada</label>
                                                    <textarea name="callinf" type="text" class="form-control @error('callinf') is-invalid @enderror" id="callinf">{{ old('callinf') }}</textarea>
                                                    @error('callinf')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('callinf') }}</small>
                                                        </div>
                                                    @enderror
                                                </div>
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
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="stat_id">Estado de la llamada:</label>
                                                    <select class='form-control' name='stat_id' id='stat_id'>
                                                        <option value="2">Normal</option>
                                                        @foreach ($stats as $stat)
                                                            @if ($stat->id != $nStat)
                                                                <option value="{{ ($stat->id) }}"
                                                                    {{ old('stat_id') == $stat->id ? 'selected' : '' }}>
                                                                    {{ $stat->title }}
                                                                </option>
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
