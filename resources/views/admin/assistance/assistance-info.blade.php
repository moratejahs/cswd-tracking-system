@extends('layout.admin-panel')

@section('links')
    <!-- DataTables CSS (if needed) -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.css') }}">
    <!-- Select2 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/extensions/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/select2-customize.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .page-header {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .breadcrumb {
            margin: 0;
            padding: 0;
        }

        .page-title {
            font-weight: 600;
            font-size: 1.5rem;
            color: #435ebe;
            border-bottom: 4px solid #435ebe;
            display: inline-block;
            padding-bottom: 5px;
        }

        .history-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .history-card:hover {
            transform: translateY(-5px);
        }

        .table {
            margin: 0;
        }

        .table thead th {
            background: #435ebe;
            color: white;
            border: none;
            padding: 15px;
            font-weight: 500;
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-color: #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
        }

        .amount-cell {
            font-weight: 600;
            color: #198754;
        }

        .purpose-cell {
            color: #6c757d;
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>
@endsection

@section('content')
    <div class="page-header">
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('index.home') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Service Records</li>
            </ol>
        </nav>
        <h1 class="page-title mt-2">Beneficiary History</h1>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card history-card">
                <div class="card-body p-0">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Purpose</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                            <tr>
                                <td>
                                    <span class="badge bg-primary">{{ $assitance->category }}</span>
                                </td>
                                <td class="amount-cell">
                                    ₱{{ number_format($assitance->amount, 2) }}
                                </td>
                                <td class="purpose-cell" title="{{ $assitance->purpose }}">
                                    {{ $assitance->purpose }}
                                </td>
                            </tr>
                            </tr>
                            @foreach ($histories as $history)
                                <tr>
                                    <td>
                                        <span class="badge bg-primary">{{ $history->category->description }}</span>
                                    </td>
                                    <td class="amount-cell">
                                        ₱{{ number_format($history->amount, 2) }}
                                    </td>
                                    <td class="purpose-cell" title="{{ $history->purpose }}">
                                        {{ $history->purpose }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
@endsection
