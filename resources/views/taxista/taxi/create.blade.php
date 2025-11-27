@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/forms.css') }}">
@endpush

@section('content')

<div class="taxi-form">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="form-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">
                            <i class="fas fa-car"></i> Registrar Mi Taxi
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

                    <form method="POST" action="{{ route('taxi.store') }}">
                        @csrf

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
                                           value="{{ old('marca') }}"
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
                                           value="{{ old('modelo') }}"
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
                                           value="{{ old('numero_taxi') }}"
                                           placeholder="Ej: 0110, 1234, 0001"
                                           maxlength="10"
                                           pattern="[0-9]+"
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
                                <li>Los datos del taxi son necesarios para completar tu perfil de taxista</li>
                                <li>Puedes editar esta información más tarde desde tu panel</li>
                                <li>Asegúrate de que los datos sean correctos</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('taxista.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Registrar Taxi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Validación para marca - solo letras, espacios, guiones y puntos
    const marcaInput = document.getElementById('marca');
    if (marcaInput) {
        marcaInput.addEventListener('input', function(e) {
            // Remover caracteres no permitidos
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]/g, '');
        });

        marcaInput.addEventListener('keypress', function(e) {
            // Prevenir caracteres especiales peligrosos
            const char = String.fromCharCode(e.which);
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]$/.test(char)) {
                e.preventDefault();
            }
        });
    }

    // Validación para modelo - solo letras, espacios, guiones y puntos
    const modeloInput = document.getElementById('modelo');
    if (modeloInput) {
        modeloInput.addEventListener('input', function(e) {
            // Remover caracteres no permitidos
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]/g, '');
        });

        modeloInput.addEventListener('keypress', function(e) {
            // Prevenir caracteres especiales peligrosos
            const char = String.fromCharCode(e.which);
            if (!/^[a-zA-ZáéíóúÁÉÍÓÚñÑüÜ\s\-\.]$/.test(char)) {
                e.preventDefault();
            }
        });
    }

    // Validación para numero_taxi - solo números
    const numeroTaxiInput = document.getElementById('numero_taxi');
    if (numeroTaxiInput) {
        numeroTaxiInput.addEventListener('input', function(e) {
            // Remover todo lo que no sea número
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        numeroTaxiInput.addEventListener('keypress', function(e) {
            // Solo permitir números
            const char = String.fromCharCode(e.which);
            if (!/^[0-9]$/.test(char)) {
                e.preventDefault();
            }
        });
    }
});
</script>
@endsection
