@extends('Customer.Supplier.head')

@section('content')
<div class="wrapper">
    @include('Customer.Supplier.header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Income Report</h3>
            </div>
            
            <!-- Date Range Picker -->
            <form action="{{ route('seller.incomeReport') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <input type="date" name="start_date" class="form-control" value="{{ $startDate->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <input type="date" name="end_date" class="form-control" value="{{ $endDate->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Generate Report</button>
                    </div>
                </div>
            </form>

            <!-- Income Chart -->
            @if(isset($chartData) && count($chartData['labels']) > 0)
                <div id="chart" style="max-height: 350px;"></div>

                <div class="mt-4">
                    <table class="table table-bordered">
                        <thead>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>Selected Date Range</strong></td>
                                <td>{{ $startDate->format('Y-m-d') }} to {{ $endDate->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Total Income</strong></td>
                                <td>Rs. {{ number_format($totalIncome, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Single Download Button -->
                <div class="mb-3">
                    <button class="btn btn-primary" onclick="downloadIncomeReport()">Download Income Report</button>
                </div>

            @else
                <p>No data available for the selected date range.</p>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.24/jspdf.plugin.autotable.min.js"></script>

<script>
    @if(isset($chartData) && count($chartData['labels']) > 0)
        var chartData = @json($chartData);

        var options = {
            series: [{
                name: "Income",
                data: chartData.values
            }],
            chart: {
                type: 'area',
                height: 350,
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth'
            },
            labels: chartData.labels,
            xaxis: {
                type: 'datetime',
            },
            yaxis: {
                opposite: true
            },
            legend: {
                horizontalAlign: 'left'
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        function downloadIncomeReport() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();

    doc.setFontSize(18); 
    doc.text("Income Report", 105, 20, null, null, 'center'); 

    doc.setLineWidth(0.5);
    doc.line(10, 25, 200, 25);

    chart.dataURI().then(function (uri) {
        const chartWidth = document.querySelector("#chart").clientWidth;
        const chartHeight = document.querySelector("#chart").clientHeight;
        const scaleFactor = 180 / chartWidth;
        const imgWidth = 180;
        const imgHeight = chartHeight * scaleFactor;

        doc.addImage(uri.imgURI, 'PNG', 10, 30, imgWidth, imgHeight);

        const table = document.querySelector('table');
        doc.autoTable({ 
            html: table, 
            startY: imgHeight + 40,
            margin: { top: 10 }
        });

        doc.save('income_report.pdf');
    });
}

    @endif
</script>
@endsection
