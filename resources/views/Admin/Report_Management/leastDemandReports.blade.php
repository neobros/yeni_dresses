@extends('Admin.head')
@section('content')

<div class="wrapper">
    @include('Admin.header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Reports</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="#">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="#">Least Demanding Report</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="/seller/itemManagement/reviewList">Report Details</a>
                    </li>
                </ul>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        @if (\Session::has('success'))
                        <div class="alert alert-success">
                            <strong>{{ \Session::get('success') }}</strong>
                        </div>
                        @endif
                        @if (\Session::has('delete'))
                        <div class="alert alert-danger">
                            <strong>{{ \Session::get('delete') }}</strong>
                        </div>
                        @endif
                        @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Most Demanding Report Section -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="fw-bold mb-3">Least Demanding Report</h4>

                            <!-- ApexCharts Pie Chart -->
                            <div id="apexChart" style="max-height: 400px;"></div>

                            <hr>
                            <div class="dropdown mb-3">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    Report Download Options
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <li><a class="dropdown-item" href="#" onclick="downloadReport()">Download Full Report</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="downloadChart()">Download Chart Only</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="downloadTable()">Download Table Only</a></li>
                                </ul>
                            </div>

                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Seller Name</th>
                                        <th>Item Name</th>
                                        <th>Ratings Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ratingsData as $index => $data)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $data->item->seller->name ?? 'N/A' }}</td>
                                            <td>{{ $data->item->name ?? 'N/A' }}</td>
                                            <td>{{ $data->ratings_count }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3">No data available</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End of Report Section -->
        </div>
    </div>
</div>

<!-- Include ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>

<script>
    const chartData = @json($chartData);

    var options = {
        series: chartData.values,
        chart: {
            type: 'donut',
            height: 400,
        },
        labels: chartData.labels,
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }],
        legend: {
            position: 'right'
        }
    };

    var chart = new ApexCharts(document.querySelector("#apexChart"), options);
    chart.render();

    // Download Chart 
    function downloadChart() {
        chart.dataURI().then(function (uri) {
            var a = document.createElement('a');
            a.href = uri.imgURI;
            a.download = 'chart.png';
            a.click();
        });
    }

   // Download Report 
    function downloadReport() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        chart.dataURI().then(function (uri) {
            const chartWidth = document.querySelector("#apexChart").clientWidth;
            const chartHeight = document.querySelector("#apexChart").clientHeight;

            const scaleFactor = 180 / chartWidth; 
            const imgWidth = 180;
            const imgHeight = chartHeight * scaleFactor; 

            doc.addImage(uri.imgURI, 'PNG', 10, 10, imgWidth, imgHeight);

            const table = document.querySelector('table');
            doc.autoTable({ html: table, startY: imgHeight + 20 }); 

            doc.save('report.pdf');
        });
    }


    // Download Table 
    function downloadTable() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        const table = document.querySelector('table');
        
        doc.autoTable({ html: table });

        doc.save('table_report.pdf');
    }
</script>

@endsection
