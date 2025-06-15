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
            "StreetMap": baseLayer1,
            "SateliteMap": baseLayer2
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

        // Add event listener to alamat input for forward geocoding on input event (to allow typing)
        document.getElementById('alamat').addEventListener('input', function() {
            var address = this.value;
            if (address.length > 5) {
                fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(address)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);
                            var latlng = L.latLng(lat, lon);

                            if (marker) {
                                map.removeLayer(marker);
                            }
                            marker = L.marker(latlng, {draggable: true}).addTo(map);
                            map.setView(latlng, 15);

                            document.getElementById('lokasi_koordinat').value = lat + ',' + lon;

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
                    })
                    .catch(() => {
                        // Handle errors silently
                    });
            }
        });

        // Add event listener to alamat input for 'blur' event to trigger geocoding on input finish
        document.getElementById('alamat').addEventListener('blur', function() {
            var address = this.value;
            if (address.length > 5) {
                fetch(`https://nominatim.openstreetmap.org/search?format=jsonv2&q=${encodeURIComponent(address)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data && data.length > 0) {
                            var lat = parseFloat(data[0].lat);
                            var lon = parseFloat(data[0].lon);
                            var latlng = L.latLng(lat, lon);

                            if (marker) {
                                map.removeLayer(marker);
                            }
                            marker = L.marker(latlng, {draggable: true}).addTo(map);
                            map.setView(latlng, 15);

                            document.getElementById('lokasi_koordinat').value = lat + ',' + lon;

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
                    })
                    .catch(() => {
                        // Handle errors silently
                    });
            }
        });

        map.on('click', onMapClick);

        // Add GPS location feature with high accuracy option and browser-specific handling
        // Changed to activate GPS only on button click
        var gpsButton = L.control({position: 'bottomright'});

        gpsButton.onAdd = function(map) {
            var div = L.DomUtil.create('div', 'leaflet-bar leaflet-control leaflet-control-custom');
            div.style.backgroundColor = 'white';
            div.style.width = '34px';
            div.style.height = '34px';
            div.style.cursor = 'pointer';
            div.style.backgroundImage = "url('https://cdn-icons-png.flaticon.com/512/61/61168.png')";
            div.style.backgroundSize = "24px 24px";
            div.style.backgroundRepeat = "no-repeat";
            div.style.backgroundPosition = "center";
            div.title = "Use GPS to locate";

            div.onclick = function(){
                if (navigator.geolocation) {
                    var geoOptions = {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    };

                    function success(position) {
                        var latlng = L.latLng(position.coords.latitude, position.coords.longitude);
                        map.setView(latlng, 15);

                        if (marker) {
                            map.removeLayer(marker);
                        }
                        marker = L.marker(latlng, {draggable: true}).addTo(map);

                        document.getElementById('lokasi_koordinat').value = latlng.lat + ',' + latlng.lng;

                        // Geocoding for initial GPS location
                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latlng.lat}&lon=${latlng.lng}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('alamat').value = data.display_name || '';
                            })
                            .catch(() => {
                                document.getElementById('alamat').value = '';
                            });

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

                    function error(err) {
                        console.warn(`ERROR(${err.code}): ${err.message}`);
                    }

                    navigator.geolocation.getCurrentPosition(success, error, geoOptions);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }
            };

            return div;
        };

        gpsButton.addTo(map);
    </script>
@endpush
