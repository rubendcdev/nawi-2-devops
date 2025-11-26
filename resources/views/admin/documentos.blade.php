@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/documents.css') }}">
@endpush

@section('content')

<div class="admin-documentos">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white">
                <i class="fas fa-file-alt"></i> Gestión de Documentos
            </h1>
            <div>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-light me-2">
                    <i class="fas fa-arrow-left"></i> Volver al Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            </div>
        </div>

        <!-- Matrículas -->
        <div class="row">
            <div class="col-12">
                <div class="document-card">
                    <h3 class="mb-4">
                        <i class="fas fa-id-card"></i> Matrículas
                    </h3>
                    @forelse($matriculas as $matricula)
                        <div class="document-card">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5>{{ $matricula->taxistas->first()->usuario->nombre }} {{ $matricula->taxistas->first()->usuario->apellido }}</h5>
                                    <p class="mb-1">
                                        <strong>Email:</strong> {{ $matricula->taxistas->first()->usuario->email }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Teléfono:</strong> {{ $matricula->taxistas->first()->usuario->telefono }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Subido:</strong> {{ $matricula->fecha_subida->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <span class="status-badge status-{{ $matricula->estatus->nombre }}">
                                        {{ ucfirst($matricula->estatus->nombre) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="{{ route('admin.ver.documento', ['tipo' => 'matricula', 'id' => $matricula->id]) }}"
                                       class="btn-action btn-view" target="_blank">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.descargar.documento', ['tipo' => 'matricula', 'id' => $matricula->id]) }}"
                                       class="btn-action btn-download">
                                        <i class="fas fa-download"></i> Descargar
                                    </a>
                                    @if($matricula->id_estatus == '1')
                                        <form method="POST" action="{{ route('admin.aprobar.documento') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="tipo" value="matricula">
                                            <input type="hidden" name="id" value="{{ $matricula->id }}">
                                            <button type="submit" class="btn-action btn-approve">
                                                <i class="fas fa-check"></i> Aprobar
                                            </button>
                                        </form>
                                        <button type="button" class="btn-action btn-reject"
                                                onclick="rechazarDocumento('matricula', '{{ $matricula->id }}')">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No hay matrículas registradas</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Licencias -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="document-card">
                    <h3 class="mb-4">
                        <i class="fas fa-id-badge"></i> Licencias
                    </h3>
                    @forelse($licencias as $licencia)
                        <div class="document-card">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5>{{ $licencia->taxistas->first()->usuario->nombre }} {{ $licencia->taxistas->first()->usuario->apellido }}</h5>
                                    <p class="mb-1">
                                        <strong>Email:</strong> {{ $licencia->taxistas->first()->usuario->email }}
                                    </p>
                                    <p class="mb-1">
                                        <strong>Teléfono:</strong> {{ $licencia->taxistas->first()->usuario->telefono }}
                                    </p>
                                    <p class="mb-0">
                                        <strong>Subido:</strong> {{ $licencia->fecha_subida->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <span class="status-badge status-{{ $licencia->estatus->nombre }}">
                                        {{ ucfirst($licencia->estatus->nombre) }}
                                    </span>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="{{ route('admin.ver.documento', ['tipo' => 'licencia', 'id' => $licencia->id]) }}"
                                       class="btn-action btn-view" target="_blank">
                                        <i class="fas fa-eye"></i> Ver
                                    </a>
                                    <a href="{{ route('admin.descargar.documento', ['tipo' => 'licencia', 'id' => $licencia->id]) }}"
                                       class="btn-action btn-download">
                                        <i class="fas fa-download"></i> Descargar
                                    </a>
                                    @if($licencia->id_estatus == '1')
                                        <form method="POST" action="{{ route('admin.aprobar.documento') }}" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="tipo" value="licencia">
                                            <input type="hidden" name="id" value="{{ $licencia->id }}">
                                            <button type="submit" class="btn-action btn-approve">
                                                <i class="fas fa-check"></i> Aprobar
                                            </button>
                                        </form>
                                        <button type="button" class="btn-action btn-reject"
                                                onclick="rechazarDocumento('licencia', '{{ $licencia->id }}')">
                                            <i class="fas fa-times"></i> Rechazar
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No hay licencias registradas</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para rechazar documento -->
<div class="modal fade" id="rechazarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rechazar Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('admin.rechazar.documento') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="tipo" id="rechazar_tipo">
                    <input type="hidden" name="id" id="rechazar_id">
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo del rechazo:</label>
                        <textarea class="form-control" name="motivo" id="motivo" rows="3" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-danger">Rechazar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function rechazarDocumento(tipo, id) {
    document.getElementById('rechazar_tipo').value = tipo;
    document.getElementById('rechazar_id').value = id;
    document.getElementById('motivo').value = '';
    new bootstrap.Modal(document.getElementById('rechazarModal')).show();
}
</script>
@endsection
