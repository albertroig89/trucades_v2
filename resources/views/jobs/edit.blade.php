<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de edición de trabajos realizados</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ route('jobs.update', $job->id) }}" id="call-form" method="post" autocomplete="off">
                                            @method('PUT')
                                            @csrf
                                            <div class="form-group card-body">
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="client_id">Cliente:</label>
                                                    @if(empty($job->client))
                                                        <select class='form-control select2 @error('client_id') is-invalid @enderror' name='client_id' id='client_id'>
                                                            <option></option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ ($client->id) }}">
                                                                    {{ $client->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <select class='form-control select2 @error('client_id') is-invalid @enderror' name='client_id' id='client_id'>
                                                            <option></option>
                                                            @foreach ($clients as $client)
                                                                <option value="{{ ($client->id) }}" {{ old('client_id', $job->client->id) == $client->id ? 'selected' : '' }}>
                                                                    {{ $client->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                    @error('client_id')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('client_id') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label class="form-label" for="clientname">Cliente personalizado</label>
                                                    <input name="clientname" type="text" class="form-control @error('clientname') is-invalid @enderror" id="clientname" value="{{ old('clientname', $job->clientname) }}">
                                                    @error('clientname')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('clientname') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>


                                                <div class="form-group input-group mb-4 input-group-static @error('inittime') has-error @enderror">
                                                    <label for="inittime">Inicio del trabajo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" class="form-control datepicker @error('inittime') is-invalid @enderror" name="inittime" value="{{ old('inittime', \Carbon\Carbon::parse($job->inittime)->format('d-m-Y H:i'))  }}" id="inittime" />
                                                        @error('inittime')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('inittime') }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static @error('endtime') has-error @enderror">
                                                    <label for="endtime">Final del trabajo</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                                        <input type="text" class="form-control datepicker @error('endtime') is-invalid @enderror" name="endtime" value="{{ old('endtime', \Carbon\Carbon::parse($job->endtime)->format('d-m-Y H:i'))  }}" id="endtime" />
                                                        @error('endtime')
                                                        <div class="invalid-feedback">
                                                            <small>{{ $errors->first('endtime') }}</small>
                                                        </div>
                                                        @enderror
                                                    </div>
                                                </div>


{{--                                                <div class="form-group input-group mb-4 input-group-static">--}}
{{--                                                    <label for="inittime">Inicio del trabajo</label>--}}
{{--                                                    <input type="text" class="form-control @error('inittime') is-invalid @enderror" name="inittime" value="{{ old('inittime', \Carbon\Carbon::parse($job->inittime)->format('d-m-Y H:i')) }}" id="inittime"/>--}}
{{--                                                    @error('inittime')--}}
{{--                                                    <div class="invalid-feedback">--}}
{{--                                                        <small>{{ $errors->first('inittime') }}</small>--}}
{{--                                                    </div>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
{{--                                                <div class="form-group input-group mb-4 input-group-static">--}}
{{--                                                    <label for="endtime">Final del trabajo</label>--}}
{{--                                                    <input type="text" class="form-control @error('endtime') is-invalid @enderror" name="endtime" value="{{ old('endtime', \Carbon\Carbon::parse($job->endtime)->format('d-m-Y H:i')) }}" id="endtime"/>--}}
{{--                                                    @error('endtime')--}}
{{--                                                    <div class="invalid-feedback">--}}
{{--                                                        <small>{{ $errors->first('endtime') }}</small>--}}
{{--                                                    </div>--}}
{{--                                                    @enderror--}}
{{--                                                </div>--}}
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="job">Descripción del trabajo</label>
                                                    <textarea name="job" type="text" class="form-control @error('job') is-invalid @enderror" id="job">{{ old('job' , $job->job) }}</textarea>
                                                    @error('job')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('job') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default btn-sm w-auto">Editar</button>
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
