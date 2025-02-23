@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('vendor/DataTables/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}"> --}}
    <link href="{{ asset('assets/extensions/select2/select2.min.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">
@endsection

@section('content')
    @include('admin.include.admin-store-item-modal')
    @include('admin.include.admin-edit-item-modal')
    @include('admin.include.admin-remove-item-modal')
    @include('admin.include.admin-add-product-stock-in-modal')
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
                Inventory
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
                Inventory Record
            </span>
        </div>
    </nav>
    <br>
    <div class="row">
        <div class="col-12">
            <div class="card" data-aos="fade-left">
                <div class="card-body">
                    <button type="button" class="btn-sm block btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#store-product-modal">
                        <i class="bi bi-plus-lg"></i> New Product
                    </button>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="inventoryRecord">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center text-white">Code</th>
                                    <th class="text-white">Product Description</th>
                                    <th class="text-white">Supplier</th>
                                    <th class="text-white">Unit</th>
                                    <th class="text-center text-white">Qty</th>
                                    <th class="text-center text-white">Cost Price</th>
                                    <th class="text-center text-white">J.H Sale Price</th>
                                    <th class="text-center text-white">J.M Sale Price</th>
                                    <th class="text-center text-white">Status</th>
                                    <th class="text-center text-white">Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('vendor/DataTables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/extensions/select2/select2.min.js') }}"></script>
    <script src="{{ asset('assets/static/ajax/inventory/inventory-record.js') }}"></script>
    <script src="{{ asset('assets/static/ajax/inventory/inventory-stock-in-record.js') }}"></script>
    <script src="{{ asset('assets/js/form-validation/store-product.js') }}"></script>
    <script src="{{ asset('assets/js/custome/number-formater.js') }}"></script>
    <script>
        $('.product-select-2').select2({
            placeholder: 'New product',
            dropdownParent: '#store-product-modal',
            tags: true,
        });
        $('.category-select-2').select2({
            placeholder: 'New category',
            dropdownParent: '#store-product-modal',
            tags: true,
        });
        $('.supplier-select-2').select2({
            placeholder: 'New Supplier',
            dropdownParent: '#store-product-modal',
            tags: true,
        });
    </script>
    <script src="{{ asset('assets/js/pages/inventory-datatable.js') }}"></script>
@endsection
