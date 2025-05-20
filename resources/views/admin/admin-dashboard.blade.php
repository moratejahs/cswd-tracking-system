@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 10px;
        }

        .map-controls {
            z-index: 1000;
            position: relative;
        }

        .map-controls .btn-group {
            background: white;
            padding: 5px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .map-controls .btn {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    </style>
@endsection

@section('content')
    <!-- Modal -->
    <div class="modal fade" id="barangayModal" tabindex="-1" aria-labelledby="barangayModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="barangayModalLabel">Barangay Details</h5>
                    <button type="button" class="btn btn-primary btn-sm me-2" onclick="printModalContent()">
                        <i class="bi bi-printer"></i> Print
                    </button>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="modalBarangayName"></span></p>
                    <p><strong>Status:</strong> <span id="modalBarangayStatus"></span></p>
                    <p><strong>Latitude:</strong> <span id="modalBarangayLat"></span></p>
                    <p><strong>Longitude:</strong> <span id="modalBarangayLong"></span></p>

                    <h5 class="mt-3">Monthly Data Overview</h5>

                </div>
            </div>
        </div>
    </div>

    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5> Client Category Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="col-2">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle btn-sm me-1" type="button"
                                    id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true"
                                    aria-expanded="false">
                                    Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach ($categories as $category)
                                        <a class="dropdown-item" href="#"
                                            data-category="{{ $category->description }}">
                                            {{ $category->description }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Tandag Map Statistics</h4>
                        <div class="time-filters mt-2">
                            <div class="btn-group" role="group" aria-label="Time Period Filters">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="filterWeek">
                                    <i class="bi bi-calendar-week"></i> This Week
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="filterMonth">
                                    <i class="bi bi-calendar-month"></i> This Month
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="filterYear">
                                    <i class="bi bi-calendar"></i> This Year
                                </button>
                                <button type="button" class="btn btn-outline-secondary btn-sm" id="filterAll">
                                    <i class="bi bi-calendar-x"></i> All Time
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <center>
                                <span class="badge bg-danger">High Assistance (75-100%)</span>
                                <span class="badge bg-success">Medium Assistance (45-74%)</span>
                                <span class="badge bg-warning">Low Assistance (0-44%)</span>
                            </center>
                        </div>
                        <div class="map-controls mb-3">
                            <div class="btn-group" role="group" aria-label="Map Controls">
                                <button type="button" class="btn btn-outline-primary btn-sm" id="satelliteView">
                                    <i class="bi bi-globe"></i> Satellite
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="terrainView">
                                    <i class="bi bi-mountains"></i> Terrain
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="trafficView">
                                    <i class="bi bi-sign-intersection-y"></i> Traffic
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="transitView">
                                    <i class="bi bi-train-front"></i> Transit
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="bikingView">
                                    <i class="bi bi-bicycle"></i> Biking
                                </button>
                            </div>
                        </div>
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var chart; // Declare the chart variable

            // This function will render or update the chart
            function renderChart(data) {
                var options = {
                    chart: {
                        type: 'bar',
                        height: 350
                    },
                    series: [{
                        name: "Total",
                        data: data
                    }],
                    colors: ['#3498db'],
                    xaxis: {
                        categories: [
                            'San Isidro', 'Awasian', 'Bagong Lungsod', 'Bioto', 'Bongtud', 'Buenavista',
                            'Dagocdoc', 'Mabua', 'Mabuhay', 'Maitum', 'Maticdum', 'Pandanon', 'Pangi',
                            'Quezon', 'Rosario', 'Salvacion', 'San Agustin Norte', 'San Agustin Sur',
                            'San Antonio', 'San Jose', 'Telaje'
                        ]
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '50%'
                        }
                    },
                    dataLabels: {
                        enabled: true
                    },
                    legend: {
                        position: 'top'
                    }
                };

                if (chart) {
                    chart.updateSeries([{
                        data: data
                    }]);
                } else {
                    chart = new ApexCharts(document.querySelector("#lineChart"), options);
                    chart.render();
                }
            }

            // Initial chart render with default data
            renderChart([
                {{ $sanIsidro }},
                {{ $awasian }},
                {{ $bagongLungsod }},
                {{ $bioto }},
                {{ $bongtod }},
                {{ $buenavista }},
                {{ $dagocdoc }},
                {{ $mabua }},
                {{ $mabuhay }},
                {{ $maitum }},
                {{ $maticdum }},
                {{ $pandanon }},
                {{ $pangi }},
                {{ $quezon }},
                {{ $rosario }},
                {{ $salvacion }},
                {{ $sanAgustinNorte }},
                {{ $sanAgustinSur }},
                {{ $sanAntonio }},
                {{ $sanJose }},
                {{ $telaje }}
            ]);

            // Event listener for filter dropdown
            document.querySelectorAll('.dropdown-item').forEach(function(item) {
                item.addEventListener('click', function() {
                    var category = this.getAttribute('data-category');
                    fetch(`/admin/category-data?category=${category}`)
                        .then(response => response.json())
                        .then(data => {
                            renderChart(data.values); // Update the chart with new data
                        })
                        .catch(error => console.error('Error fetching data:', error));
                });
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Base map layers
            var streets = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; CSWD: AI Driven Assistant Tracking System'
            });

            var satellite = L.tileLayer(
                'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
                    attribution: '&copy; Esri &mdash; Source: Esri, i-cubed, USDA, USGS, AEX, GeoEye, Getmapping, Aerogrid, IGN, IGP, UPR-EGP, and the GIS User Community'
                });

            var terrain = L.tileLayer('https://stamen-tiles-{s}.a.ssl.fastly.net/terrain/{z}/{x}/{y}{r}.png', {
                attribution: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>'
            });

            var traffic = L.tileLayer('https://tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors, Tiles style by Humanitarian OpenStreetMap Team'
            });

            var transit = L.tileLayer('https://tileserver.memomaps.de/tilegen/{z}/{x}/{y}.png', {
                attribution: 'Map <a href="https://memomaps.de/">memomaps.de</a> <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>'
            });

            var cycling = L.tileLayer('https://tile.waymarkedtrails.org/cycling/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            });

            // Initialize map with streets layer
            var map = L.map('map', {
                layers: [streets],
                center: [9.1011711, 126.1588771],
                zoom: 13
            });

            // Create a layer control object
            var baseLayers = {
                "Streets": streets,
                "Satellite": satellite,
                "Terrain": terrain,
                "Traffic": traffic,
                "Transit": transit,
                "Cycling": cycling
            };

            // Add layer control to map
            L.control.layers(baseLayers).addTo(map);

            // Layer control buttons
            document.getElementById('satelliteView').addEventListener('click', function() {
                removeAllLayers();
                map.addLayer(satellite);
            });

            document.getElementById('terrainView').addEventListener('click', function() {
                removeAllLayers();
                map.addLayer(terrain);
            });

            document.getElementById('trafficView').addEventListener('click', function() {
                removeAllLayers();
                map.addLayer(traffic);
            });

            document.getElementById('transitView').addEventListener('click', function() {
                removeAllLayers();
                map.addLayer(transit);
            });

            document.getElementById('bikingView').addEventListener('click', function() {
                removeAllLayers();
                map.addLayer(cycling);
            });

            // Helper function to remove all layers
            function removeAllLayers() {
                map.removeLayer(streets);
                map.removeLayer(satellite);
                map.removeLayer(terrain);
                map.removeLayer(traffic);
                map.removeLayer(transit);
                map.removeLayer(cycling);
            }

            var barangays = @json($barangays);

            barangays.forEach(function(barangay) {
                if (barangay.latitude && barangay.longtitude) {
                    var iconUrl;
                    if (barangay.assistance_level === "Low Assistance (0-44%)") {
                        iconUrl = "{{ asset('assets/images/yellow.png') }}";
                    } else if (barangay.assistance_level === "Medium Assistance (45-74%)") {
                        iconUrl = "{{ asset('assets/images/green.png') }}";
                    } else if (barangay.assistance_level === "High Assistance (75-100%)") {
                        iconUrl = "{{ asset('assets/images/location.png') }}";
                    } else {
                        iconUrl = "{{ asset('assets/images/location.png') }}"; // Default icon if undefined
                    }

                    var customIcon = L.icon({
                        iconUrl: iconUrl,
                        iconSize: [20, 20]
                    });

                    var marker = L.marker([barangay.latitude, barangay.longtitude], {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindTooltip(
                            `${barangay.outlet_name} (${barangay.assistance_percentage}%)`, {
                                permanent: true,
                                direction: "top",
                                offset: [0, -10]
                            });

                    // Add click event listener to the marker
                    marker.on('click', function() {
                        // Populate modal with barangay data
                        document.getElementById('modalBarangayName').textContent = barangay
                            .outlet_name || 'N/A';
                        document.getElementById('modalBarangayStatus').textContent = barangay
                            .assistance_level || 'N/A';
                        document.getElementById('modalBarangayLat').textContent = barangay
                            .latitude || 'N/A';
                        document.getElementById('modalBarangayLong').textContent = barangay
                            .longtitude || 'N/A';

                        // Show the modal
                        var barangayModal = new bootstrap.Modal(document.getElementById(
                            'barangayModal'));
                        barangayModal.show();
                    });

                    // Hide tooltips when zoomed out, show when zoomed in
                    map.on('zoomend', function() {
                        var currentZoom = map.getZoom();
                        if (currentZoom < 12) {
                            marker.closeTooltip();
                        } else {
                            marker.openTooltip();
                        }
                    });

                    // Initial tooltip visibility based on current zoom
                    if (map.getZoom() < 12) {
                        marker.closeTooltip();
                    }
                }
            });
        });
    </script>
    <script>
        // Time period filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Filter buttons
            const filterWeekBtn = document.getElementById('filterWeek');
            const filterMonthBtn = document.getElementById('filterMonth');
            const filterYearBtn = document.getElementById('filterYear');
            const filterAllBtn = document.getElementById('filterAll');

            // Add click event listeners
            filterWeekBtn.addEventListener('click', function() {
                applyTimeFilter('week');
            });

            filterMonthBtn.addEventListener('click', function() {
                applyTimeFilter('month');
            });

            filterYearBtn.addEventListener('click', function() {
                applyTimeFilter('year');
            });

            filterAllBtn.addEventListener('click', function() {
                applyTimeFilter('all');
            });

            // Function to apply time filter
            function applyTimeFilter(period) {
                // Highlight active button
                [filterWeekBtn, filterMonthBtn, filterYearBtn, filterAllBtn].forEach(btn => {
                    btn.classList.remove('active');
                });

                // Set active button
                if (period === 'week') {
                    filterWeekBtn.classList.add('active');
                } else if (period === 'month') {
                    filterMonthBtn.classList.add('active');
                } else if (period === 'year') {
                    filterYearBtn.classList.add('active');
                } else {
                    filterAllBtn.classList.add('active');
                }

                // Here you would implement the actual filtering logic
                console.log(`Filtering by ${period}`);
            }
        });
    </script>
    <script>
        function printModalContent() {
            const modalContent = document.querySelector("#barangayModal .modal-body").innerHTML;
            const printWindow = window.open('', '_blank');

            printWindow.document.write(`
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Barangay Assistance Report</title>
                    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
                    <style>
                        body {
                            padding: 20px;
                            font-family: Arial, sans-serif;
                        }
                        .header {
                            text-align: center;
                            margin-bottom: 20px;
                        }
                        .report-title {
                            font-size: 18px;
                            font-weight: bold;
                            margin: 10px 0;
                        }
                        .report-subtitle {
                            font-size: 14px;
                            margin-bottom: 20px;
                        }
                        table {
                            width: 100%;
                            border-collapse: collapse;
                        }
                        th, td {
                            border: 1px solid #ddd;
                            padding: 8px;
                            text-align: left;
                        }
                        th {
                            background-color: #f2f2f2;
                        }
                        @media print {
                            .btn {
                                display: none !important;
                            }
                        }
                    </style>
                </head>
                <body>
                    <div class="header">
                        <div class="report-title">City Social Welfare and Development</div>
                        <div class="report-subtitle">Barangay Assistance Report</div>
                    </div>
                    ${modalContent}
                    <div class="mt-4">
                        <p>Generated on: ${new Date().toLocaleString()}</p>
                    </div>
                    <script>
                        window.onload = function() {
                            window.print();
                        };
                    <\/script>
                </body>
                </html>
            `);

            printWindow.document.close();
        }
    </script>
@endsection
