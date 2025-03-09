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
                        Client Category Report
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
                    type: 'bar',
                    height: 350
                },
                series: [{
                    name: "Total",
                    data: [
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
                    ]
                }],
                colors: ['#3498db'], // Green for "Done"
                xaxis: {
                    categories: [
                        'San Isidro',
                        'Awasian',
                        'Bagong Lungsod',
                        'Bioto',
                        'Bongtod',
                        'Buenavista',
                        'Dagocdoc',
                        'Mabua',
                        'Mabuhay',
                        'Maitum',
                        'Maticdum',
                        'Pandanon',
                        'Pangi',
                        'Quezon',
                        'Rosario',
                        'Salvacion',
                        'San Agustin Norte',
                        'San Agustin Sur',
                        'San Antonio',
                        'San Jose',
                        'Telaje'
                    ]
                },
                plotOptions: {
                    bar: {
                        horizontal: false, // Vertical bar
                        columnWidth: '50%' // Adjust width for better visualization
                    }
                },
                dataLabels: {
                    enabled: true
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
