@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">
@endsection

@section('content')
    {{-- includes --}}
    {{-- @include('admin.assistance.includes.store') --}}

    <nav class="pt-0" style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb" data-aos="fade-down">
        <ol class="pb-0 mb-0 breadcrumb">
            <li class="breadcrumb-item active text-secondary"><a href="{{ route('index.home') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-house" viewBox="0 0 16 16">
                        <path
                            d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5ZM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5 5 5Z" />
                    </svg>
                    Home</a></li>
            <li class="breadcrumb-item active text-secondary" aria-current="page">
                Services
            </li>
            <li class="breadcrumb-item active text-secondary" aria-current="page">
                Assistance Records
            </li>
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
                Add Assistance
            </span>
        </div>
    </nav>
    <br>
    <div class="row">
        <div class="col1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Add Assistance Form</h5>
                    <hr>
                    <form action="{{ route('admin.assistance.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name"
                                        placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="middle_name">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name"
                                        placeholder="Middle Name" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name"
                                        placeholder="Last Name" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="birth_date">Birth Date</label>
                                    <input type="date" class="form-control" id="birth_date" name="birth_date" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Address" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="contact_no">Contact No</label>
                                    <input type="text" class="form-control" id="contact_no" name="contact_no"
                                        placeholder="Contact No" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="status">Status</label>
                                    <input type="text" class="form-control" id="status" name="status"
                                        placeholder="Status" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="occupation">Occupation</label>
                                    <input type="text" class="form-control" id="occupation" name="occupation"
                                        placeholder="Occupation" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="assistance">Assistance</label>
                                    <input type="text" class="form-control" id="assistance" name="assistance"
                                        placeholder="Assistance" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="quantity">Quantity</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        placeholder="Quantity" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="person_of_responsible">Person of Responsible</label>
                                    <input type="text" class="form-control" id="person_of_responsible"
                                        name="person_of_responsible" placeholder="Person of Responsible" required>
                                </div>
                            </div>
                            <div class="pb-2 col-12 d-flex justify-content-end align-items-center">
                                <div>
                                    <a href="{{ route('admin.assistance.index') }}"
                                        class="btn btn-light-secondary me-1 close-button">
                                        <span class="d-none d-sm-block">Close</span>
                                    </a>
                                    <button type="submit" class="btn btn-primary save-button">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Submit</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
@endsection
