@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">

        <div class="col-md-10">
            <div class="card shadow-lg">
                <div class="card-header bg-dark text-white text-center">
                    <h3 class="mb-0">🚖 Panel de Usuario</h3>
                </div>
                    <!-- Contenido principal -->
                    <div class="text-center">
                        <p class="fs-5 text-muted">
                            Bienvenido a NAWI!! Para seguir con tu registro ve al menú de navegación
                        </p>

                        <!-- Logo -->
                        <div class="mt-4">
                            <img src="{{ asset('images/logo2.jpg') }}" alt="Logo NAWI" 
                                 class="img-fluid" style="max-width: 250px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
