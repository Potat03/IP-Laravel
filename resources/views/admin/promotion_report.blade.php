@extends('admin.layout.main')

@push('report', 'class="active"')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css','resources/js/bootstrap.js'])
@endsection

@section('title', 'Promotion Report')
@section('page_title', 'Reports')
@section('page_gm', 'Promotion report')

@section('css')
<style>
    table {
        width: 100%;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        margin: 20px 0;
        font-size: 16px;
        text-align: left;
    }

    th,
    td {
        padding: 12px 15px;
        border: 1px solid #ddd;
    }

    thead th {
        background-color: var(--darkblue);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    tbody tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tbody tr:hover {
        background-color: var(--blue);
    }

    tbody tr:hover td {
        color: white;
    }


    tbody td {
        color: #333;
    }

    tbody td {
        text-align: center;
    }

    tbody tr td:first-child {
        font-weight: bold;
    }

    table caption {
        margin-bottom: 10px;
        font-size: 18px;
        font-weight: bold;
        color: #333;
    }
</style>
@endsection

@section('content')
<div class="d-flex align-items-center ps-1 py-2">
    <h1>Promotion Performance Report</h1>
    <div class="ms-auto">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#chartModal">Show Chart</button>
        
        <button class="btn btn-primary ms-auto" onclick="window.location.href=`{{ route('admin.promotion.report.download') }}`">Download Report</button>
    </div>
</div>
<div class="modal fade" id="chartModal" tabindex="-1" aria-labelledby="#chartModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Report Chart</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div id="revenue" style="width: 100%; height: 200px;"></div>
      <div id="totalSold" style="width: 100%; height: 200px;"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div id="reportContainer"></div>

@endsection

@section('js')
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script  type="text/javascript" defer>
    
    google.charts.load('current', {packages: ['corechart','bar']});
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Promotion', 'Revenue'],
            @foreach($promotions as $promotion)
            ['{{ $promotion->title }}', {{ $promotion->total_revenue }}],
            @endforeach
        ]);

        var options = {
            title: 'Promotion Performance Report',
            chartArea: {width: '50%'},
            hAxis: {
                title: 'Total Sales',
                minValue: 0
            },
            vAxis: {
                title: 'Promotion'
            }
        };

        var chart = new google.visualization.BarChart(document.getElementById('revenue'));

        chart.draw(data, options);

        var data2 = google.visualization.arrayToDataTable([
            ['Promotion', 'Total Sold'],
            @foreach($promotions as $promotion)
            ['{{ $promotion->title }}', {{ $promotion->products_sold }}],
            @endforeach
        ]);

        var options2 = {
            title: 'Promotion Performance Report',
            chartArea: {width: '50%'},
            hAxis: {
                title: 'Total Sold',
                minValue: 0
            },
            vAxis: {
                title: 'Promotion'
            }
        };

        var chart2 = new google.visualization.BarChart(document.getElementById('totalSold'));

        chart2.draw(data2, options2);
    }

    $(document).ready(function() {
        
        let html = `{!! $html !!}`;
        document.getElementById('reportContainer').innerHTML = html;
    });
</script>
@endsection