@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">

    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 10px;
        }
    </style>
@endsection

@section('content')
    <nav class="pt-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" data-aos="fade-down">
        <ol class="pb-0 mb-0 breadcrumb">
            <li class="breadcrumb-item active text-secondary"><a href="{{ route('index.home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Home</a></li>
            <a class="breadcrumb-item active text-secondary" href="{{ route('admin.assistance.index') }}"
                aria-current="page">
                Assistance Records
            </a>
        </ol>
        <div>
            <span
                style="font-weight: 500; font-size: 25px; border-radius: 5px; border-bottom: 4px solid #435ebe; width: fit-content;"
                class="pt-0 mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                    class="bi bi-arrow-return-right" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M1.5 1.5A.5.5 0 0 0 1 2v4.8a2.5 2.5 0 0 0 2.5 2.5h9.793l-3.347 3.346a.5.5 0 0 0 .708.708l4.2-4.2a.5.5 0 0 0 0-.708l-4-4a.5.5 0 0 0-.708.708L13.293 8.3H3.5A1.5 1.5 0 0 1 2 6.8V2a.5.5 0 0 0-.5-.5z" />
                </svg>
                Tandag City Map
            </span>
        </div>
    </nav>

    <br>

    <div class="row">
        <div id="map"></div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var map = L.map('map').setView([9.1011711, 126.1588771], 13); // Center on Tandag City

            // Add OpenStreetMap Tile Layer
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; CSWD: AI Driven Assistant Tracking System'
            }).addTo(map);

            // Fetch barangays from Laravel and convert to JSON
            var barangays = @json($barangays);

            barangays.forEach(function(barangay) {
                if (barangay.latitude && barangay.longtitude) {
                    // Determine the correct icon based on status
                    var iconUrl = barangay.status === 'pending' ?
                        "{{ asset('assets/images/failed.png') }}" // If status is 'pending', use the failed icon
                        :
                        "{{ asset('assets/images/check.png') }}"; // If status is 'done', use the check icon

                    var customIcon = L.icon({
                        iconUrl: iconUrl,
                        iconSize: [20, 20] // Adjust size (width, height)
                    });

                    L.marker([barangay.latitude, barangay.longtitude], {
                            icon: customIcon
                        })
                        .addTo(map)
                        .bindTooltip(barangay.outlet_name, {
                            permanent: true,
                            direction: "top",
                            offset: [0, -10]
                        });
                }
            });
        });
    </script>


    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/extensions/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{ asset('js/assistance-fund/index.js') }}"></script>
    <script src="{{ asset('js/assistance-fund/delete.js') }}"></script>
    <script src="{{ asset('js/assistance-fund/edit.js') }}"></script>
@endsection
