<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de edición de clientes</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ route('clients.update', $client->id) }}" id="call-form" method="post" autocomplete="off">

                                            @method('PUT')
                                            @csrf

                                            <div class="form-group card-body">
                                                <div class="form-group input-group mb-4 input-group-static">

                                                    <!-- Input text for user name -->
                                                    <label class="form-label" for="name">Nombre del cliente</label>
                                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $client->name) }}">
                                                    <!-- Error message for name input-->
                                                    @error('name')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('name') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label class="form-label" for="email">E-mail</label>
                                                    <!-- Input email for email -->
                                                    <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $client->email) }}">
                                                    <!-- Error message for email select -->
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('email') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                    @foreach ($phones as $phone)
                                                        @if($loop->first)
                                                            <div class="form-group input-group mb-4 input-group-static" style="position: relative;">
                                                                <label class="form-label" for="phone">Teléfono:</label>
                                                                <!-- Input text for primary phone -->
                                                                <input name="phone" type="text" class="form-control phone-input @error('phone') is-invalid @enderror" id="phone" value="{{ old('phone', $phone->phone) }}">
                                                                <div class="button">
                                                                    <button type="button" id="add_phone" class="btn btn-default btn-sm mt-4">Añadir teléfono</button>
                                                                </div>
                                                                <!-- Error message for phone select -->
                                                                @error('phone')
                                                                <div class="invalid-feedback">
                                                                    <small>{{ $errors->first('phone') }}</small>
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        @else
                                                            <div class="form-group input-group mb-4 input-group-static mt-4" style="position: relative;">
                                                                <label class="form-label" for="phones_{{ $loop->index - 1 }}">Teléfono {{ $loop->iteration }}:</label>
                                                                <input id="phones_{{ $loop->index - 1 }}" name="phones[]" type="text" class="form-control phone-input phone-input-additional @error('phones.' . ($loop->index - 1)) is-invalid @enderror" value="{{ old('phones.' . ($loop->index - 1), $phone->phone) }}">
                                                                <div class="button">
                                                                    <button type="button" class="btn btn-default delete_phone btn-sm mt-2">Borrar teléfono</button>
                                                                </div>
                                                                <!-- Error message for additional phones -->
                                                                @error('phones.' . ($loop->index - 1))
                                                                <div class="invalid-feedback">
                                                                    <small>{{ $errors->first('phones.' . ($loop->index - 1)) }}</small>
                                                                </div>
                                                                @enderror
                                                            </div>
                                                        @endif
                                                    @endforeach

                                                <!-- Div container for buttons -->
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default btn-sm w-auto">Editar</button>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('clients.index') }}" type="button" class="btn btn-default btn-sm w-auto">Volver</a>
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
