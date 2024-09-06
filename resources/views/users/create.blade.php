<x-app-layout>
    <main>

        @include('layouts.partials.header')

        <div class="container-fluid py-4 d-flex justify-content-center align-items-center">
            <div class="row justify-content-center w-100 form-card-position">
                <div class="col-md-8 col-lg-6">
                    <div class="customcard card my-4">
                        <div class="customcard card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="custom-header-card border-radius-lg pt-4 pb-3">
                                <h6 class="text-white ps-3">Formulario de creación de usuarios</h6>
                            </div>
                        </div>
                        <section>
                            <div class="container py-4">
                                <div class="row">
                                    <div class="col-lg-7 mx-auto d-flex justify-content-center flex-column">
                                        <form role="form" action="{{ url('/users') }}" id="call-form" method="post" autocomplete="off">
                                            {!! csrf_field() !!}

                                            <div class="form-group card-body">
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    @if ($errors->has('name'))
                                                        <input name="name" type="text" placeholder="{{ $errors->first('name') }}" class="form-control is-invalid alert alert-danger" id="name" value="{{ old('name') }}">
                                                    @else
                                                        <label class="form-label" for="name">Nombre de usuario</label>
                                                        <input name="name" type="text" class="form-control" id="name" value="{{ old('name') }}">
                                                    @endif
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    @if ($errors->has('email'))
                                                        <input name="email" type="text" placeholder="{{ $errors->first('email') }}" class="form-control is-invalid alert alert-danger" id="email" value="{{ old('email') }}">
                                                    @else
                                                        <label class="form-label" for="email">E-mail</label>
                                                        <input name="email" type="text" class="form-control" id="email" value="{{ old('email') }}">
                                                    @endif
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    @if ($errors->has('department_id'))
                                                        <select class="form-control is-invalid alert alert-danger" name="department_id" id="department_id">
                                                            <option value="">{{ $errors->first('department_id') }}</option>
                                                            @foreach ($departments as $department)
                                                                <option class="form-control" value="{{ ($department->id) }}">{{ $department->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    @else
                                                        <select class="form-control" name="department_id" id="department_id">
                                                            <option value="">Selecciona un departamento</option>
                                                            @foreach ($departments as $department)
                                                                <option class="form-control" value="{{ ($department->id) }}">{{ $department->title }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                                <div class="form-group input-group mb-4 input-group-static">
                                                    @if ($errors->has('password'))
                                                        <input name="password" type="text" placeholder="{{ $errors->first('password') }}" class="form-control is-invalid alert alert-danger" id="password" value="{{ old('password') }}">
                                                    @else
                                                        <label class="form-label" for="password">Contraseña</label>
                                                        <input name="password" type="text" class="form-control" id="password" value="{{ old('password') }}">
                                                    @endif
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
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
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
</x-app-layout>
