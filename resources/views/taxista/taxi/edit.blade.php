@extends('layouts.app')

@section('content')
<style>
            body {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg') no-repeat center center/cover;
            color: #000;
        }


    .form-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 30px;
        color: #000;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e9ecef;
        padding: 12px 15px;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: bold;
    }

    .btn-danger {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: bold;
    }
</style>

<div class="taxi-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="form-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">
                            <i class="fas fa-edit"></i> Editar Mi Taxi
                        </h2>
                        <a href="{{ route('taxista.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Volver
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('taxi.update', $taxi->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="marca" class="form-label">
                                        <i class="fas fa-tag"></i> Marca del Vehículo
                                    </label>
                                    <input type="text"
                                           class="form-control @error('marca') is-invalid @enderror"
                                           id="marca"
                                           name="marca"
                                           value="{{ old('marca', $taxi->marca) }}"
                                           placeholder="Ej: Toyota, Nissan, Chevrolet..."
                                           required>
                                    @error('marca')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="modelo" class="form-label">
                                        <i class="fas fa-car-side"></i> Modelo del Vehículo
                                    </label>
                                    <input type="text"
                                           class="form-control @error('modelo') is-invalid @enderror"
                                           id="modelo"
                                           name="modelo"
                                           value="{{ old('modelo', $taxi->modelo) }}"
                                           placeholder="Ej: Corolla, Sentra, Aveo..."
                                           required>
                                    @error('modelo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="numero_taxi" class="form-label">
                                        <i class="fas fa-hashtag"></i> Número de Taxi
                                    </label>
                                    <input type="text"
                                           class="form-control @error('numero_taxi') is-invalid @enderror"
                                           id="numero_taxi"
                                           name="numero_taxi"
                                           value="{{ old('numero_taxi', $taxi->numero_taxi) }}"
                                           placeholder="Ej: 0110, 1234, 0001"
                                           maxlength="10"
                                           required>
                                    @error('numero_taxi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        <i class="fas fa-info-circle"></i> Número único que identifica tu taxi
                                    </small>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Información importante:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Los cambios se aplicarán inmediatamente</li>
                                <li>Asegúrate de que los datos sean correctos</li>
                                <li>Esta información será visible en tu perfil público</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('taxista.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar Taxi
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
