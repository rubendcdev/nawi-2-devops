@extends('layouts.app')
<style>
            body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg') no-repeat center center/cover;
            color: #000;
        }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">🔐 Iniciar Sesión</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Contraseña *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p>
                                <a href="{{ route('password.forgot') }}" class="text-decoration-none">
                                    <i class="fas fa-key"></i> ¿Olvidaste tu contraseña?
                                </a>
                            </p>
                            <p>¿No tienes cuenta?
                                <a href="{{ route('register.taxista') }}">Registrarse como Taxista</a>
                            </p>
                            <p class="text-muted">
                                <small>¿Eres pasajero? Descarga nuestra app móvil para registrarte.</small>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
