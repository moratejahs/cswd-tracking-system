@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 10px;
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
                    </div>
                    <div class="card-body">
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
                            'San Isidro', 'Awasian', 'Bagong Lungsod', 'Bioto', 'Bungtod', 'Buenavista',
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
            var map = L.map('map').setView([9.1011711, 126.1588771], 13);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; CSWD: AI Driven Assistant Tracking System'
            }).addTo(map);

            var barangays = @json($barangays);

            barangays.forEach(function(barangay) {
                if (barangay.latitude && barangay.longtitude) {
                    var iconUrl;
                    if (barangay.assistance_level === "Low Assistance (0-44%)") {
                        iconUrl = "{{ asset('assets/images/location.png') }}";
                    } else if (barangay.assistance_level === "Medium Assistance (45-74%)") {
                        iconUrl = "{{ asset('assets/images/yellow.png') }}";
                    } else if (barangay.assistance_level === "High Assistance (75-100%)") {
                        iconUrl = "{{ asset('assets/images/blue.png') }}";
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


                    marker.on("click", function() {
                        fetch(`/admin/barangay/${barangay.outlet_address}`)
                            .then(response => response.json())
                            .then(data => {
                                let modalBody = document.querySelector(
                                    "#barangayModal .modal-body");
                                modalBody.innerHTML = ""; // Clear previous data

                                if (data.length > 0) {
                                    let table = `
                                    <div><h6 class="text-dark fw-medium">Barangay: ${barangay.outlet_name} has (${barangay.assistance_percentage}%) of its ${barangay.total_population.toLocaleString()} total data poverty population received assistance.</h6></div>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Category</th>
                                                <th>Full Name</th>
                                                <th>Amount</th>
                                            </tr>
                                        </thead>
                                        <tbody>`;

                                    data.forEach(item => {
                                        table += `
                                            <tr>
                                                <td>${item.assistance}</td>
                                                <td>${item.first_names} ${item.middle_names} ${item.last_names}</td>
                                                <td>${item.total_quantity}</td>
                                            </tr>`;
                                    });

                                    table += `</tbody></table>`;
                                    modalBody.innerHTML = table;
                                } else {
                                    modalBody.innerHTML =
                                        `<p class="text-danger">No assistance records found for this barangay.</p>`;
                                }

                                var modal = new bootstrap.Modal(document.getElementById(
                                    'barangayModal'));
                                modal.show();
                            })
                            .catch(error => console.error("Error fetching barangay details:",
                                error));
                    });
                }
            });
        });
    </script>
@endsection
