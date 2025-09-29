@extends('layouts.app')

<style>
        html, body {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                    url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg')
                    no-repeat center center/cover;
        color: #000;
    }
</style>
@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">🚕 Panel de Taxista</h3>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-id-card fa-3x text-warning mb-3"></i>
                                    <h5>Matrícula</h5>
                                    @if($taxista && $taxista->matricula)
                                        <p class="text-success">
                                            <strong>{{ ucfirst($taxista->matricula->estatus->nombre) }}</strong>
                                        </p>
                                    @else
                                        <p class="text-muted">No subida</p>
                                    @endif
                                    <a href="{{ route('taxista.documents') }}" class="btn btn-warning">
                                        <i class="fas fa-upload"></i> Gestionar Documentos
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <i class="fas fa-id-badge fa-3x text-warning mb-3"></i>
                                    <h5>Licencia</h5>
                                    @if($taxista && $taxista->licencia)
                                        <p class="text-success">
                                            <strong>{{ ucfirst($taxista->licencia->estatus->nombre) }}</strong>
                                        </p>
                                    @else
                                        <p class="text-muted">No subida</p>
                                    @endif
                                    <a href="{{ route('taxista.documents') }}" class="btn btn-warning">
                                        <i class="fas fa-upload"></i> Gestionar Documentos
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Gestión de Documentos</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i>
                            <strong>Importante:</strong> Debes subir tu matrícula y licencia para poder trabajar como taxista.
                            <div class="mt-2">
                                <a href="{{ route('taxista.documents') }}" class="btn btn-primary">
                                    <i class="fas fa-file-upload"></i> Gestionar Documentos
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Gestión de Taxi</h5>
                        <div class="alert alert-warning">
                            <i class="fas fa-car"></i>
                            <strong>Taxi:</strong> Registra la información de tu vehículo para completar tu perfil.
                            <div class="mt-2">
                    @if($taxista && $taxista->taxis->count() > 0)
                        <a href="{{ route('taxi.edit', $taxista->taxis->first()->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Editar Taxi
                        </a>
                    @else
                        <a href="{{ route('taxi.create') }}" class="btn btn-success">
                            <i class="fas fa-plus"></i> Registrar Taxi
                        </a>
                    @endif
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Foto de Perfil</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-camera"></i>
                            <strong>Foto:</strong> Sube una foto de perfil para que los pasajeros te reconozcan.
                            <div class="mt-2">
                                <a href="{{ route('perfil.foto') }}" class="btn btn-primary">
                                    <i class="fas fa-camera"></i> Gestionar Foto
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h5>Información del Taxista</h5>
                        <div class="alert alert-info">
                            <i class="fas fa-user"></i>
                            <strong>Nombre:</strong> {{ auth()->user()->nombre }} {{ auth()->user()->apellido }}<br>
                            <strong>Email:</strong> {{ auth()->user()->email }}<br>
                            <strong>Teléfono:</strong> {{ auth()->user()->telefono }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para subir matrícula -->
<div class="modal fade" id="matriculaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Matrícula</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="matriculaForm">
                    <div class="form-group mb-3">
                        <label for="matricula-url" class="form-label">URL de la imagen *</label>
                        <input type="url" class="form-control" id="matricula-url" name="url" required
                               placeholder="https://example.com/mi-matricula.jpg">
                        <small class="form-text text-muted">Sube tu imagen a un servicio como Imgur y pega la URL aquí</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="uploadMatricula()">Subir Matrícula</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para subir licencia -->
<div class="modal fade" id="licenciaModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Subir Licencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="licenciaForm">
                    <div class="form-group mb-3">
                        <label for="licencia-url" class="form-label">URL de la imagen *</label>
                        <input type="url" class="form-control" id="licencia-url" name="url" required
                               placeholder="https://example.com/mi-licencia.jpg">
                        <small class="form-text text-muted">Sube tu imagen a un servicio como Imgur y pega la URL aquí</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="uploadLicencia()">Subir Licencia</button>
            </div>
        </div>
    </div>
</div>

@endsection
