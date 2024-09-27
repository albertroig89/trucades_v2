<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de edición de usuarios</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ url("/users/{$user->id}") }}" id="call-form" method="post" autocomplete="off" enctype="multipart/form-data">
                                            @method('PUT')
                                            @csrf
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
                                                    <!-- Select for department_id -->
                                                    <select class="form-control" name="department_id" id="department_id">
                                                        @foreach($departments as $department)
                                                            <option value="{{ $department->id }}" {{ old('department_id', $user->department->id) == $department->id ? 'selected' : '' }}>
                                                                {{ $department->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
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
                                                <!-- Div container for buttons -->
                                                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap pt-3 pb-2 mb-3+" >
                                                    <div>
                                                        <button type="submit" class="btn btn-default">Crear</button>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('users.index') }}" type="button" class="btn btn-default">Volver</a>
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
