@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" crossorigin="" />
    <style>
        #map {
            height: 400px;
            width: 100%;
            margin-bottom: 1rem;
            min-height: 400px;
            min-width: 100%;
        }
    </style>
@endpush

<div id="map"></div>

@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" crossorigin=""></script>

    <script>
        var map = L.map('map').setView([-3.318750, 114.593000], 13); // Default to Banjarmasin

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker;

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng).addTo(map);

            document.getElementById('lokasi_koordinat').value = e.latlng.lat + ',' + e.latlng.lng;

            // Geocoding using Nominatim API
            fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${e.latlng.lat}&lon=${e.latlng.lng}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('alamat').value = data.display_name || '';
                })
                .catch(() => {
                    document.getElementById('alamat').value = '';
                });
        }

        map.on('click', onMapClick);
    </script>
@endpush
