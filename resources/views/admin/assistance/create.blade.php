@extends('layout.admin-panel')

@section('links')
    <!-- DataTables CSS (if needed) -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">

    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
@endsection

@section('content')
    <nav class="pt-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mb-0 pb-0">
            <li class="breadcrumb-item"><a href="{{ route('index.home') }}">Home</a></li>
            <li class="breadcrumb-item active">Service Records</li>
        </ol>
        <div>
            <span style="font-weight: 500; font-size: 25px; border-radius: 5px; border-bottom: 4px solid #435ebe;">
                Add Beneficiary
            </span>
        </div>
    </nav>

    <br>

    <div class="row">
        <div class="col-12">
            @if ($errors->has('duplicate'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('duplicate') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.service.store') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-4">
                                <label>First Name</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="col-4">
                                <label>Middle Name</label>
                                <input type="text" class="form-control" name="middle_name" required>
                            </div>
                            <div class="col-4">
                                <label>Last Name</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                            <div class="col-4">
                                <label>Birth Date</label>
                                <input type="date" class="form-control" name="birth_date" required>
                            </div>
                            <div class="col-4">
                                <label>Age</label>
                                <input type="number" class="form-control" name="age" required>
                            </div>
                            <div class="col-4">
                                <label>Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <label>Occupation</label>
                                <input type="text" class="form-control" name="occupation" required>
                            </div>
                            <div class="col-4">
                                <label>Contact No</label>
                                <input type="text" class="form-control" name="contact_no" required>
                            </div>

                            <input type="text" name="latitude" id="latitude">
                            <input type="text" name="longitude" id="longitude">

                            <div class="col-6">
                                <label>Location Name</label>
                                <input type="text" class="form-control" id="outlet_name" name="outlet_name" readonly>
                            </div>
                            <div class="col-6">
                                <label>Complete Address</label>
                                <input type="text" class="form-control" id="outlet_address" name="outlet_address"
                                    readonly>
                            </div>
                        </div>

                        <div class="my-4">
                            <label>Click or drag marker on the map to set location</label>
                            <div id="map" style="height: 500px; width: 100%;"></div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.assistance.index') }}" class="btn btn-light-secondary me-2">Close</a>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <!-- jQuery (must come before Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <!-- Select2 JS -->
    <script src="{{ asset('assets/extensions/select2/select2.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2();

            // Initialize map centered on Surigao City
            var map = L.map('map').setView([9.1011711, 126.1588771], 13);
            let marker = null;

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 18,
                attribution: ''
            }).addTo(map);

            // Function to get address details from coordinates
            async function getLocationDetails(lat, lng) {
                try {
                    const response = await fetch(
                        `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();

                    // Update form fields
                    $('#latitude').val(lat);
                    $('#longitude').val(lng);
                    $('#outlet_name').val(data.name || data.address.amenity || data.address.road ||
                        'Unnamed Location');
                    $('#outlet_address').val(data.display_name);
                } catch (error) {
                    console.error('Error fetching location details:', error);
                }
            }

            // Create draggable marker
            marker = L.marker([9.1011711, 126.1588771], {
                draggable: true
            }).addTo(map);

            // Handle marker drag end
            marker.on('dragend', function(event) {
                const position = marker.getLatLng();
                getLocationDetails(position.lat, position.lng);
            });

            // Handle map click
            map.on('click', function(e) {
                const position = e.latlng;
                marker.setLatLng(position);
                getLocationDetails(position.lat, position.lng);
            });

            // Initial location details fetch
            getLocationDetails(9.1011711, 126.1588771);
        });
    </script>
@endsection
