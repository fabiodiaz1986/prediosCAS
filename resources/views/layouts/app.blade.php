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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/proj4js/2.7.6/proj4.js"></script>
        <script src="https://unpkg.com/proj4leaflet"></script>

        <!-- Scripts personalizados -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                window.confirmarEliminacion = function (id) {
                    Swal.fire({
                        title: 'Eliminación de Prédio',
                        text: "¿Está seguro de realizar la eliminación del registro con id: " + id + "?. Esta acción no se puede deshacer una vez la confirme.",
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

                // Definición del sistema EPSG:3116
                //proj4.defs("EPSG:3116", "+proj=tmerc +lat_0=4.596200416666666 +lon_0=-74.07750791666666 +k=1 +x_0=1000000 +y_0=1000000 +ellps=GRS80 +units=m +no_defs");
/*
                function reproyectarGeoJSON3116a4326(geojson) {
                    const reproyectado = JSON.parse(JSON.stringify(geojson)); // Copia para no mutar el original

                    if (geojson.geometry.type === "MultiPolygon") {
                        reproyectado.geometry.coordinates = geojson.geometry.coordinates.map(polygon =>
                            polygon.map(ring =>
                                ring.map(coord => {
                                    const [x, y] = coord;
                                    const [lon, lat] = proj4("EPSG:3116", "EPSG:4326", [x, y]);
                                    return [lon, lat];
                                })
                            )
                        );
                    }

                    return reproyectado;
                }
*/
 window.verMapaPredio = function (id) {
     fetch(`/predios/geojson/${id}`)
        .then(res => res.json())
        .then(data => {
            const modalElement = document.getElementById('mapaModal');
            if (!modalElement) {
                console.error("El modal con id 'mapaModal' no se encontró.");
                return;
            }

            // Abrir modal
            const myModal = new bootstrap.Modal(modalElement);
            myModal.show();

            

            // Esperar a que el modal se muestre completamente
            modalElement.addEventListener('shown.bs.modal', function () {
                // Limpiar contenedor del mapa por si ya se cargó antes
                document.getElementById('visor-mapa').innerHTML = "";

                // Crear mapa con Leaflet
                const mapa = L.map('visor-mapa').setView([7.065, -73.851], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19
                }).addTo(mapa);

                L.geoJSON(data.geometry).addTo(mapa);
                
            }, { once: true }); // `once` asegura que este listener solo se use una vez
        });
}
});
        </script>

        @livewireScripts
    </body>
</html>
