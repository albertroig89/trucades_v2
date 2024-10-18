<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3 d-flex align-items-center">
                                <img src="{{ asset($user->avatar) }}" alt="down-arrow" class="avatar avatar-sm me-3 ms-3 border-radius-lg">
                                <h6 class="text-white m-0">{{ $user->name }}</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ route('users.update', $user->id) }}" id="call-form" method="post" autocomplete="off" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group card-body">
                                                <div class="form-group input-group mb-4 input-group-static">

                                                    <!-- Input text for user name -->
                                                    <label class="form-label" for="name">Nombre de usuario</label>
                                                    <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $user->name) }}">
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
                                                    <input name="email" type="text" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $user->email) }}">
                                                    <!-- Error message for email select -->
                                                    @error('email')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('email') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="department_id">Departamento</label>
                                                    <!-- Input for department_id non editable -->
                                                    <input type="text" class="form-control" value="{{ $user->department->title }}" readonly>
                                                    <input type="hidden" name="department_id" value="{{ $user->department->id }}">
                                                    <!-- Error message for department_id select -->
                                                    @error('department_id')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('department_id') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    <label for="avatar">Avatar</label>
                                                    <!-- Input file for avatar -->
                                                    <input name="avatar" type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" value="{{ old('avatar') }}">
                                                    <!-- Error message for avatar input -->
                                                    @error('avatar')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('avatar') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static" style="position: relative;">
                                                    <label class="form-label" for="password">Contraseña</label>
                                                    <!-- Input password -->
                                                    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" style="padding-right: 40px;">
                                                    <!-- Visibility icon for password input -->
                                                    <span class="material-icons" id="toggleIcon">
                                                        visibility
                                                    </span>
                                                    <!-- Error message for password input -->
                                                    @error('password')
                                                    <div class="invalid-feedback">
                                                        <small>{{ $errors->first('password') }}</small>
                                                    </div>
                                                    @enderror
                                                </div>
                                                {{--Div for password confirmation--}}
                                                <div class="form-group input-group mb-4 input-group-static" style="position: relative;">
                                                    <label class="form-label" for="password_confirmation">Confirmar contraseña</label>
                                                    <input name="password_confirmation" type="password" class="form-control" id="password_confirmation" value="{{ old('password_confirmation') }}" style="padding-right: 40px;">
                                                    <span class="material-icons" id="toggleConfirmIcon">
                                                        visibility
                                                    </span>
                                                </div>
                                                <!-- Div container for buttons -->
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default btn-sm w-auto">Editar</button>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('calls.index') }}" type="button" class="btn btn-default btn-sm w-auto">Volver</a>
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
