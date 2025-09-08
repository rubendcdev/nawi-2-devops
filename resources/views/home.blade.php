@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-10">
            <div class="card dashboard-card shadow-lg">
                <div class="card-header dashboard-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">🚖 Bienvenido a OcoTaxi</h4>
                    <span class="badge bg-light text-dark">Panel de Usuario</span>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="mb-4 text-muted">Has iniciado sesión correctamente. Aquí puedes consultar tu información y documentos.</p>

                    <!-- Botón para ir al Perfil -->
                    <div class="text-center mb-4">
                        <a href="{{ route('perfil.show') }}" class="btn btn-info btn-lg">
                            👤 Ver Perfil
                        </a>
                    </div>

                    <div class="row">
                        <!-- Documento de Licencia -->
                        <div class="col-md-6 mb-3">
                            <div class="card document-card h-100 text-center">
                                <div class="card-body">
                                    <i class="fas fa-id-card fa-3x text-primary mb-3"></i>
                                    <h5>Licencia</h5>
                                    <p>Consulta tu licencia de conducir digital.</p>
                                    <a href="#" class="btn btn-outline-primary btn-sm">Ver Licencia</a>
                                </div>
                            </div>
                        </div>

                        <!-- Documento de Circulación -->
                        <div class="col-md-6 mb-3">
                            <div class="card document-card h-100 text-center">
                                <div class="card-body">
                                    <i class="fas fa-car fa-3x text-success mb-3"></i>
                                    <h5>Circulación</h5>
                                    <p>Revisa tu documento de circulación vigente.</p>
                                    <a href="#" class="btn btn-outline-success btn-sm">Ver Circulación</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Extra -->
                    <div class="mt-4 text-center">
                        <a href="#" class="btn btn-custom btn-custom-primary me-2">🚕 Solicitar Servicio</a>
                        <a href="#" class="btn btn-custom btn-custom-secondary">📑 Ver Historial</a>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
