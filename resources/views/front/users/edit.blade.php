@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center row-home">
            <div class="col col-lg-12">
                <h1 class="col-home">{{ env('APP_NAME') }}</h1>
                @include('layouts.partials._messages')
                {!! Form::open(['route' => 'users.update', 'method' => 'PUT', 'id' => 'form-update']) !!}
                    <div class="form-group">
                        <h5 class="col-home">Editar Usuario</h5>
                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name" class="col-md-12 control-label">Nombre</label>
                            <div class="col-md-12">
                                <input id="name" type="text" class="form-control" name="name" required value="{{ $user->name }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <small id="emailHelp" class="form-text text-muted">Nombres y Apellidos</small>
                        </div>
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-12 control-label">Correo</label>
                            <div class="col-md-12">
                                <input id="email" type="text" class="form-control" name="email" required value="{{ $user->email }}">
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-12 control-label">Contraseña</label>
                            <div class="col-md-12">
                                <input id="password" type="password" class="form-control" name="password" placeholder="Llenar este campo si se quiere cambiar la contraseña">
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <small id="emailHelp" class="form-text text-muted">Llenar este campo si se quiere cambiar la contraseña</small>
                        </div>
                        <div class="form-group">
                            <label for="password-confirm" class="col-md-12 control-label">Confirmar Contraseña</label>
                            <div class="col-md-12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Llenar este campo si se quiere cambiar la contraseña">
                            </div>
                        </div>
                    </div>
                    <div class="col-home">
                        <button type="submit" class="btn btn-success mb-2 btn-lg" id="btn-sub">Editar Usuario</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection
