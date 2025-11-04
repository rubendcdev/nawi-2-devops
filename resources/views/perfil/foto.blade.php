@extends('layouts.app')

@section('content')
<style>
     body {
        font-family: 'Montserrat', sans-serif;
        margin: 0;
        background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://static.wixstatic.com/media/952b60_67f559efb50a4101804756294550c92a~mv2.jpg') no-repeat center center/cover;
        color: #000;
    }

    .foto-perfil {
        min-height: 100vh;
        padding: 20px;
    }

    .foto-card {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .foto-preview {
        width: 200px;
        height: 200px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #fff;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        margin: 0 auto;
        display: block;
    }

    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 15px;
        padding: 40px;
        text-align: center;
        transition: all 0.3s;
        cursor: pointer;
        background: #f8f9fa;
    }

    .upload-area:hover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.1);
    }

    .upload-area.dragover {
        border-color: #667eea;
        background: rgba(102, 126, 234, 0.2);
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

    .btn-danger {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: bold;
    }

    .btn-secondary {
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: bold;
    }
</style>

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
