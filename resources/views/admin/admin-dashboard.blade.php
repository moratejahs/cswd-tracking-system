@extends('layout.admin-panel')

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}">
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
@endsection

@section('content')
    <div class="page-content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Assistants Progress Report
                    </div>
                    <div class="card-body">
                        <div id="lineChart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'line',
                    height: 350
                },
                series: [{
                        name: "Done",
                        data: {!! json_encode($doneData) !!} // Inject dynamic values
                    },
                    {
                        name: "Pending",
                        data: {!! json_encode($pendingData) !!} // Inject dynamic values
                    }
                ],
                colors: ['#198754', '#dc3545'], // Bootstrap success (green) and danger (red)
                xaxis: {
                    categories: {!! json_encode($allMonths) !!} // Inject dynamic month labels
                },
                stroke: {
                    curve: 'smooth'
                },
                markers: {
                    size: 4
                },
                legend: {
                    position: 'top'
                }
            };

            var chart = new ApexCharts(document.querySelector("#lineChart"), options);
            chart.render();
        });
    </script>
@endsection
