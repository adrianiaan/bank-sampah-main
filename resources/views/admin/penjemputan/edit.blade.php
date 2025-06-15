@extends('layouts.app')

@section('content')
    <h5 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Home</span> / Edit Jadwal Penjemputan</h5>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form id="form-edit-penjemputan" action="{{ route('penjemputan.update', $penjemputan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="jadwal" class="form-label">Jadwal Penjemputan</label>
                            <input type="datetime-local" class="form-control" id="jadwal" name="jadwal" value="{{ \Carbon\Carbon::parse($penjemputan->jadwal)->format('Y-m-d\TH:i') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="Terjadwal" {{ $penjemputan->status == 'Terjadwal' ? 'selected' : '' }}>Terjadwal</option>
                                <option value="Selesai" {{ $penjemputan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Batal" {{ $penjemputan->status == 'Batal' ? 'selected' : '' }}>Batal</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="lokasi_koordinat" class="form-label">Lokasi Koordinat</label>
                            <input type="text" class="form-control" id="lokasi_koordinat" name="lokasi_koordinat" value="{{ $penjemputan->lokasi_koordinat }}" required>
                        </div>

                        <div id="mapEdit" style="height: 400px; margin-bottom: 1rem;"></div>

                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $penjemputan->alamat }}</textarea>
                        </div>

                        <a href="{{ route('penjemputan.index') }}" class="btn btn-secondary">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" crossorigin="" />
    <style>
        #mapEdit {
            height: 400px;
            width: 100%;
            margin-bottom: 1rem;
            min-height: 400px;
            min-width: 100%;
        }
    </style>
@endpush

@push('script')
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" crossorigin=""></script>

    <script>
        var map = L.map('mapEdit').setView([-3.318750, 114.593000], 13); // Default to Banjarmasin

        var baseLayer1 = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        });

        var baseLayer2 = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: '© Esri & contributors'
        });

        baseLayer1.addTo(map);

        var baseLayers = {
            "OpenStreetMap": baseLayer1,
            "Satelit": baseLayer2
        };

        L.control.layers(baseLayers).addTo(map);

        var marker;

        function onMapClick(e) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(e.latlng, {draggable: true}).addTo(map);

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

        // Initialize marker at existing coordinates
        var koordinat = "{{ $penjemputan->lokasi_koordinat }}";
        if (koordinat) {
            var parts = koordinat.split(',');
            if (parts.length === 2) {
                var latlng = [parseFloat(parts[0]), parseFloat(parts[1])];
                marker = L.marker(latlng, {draggable: true}).addTo(map);
                map.setView(latlng, 15);

                marker.on('dragend', function (e) {
                    var position = marker.getLatLng();
                    document.getElementById('lokasi_koordinat').value = position.lat + ',' + position.lng;

                    // Update address on dragend
                    fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${position.lat}&lon=${position.lng}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('alamat').value = data.display_name || '';
                        })
                        .catch(() => {
                            document.getElementById('alamat').value = '';
                        });
                });
            }
        }
    </script>
@endpush
