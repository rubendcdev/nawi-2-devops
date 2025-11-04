@extends('layouts.app')

@section('content')
<style>

        html, body {
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)),
                    url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg')
                    no-repeat center center/cover;
        color: #000;
    }

    .document-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 25px;
        color: rgba(0, 0, 0, 0.6);
        margin-bottom: 20px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .status-badge {
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 1rem;
        font-weight: bold;
    }

    .status-pendiente {
        background: #fff3cd;
        color: #856404;
    }

    .status-aprobado {
        background: #d4edda;
        color: #155724;
    }

    .status-rechazado {
        background: #f8d7da;
        color: #721c24;
    }

    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 10px;
        padding: 40px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
    }

    .upload-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .upload-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.2);
    }

    .btn-upload {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        color: white;
        padding: 12px 30px;
        border-radius: 25px;
        font-weight: bold;
        transition: all 0.3s;
    }

    .btn-upload:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(102, 126, 234, 0.3);
        color: white;
    }
</style>

<div class="documents-page">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-white">
                <i class="fas fa-file-upload"></i> Mis Documentos
            </h1>
            <a href="{{ route('taxista.dashboard') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i> Volver al Dashboard
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

        <div class="row">
            <!-- Matrícula -->
            <div class="col-md-6">
                <div class="document-card">
                    <h3 class="mb-3">
                        <i class="fas fa-id-card"></i> Matrícula del Vehículo
                    </h3>

                    @if(auth()->user()->taxista && auth()->user()->taxista->matricula)
                        <div class="mb-3">
                            <strong>Estado:</strong>
                            <span class="status-badge status-{{ auth()->user()->taxista->matricula->estatus->nombre }}">
                                {{ ucfirst(auth()->user()->taxista->matricula->estatus->nombre) }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Subido:</strong> {{ auth()->user()->taxista->matricula->fecha_subida->format('d/m/Y H:i') }}
                        </div>
                        <div class="mb-3">
                            <strong>Archivo:</strong> {{ auth()->user()->taxista->matricula->url }}
                        </div>
                    @else
                        <p class="text-muted mb-3">No has subido tu matrícula aún</p>
                    @endif

                    <form method="POST" action="{{ route('taxista.upload.matricula') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-area" onclick="document.getElementById('matricula_file').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h5>Subir Matrícula</h5>
                            <p class="text-muted">Haz clic aquí o arrastra tu archivo</p>
                            <p class="text-muted small">Formatos permitidos: PDF, JPG, PNG (máx. 5MB)</p>
                        </div>
                        <input type="file" name="archivo" id="matricula_file" class="d-none"
                               accept=".pdf,.jpg,.jpeg,.png" onchange="this.form.submit()">
                    </form>
                </div>
            </div>

            <!-- Licencia -->
            <div class="col-md-6">
                <div class="document-card">
                    <h3 class="mb-3">
                        <i class="fas fa-id-badge"></i> Licencia de Conducir
                    </h3>

                    @if(auth()->user()->taxista && auth()->user()->taxista->licencia)
                        <div class="mb-3">
                            <strong>Estado:</strong>
                            <span class="status-badge status-{{ auth()->user()->taxista->licencia->estatus->nombre }}">
                                {{ ucfirst(auth()->user()->taxista->licencia->estatus->nombre) }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Subido:</strong> {{ auth()->user()->taxista->licencia->fecha_subida->format('d/m/Y H:i') }}
                        </div>
                        <div class="mb-3">
                            <strong>Archivo:</strong> {{ auth()->user()->taxista->licencia->url }}
                        </div>
                    @else
                        <p class="text-muted mb-3">No has subido tu licencia aún</p>
                    @endif

                    <form method="POST" action="{{ route('taxista.upload.licencia') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-area" onclick="document.getElementById('licencia_file').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h5>Subir Licencia</h5>
                            <p class="text-muted">Haz clic aquí o arrastra tu archivo</p>
                            <p class="text-muted small">Formatos permitidos: PDF, JPG, PNG (máx. 5MB)</p>
                        </div>
                        <input type="file" name="archivo" id="licencia_file" class="d-none"
                               accept=".pdf,.jpg,.jpeg,.png" onchange="this.form.submit()">
                    </form>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <div class="document-card">
                    <h3 class="mb-3">
                        <i class="fas fa-info-circle"></i> Información Importante
                    </h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                                <h5>Pendiente</h5>
                                <p class="text-muted">Tu documento está siendo revisado por nuestro equipo</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                                <h5>Aprobado</h5>
                                <p class="text-muted">Tu documento ha sido aprobado y está listo para usar</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <i class="fas fa-times-circle fa-2x text-danger mb-2"></i>
                                <h5>Rechazado</h5>
                                <p class="text-muted">Tu documento fue rechazado, por favor sube uno nuevo</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Drag and drop functionality
document.querySelectorAll('.upload-area').forEach(area => {
    area.addEventListener('dragover', (e) => {
        e.preventDefault();
        area.classList.add('dragover');
    });

    area.addEventListener('dragleave', () => {
        area.classList.remove('dragover');
    });

    area.addEventListener('drop', (e) => {
        e.preventDefault();
        area.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            const input = area.parentElement.querySelector('input[type="file"]');
            input.files = files;
            input.dispatchEvent(new Event('change'));
        }
    });
});
</script>
@endsection
