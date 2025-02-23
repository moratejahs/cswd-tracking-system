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
                Asssitance Records
            </span>
        </div>
    </nav>
    <br>
    <div class="row">
        <div class="col1">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Create Assistance</h5>
                    <hr>
                    <form action="{{ route('store.save.assistance') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label for="unit">Assitance Code <span class="text-danger">*</span></label>
                                    <input id="unit" type="text" name="code" class="form-control "
                                        placeholder="Enter assistance code" required>
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label for="cost-price">Assistance Name <span class="text-danger">*</span></label>
                                    <input id="cost-price" type="text" name="assistance_name" class="form-control "
                                        placeholder="Enter assistance name">
                                </div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <label for="sale-price">Assistance Description <span
                                            class="text-danger">*</span></label>
                                    <input id="sale-price" type="text" name="description" class="form-control "
                                        placeholder="Enter asssistance description">
                                </div>
                            </div>


                            <div class="col-md-12 mb-2">
                                <div class="form-group">
                                    <label for="supplier-name">Select Barangays <span class="text-danger">*</span></label>
                                    <select id="supplier-name" name="barangaysid[]" multiple="multiple"
                                        class="barangays-select-2 form-select form-select-lg" style="width: 100%;" required>
                                        @foreach ($barangays as $barangay)
                                            <option value="{{ $barangay->id }}">
                                                {{ $barangay->outlet_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="pb-2 col-12 d-flex justify-content-end">
                                {{-- <a href="{{ route('admin.assistance.index') }}" class="btn btn-light-secondary me-1"
                                    data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </a> --}}
                                <button id="submit-button" type="submit" class="btn btn-primary">
                                    <div style="display: flex;">
                                        <div class="save-loader">
                                            <i class="bi bi-check2"></i>
                                        </div>
                                        <div class="preloader mx-2 mt-1" role="status"></div>
                                        <span id="save" class="d-none d-sm-block">Submit</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/extensions/select2/select2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('.barangays-select-2').select2({
            placeholder: 'List of barangays',

            tags: true,
        });
    </script>
@endsection
