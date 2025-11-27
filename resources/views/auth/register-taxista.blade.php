@extends('layouts.app')
<link rel="stylesheet" href="{{ asset('css/common.css') }}">
<style>
    body {
        font-family: 'Montserrat', sans-serif;
    }

    .container {
        min-height: calc(100vh - 200px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .card {
        background: rgba(255, 255, 255, 0.05) !important;
        backdrop-filter: blur(12px);
        border: 2px solid rgba(255, 193, 7, 0.3);
        box-shadow: 0 4px 20px rgba(255, 193, 7, 0.3);
        border-radius: 15px;
        color: #fff;
        overflow: hidden;
        width: 100%;
        max-width: 700px;
    }

    .card-header {
        background: rgba(255, 193, 7, 0.1);
        border-bottom: 1px solid rgba(255, 193, 7, 0.3);
        padding: 25px;
    }

    .card-header h3 {
        color: #ffc107;
        text-shadow: 0 0 10px rgba(255, 193, 7, 0.5);
        margin: 0;
        font-size: 1.8rem;
    }

    .card-body {
        padding: 35px;
    }

    .form-label {
        color: #fff;
        font-weight: 600;
        margin-bottom: 10px;
        font-size: 1.1rem;
    }

    .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: #fff;
        border-radius: 8px;
        padding: 14px 18px;
        font-size: 1rem;
    }

    .form-control:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #ffc107;
        box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
        color: #fff;
    }

    .form-control::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .btn-warning {
        background: linear-gradient(45deg, #ffc107, #ff9800);
        border: none;
        color: #000;
        font-weight: bold;
        border-radius: 8px;
        padding: 14px 20px;
        font-size: 1.1rem;
        transition: all 0.3s;
    }

    .btn-warning:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(255, 193, 7, 0.4);
        background: linear-gradient(45deg, #ff9800, #ffc107);
    }

    .alert {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 8px;
        color: #fff;
    }

    .alert-danger {
        background: rgba(220, 53, 69, 0.2);
        border-color: rgba(220, 53, 69, 0.5);
    }

    .alert-info {
        background: rgba(23, 162, 184, 0.2);
        border-color: rgba(23, 162, 184, 0.5);
        font-size: 1rem;
        padding: 15px;
    }

    .alert-success {
        background: rgba(40, 167, 69, 0.2);
        border-color: rgba(40, 167, 69, 0.5);
    }

    a {
        color: #ffc107;
        text-decoration: none;
        transition: all 0.3s;
        font-weight: 600;
    }

    a:hover {
        color: #ff9800;
        text-shadow: 0 0 8px rgba(255, 193, 7, 0.8);
    }

    .text-muted {
        color: rgba(255, 255, 255, 0.9) !important;
        font-size: 1rem !important;
    }

    .text-center p {
        font-size: 1.1rem;
        color: #fff;
        margin-bottom: 12px;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .text-center p small {
        font-size: 1rem !important;
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .text-center a {
        font-size: 1.1rem;
        font-weight: 600;
        color: #ffc107 !important;
        text-shadow: 0 0 8px rgba(255, 193, 7, 0.8);
    }
</style>
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">🚕 Registro de Taxista</h3>
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

                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.taxista') }}">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input type="text" class="form-control @error('nombre') is-invalid @enderror"
                                           id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                                    @error('nombre')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="apellido" class="form-label">Apellido *</label>
                                    <input type="text" class="form-control @error('apellido') is-invalid @enderror"
                                           id="apellido" name="apellido" value="{{ old('apellido') }}" required>
                                    @error('apellido')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="telefono" class="form-label">Teléfono *</label>
                                    <input type="tel" class="form-control @error('telefono') is-invalid @enderror"
                                           id="telefono" name="telefono" value="{{ old('telefono') }}" required>
                                    @error('telefono')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label">Email *</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password" class="form-label">Contraseña *</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                           id="password" name="password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                           name="password_confirmation" required>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Nota:</strong> Después del registro podrás subir tus documentos (matrícula y licencia) desde tu panel de taxista.
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-warning btn-lg">
                                <i class="fas fa-taxi"></i> Registrarse como Taxista
                            </button>
                        </div>

                        <div class="text-center mt-3">
                            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Iniciar Sesión</a></p>
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
