@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/perfil.css') }}">
@endpush

@section('content')

<div class="foto-perfil">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="foto-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="mb-0">
                            <i class="fas fa-camera"></i> Foto de Perfil
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

                    <!-- Foto actual -->
                    <div class="text-center mb-4">
                        @if(auth()->user()->fotos->count() > 0)
                            <img src="{{ asset('uploads/fotos/' . auth()->user()->fotos->first()->url) }}"
                                 alt="Foto de perfil"
                                 class="foto-preview"
                                 id="foto-preview">
                        @else
                            <img src="{{ asset('images/default-avatar.svg') }}"
                                 alt="Sin foto"
                                 class="foto-preview"
                                 id="foto-preview">
                        @endif
                    </div>

                    <!-- Formulario de subida -->
                    <form method="POST" action="{{ route('foto.upload.perfil') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="upload-area" onclick="document.getElementById('foto_file').click()">
                            <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                            <h5>Subir Foto de Perfil</h5>
                            <p class="text-muted">Haz clic aquí o arrastra tu imagen</p>
                            <p class="text-muted small">Formatos permitidos: JPG, PNG (máx. 2MB)</p>
                        </div>
                        <input type="file" name="foto" id="foto_file" class="d-none"
                               accept=".jpg,.jpeg,.png" onchange="previewFoto(this)">
                    </form>

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        @if(auth()->user()->fotos->count() > 0)
                            <form method="POST" action="{{ route('foto.eliminar.perfil') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger"
                                        onclick="return confirm('¿Estás seguro de que quieres eliminar tu foto de perfil?')">
                                    <i class="fas fa-trash"></i> Eliminar Foto
                                </button>
                            </form>
                        @endif
                    </div>

                    <!-- Información -->
                    <div class="alert alert-info mt-4">
                        <i class="fas fa-info-circle"></i>
                        <strong>Información importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Tu foto de perfil será visible en tu perfil público</li>
                            <li>Formatos recomendados: JPG, PNG</li>
                            <li>Tamaño máximo: 2MB</li>
                            <li>Resolución recomendada: 400x400 píxeles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('foto-preview').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
        // Enviar formulario automáticamente
        input.form.submit();
    }
}

// Drag and drop functionality
document.querySelector('.upload-area').addEventListener('dragover', (e) => {
    e.preventDefault();
    e.currentTarget.classList.add('dragover');
});

document.querySelector('.upload-area').addEventListener('dragleave', (e) => {
    e.currentTarget.classList.remove('dragover');
});

document.querySelector('.upload-area').addEventListener('drop', (e) => {
    e.preventDefault();
    e.currentTarget.classList.remove('dragover');
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        const input = document.getElementById('foto_file');
        input.files = files;
        previewFoto(input);
    }
});
</script>
@endsection
