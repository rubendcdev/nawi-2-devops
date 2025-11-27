@extends('layouts.offline')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <style>
        .container, .container * {
            color: #fff !important;
        }
        h1, h2, h3, p, .intro-text {
            color: #fff !important;
        }
        .card-back p, .card-back h2, .card-back h3 {
            color: #fff !important;
        }
        .empty-state, .empty-state h3, .empty-state p {
            color: #fff !important;
        }
        footer, footer p {
            color: #fff !important;
        }
        body {
            color: #fff !important;
        }
    </style>
@endpush

@section('content')

<div class="container">
    <h1>Taxistas Verificados (Offline)</h1>
    <p class="intro-text">Conoce a los conductores registrados y verificados por NAWI. Modo sin conexión.</p>

    <div class="grid" id="lista-taxistas">
        <!-- Las tarjetas se generarán dinámicamente desde localStorage -->
    </div>
</div>

<footer>
    <p>&copy; 2025 NAWI TECNOLOGÍAS S.A. DE C.V.</p>
    <p>Todos los derechos reservados.</p>
</footer>

<script type="text/javascript">
    (function () {
        'use strict';

        function obtenerRutaImagen(taxista) {
            // Intentar obtener la foto del taxista
            if (taxista.usuario && taxista.usuario.fotos && taxista.usuario.fotos.length > 0) {
                var fotoUrl = taxista.usuario.fotos[0].url;
                // Verificar si la imagen está en caché o usar la ruta relativa
                return '/uploads/fotos/' + fotoUrl;
            }
            return '/images/default-avatar.svg';
        }

        function obtenerNombreCompleto(taxista) {
            var nombre = taxista.usuario && taxista.usuario.nombre ? taxista.usuario.nombre : 'Sin nombre';
            var apellido = taxista.usuario && taxista.usuario.apellido ? taxista.usuario.apellido : '';
            return (nombre + ' ' + apellido).trim();
        }

        function obtenerEmail(taxista) {
            return taxista.usuario && taxista.usuario.email ? taxista.usuario.email : 'No disponible';
        }

        function obtenerEstadoDocumento(documento) {
            if (documento && documento.estatus && documento.estatus.nombre) {
                return documento.estatus.nombre;
            }
            return 'Pendiente';
        }

        function obtenerInfoVehiculo(taxista) {
            if (taxista.taxis && taxista.taxis.length > 0) {
                var taxi = taxista.taxis[0];
                return {
                    marca: taxi.marca || 'No disponible',
                    modelo: taxi.modelo || 'No disponible',
                    numero: taxi.numero_taxi || 'No disponible'
                };
            }
            return null;
        }

        function crearTarjetaTaxista(taxista, index) {
            var nombreCompleto = obtenerNombreCompleto(taxista);
            var email = obtenerEmail(taxista);
            var imagenUrl = obtenerRutaImagen(taxista);
            var estadoMatricula = obtenerEstadoDocumento(taxista.matricula);
            var estadoLicencia = obtenerEstadoDocumento(taxista.licencia);
            var vehiculo = obtenerInfoVehiculo(taxista);

            var htmlVehiculo = '';
            if (vehiculo) {
                htmlVehiculo =
                    '<p style="color: #fff !important;"><strong>Marca:</strong> ' + vehiculo.marca + '</p>' +
                    '<p style="color: #fff !important;"><strong>Modelo:</strong> ' + vehiculo.modelo + '</p>' +
                    '<p style="color: #fff !important;"><strong>Número:</strong> #' + vehiculo.numero + '</p>';
            } else {
                htmlVehiculo = '<p style="color: #fff !important;"><em>No registrado</em></p>';
            }

            var cardHtml =
                '<div class="card" style="color: #fff !important;">' +
                    '<div class="card-inner">' +
                        '<!-- FRONT -->' +
                        '<div class="card-front">' +
                            '<img src="' + imagenUrl + '" alt="Foto de ' + nombreCompleto + '" onerror="this.src=\'/images/default-avatar.svg\'">' +
                            '<div class="card-body" style="color: #fff !important;">' +
                                '<h2 style="color: #ffc107 !important;">' + nombreCompleto + '</h2>' +
                                '<p style="color: #fff !important;">Taxista Verificado</p>' +
                            '</div>' +
                        '</div>' +
                        '<!-- BACK -->' +
                        '<div class="card-back" style="color: #fff !important;">' +
                            '<h2 style="color: #ffc107 !important;">' + nombreCompleto + '</h2>' +
                            '<hr>' +
                            '<p style="color: #fff !important;"><strong>📧 Email:</strong> ' + email + '</p>' +
                            '<hr>' +
                            '<h3 style="color: #ffc107 !important;">📄 Documentos</h3>' +
                            '<p style="color: #fff !important;">Matrícula: <strong>' + estadoMatricula + '</strong></p>' +
                            '<p style="color: #fff !important;">Licencia: <strong>' + estadoLicencia + '</strong></p>' +
                            '<hr>' +
                            '<h3 style="color: #ffc107 !important;">🚗 Vehículo</h3>' +
                            htmlVehiculo +
                        '</div>' +
                    '</div>' +
                '</div>';

            return cardHtml;
        }

        function cargarTaxistasOffline() {
            var taxistas = [];
            try {
                var taxistasData = localStorage.getItem('taxistas');
                if (taxistasData) {
                    taxistas = JSON.parse(taxistasData);
                }
            } catch (e) {
                console.error('Error al leer taxistas de localStorage:', e);
                taxistas = [];
            }

            var container = document.getElementById('lista-taxistas');
            if (!container) {
                console.error('No se encontró el contenedor de taxistas');
                return;
            }

            if (!Array.isArray(taxistas) || taxistas.length === 0) {
                container.innerHTML =
                    '<div class="empty-state" style="color: #fff !important;">' +
                        '<h3 style="color: #ffc107 !important;">🚕 No hay taxistas guardados</h3>' +
                        '<p style="color: #fff !important;">No hay taxistas guardados para mostrar sin conexión. Conecta a internet para cargar los taxistas verificados.</p>' +
                    '</div>';
                return;
            }

            var html = '';
            taxistas.forEach(function (taxista, index) {
                var tarjeta = crearTarjetaTaxista(taxista, index);
                if (tarjeta) {
                    html += tarjeta;
                }
            });

            if (html === '') {
                container.innerHTML =
                    '<div class="empty-state" style="color: #fff !important;">' +
                        '<h3 style="color: #ffc107 !important;">🚕 No hay taxistas disponibles</h3>' +
                        '<p style="color: #fff !important;">Los datos guardados no contienen información suficiente para mostrar las tarjetas.</p>' +
                    '</div>';
            } else {
                container.innerHTML = html;
            }
        }

        // Ejecutar cuando el DOM esté listo
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', cargarTaxistasOffline);
        } else {
            cargarTaxistasOffline();
        }
    })();
</script>
@endsection
