@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}"> --}}
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">
@endsection

@section('content')
    @include('admin.include.admin-restore-sales-modal')
    @include('admin.include.admin-restore-quick-sale-modal')
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
                Backup and Restore
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
                Sales Record
            </span>
        </div>
    </nav>
    <br>
    <div class="row">

        <div class="col-12">
            <div class="card" data-aos="fade-left">
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table" id="restore-sales-record">
                            <thead class=" bg-primary">
                                <tr>

                                    <th class="text-white">Product Description</th>
                                    {{-- <th class="text-white">Category</th> --}}
                                    <th class="text-white text-center">Unit</th>
                                    <th class="text-center text-white">Qty</th>
                                    <th class="text-center text-white">Unit Price</th>
                                    <th class="text-center text-white">Amount</th>
                                    <th class="text-center text-white">Sale Date</th>
                                    <th class="text-center text-white">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sales as $sale)
                                    <tr>
                                        <td class="fst-italic">{{ $sale->product_name ?? 'N/A' }}</td>
                                        {{-- <td>{{ $sale->category_name ?? 'N/A' }}</td> --}}
                                        <td class="text-center">{{ $sale->unit ?? 'N/A' }}</td>
                                        <td class="text-center">{{ $sale->quantity }}</td>
                                        <td class="text-center">{{ $sale->sell_price ?? 'N/A' }}</td>
                                        <td class="text-center"><b>{{ $sale->amount }}</b></td>
                                        <td class="text-center text-danger"><small>{{ $sale->sale_date }}</small></td>
                                        <td class="text-center">
                                            @if ($sale->product_id)
                                                <a id="restoreSaleBtn" data-bs-toggle="modal"
                                                    data-bs-target="#restore-sales-modal"
                                                    data-sale-id="{{ $sale->sales_id }}"
                                                    class="btn btn-success rounded-pill btn-sm">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            @else
                                                <a id="restoreQuickSaleBtn" data-bs-toggle="modal"
                                                    data-bs-target="#restore-quick-sale-modal"
                                                    data-sale-id="{{ $sale->sales_id }}"
                                                    class="btn btn-success rounded-pill btn-sm">
                                                    <i class="bi bi-arrow-clockwise"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/static/js/pages/datatables.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets/static/ajax/inventory/inventory-record.js') }}"></script>
    <script>
        $('.sale-select-2').select2({
            placeholder: 'New product',
            dropdownParent: '#store-sale-modal'
        });
    </script>
    <script src="{{ asset('js/sales/sales-restore.js') }}"></script>
    <script src="{{ asset('js/sales/quick-sale-restore.js') }}"></script>
@endsection
