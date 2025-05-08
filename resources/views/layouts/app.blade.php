<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @livewireStyles
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Gestor de Predios de la CAS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Bootstrap -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Leaflet CSS -->
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- Leaflet JS -->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        <!-- Proj4js y Proj4Leaflet -->
        <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.6/proj4.js"></script>-->
        <!-- <script src="https://unpkg.com/proj4leaflet"></script>-->

        <!-- Scripts personalizados -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                
                window.confirmarEliminacion = function (id) {
                    Swal.fire({
                        title: 'Eliminación de Predio',
                        text: "¿Está seguro de eliminar el registro con id: " + id + "? Esta acción no se puede deshacer.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Livewire.emit('eliminarPredio', id);
                        }
                    });
                };
            
                let mapa = null; // Variable global para controlar la instancia del mapa

                window.verMapaPredio = function (id) {
                    const globalSpinner = document.getElementById('global-loading-spinner');
                    globalSpinner.style.display = 'flex'; // Mostrar el spinner inmediatamente

                    fetch(`/predios/geojson/${id}`)
                        .then(res => res.json())
                        .then(data => {
                        const modalElement = document.getElementById('mapaModal');
                        if (!modalElement) {
                            console.error("El modal con id 'mapaModal' no se encontró.");
                            globalSpinner.style.display = 'none';
                            return;
                        }
                    
                        const myModal = new bootstrap.Modal(modalElement);
                        myModal.show();
                    
                        modalElement.addEventListener('shown.bs.modal', function () {
                            if (mapa) {
                                mapa.remove();
                                mapa = null;
                            }
                        
                            // Limpia visor
                            document.getElementById('visor-mapa').innerHTML = "";
                        
                            mapa = L.map('visor-mapa').setView([7.065, -73.851], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                maxZoom: 19
                            }).addTo(mapa);
                        
                            const geoJsonLayer = L.geoJSON(data.geometry).addTo(mapa);
                            mapa.fitBounds(geoJsonLayer.getBounds());
                        
                            // Oculta el spinner después de que todo esté listo
                            globalSpinner.style.display = 'none';
                        }, { once: true });
                    })
                    .catch(err => {
                        console.error("Error al cargar el mapa:", err);
                        globalSpinner.style.display = 'none';
                    });
                };


                window.editarPredio = function(id) {
                    document.getElementById('global-loading-spinner').style.display = 'flex';

                    // Emitimos evento Livewire para editar
                    Livewire.dispatch('edit', id);
                };
                    // Ocultamos el spinner una vez Livewire haya terminado de procesar
                    Livewire.on('editado', () => {
                        document.getElementById('global-loading-spinner').style.display  = 'none';
                    });
            });
            </script>

        @livewireScripts
    </body>
</html>
