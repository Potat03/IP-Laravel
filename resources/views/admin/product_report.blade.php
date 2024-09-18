@extends('admin.layout.main')

@push('report', 'class="active"')

@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
@endsection

@section('prev_page', route('admin.promotion'))
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
    <div id="reportContainer"></div>
@endsection

@section('js')
    <script type="text/javascript" defer>
        $(document).ready(function() {
            let html = `{!! $html !!}`;
            document.getElementById('reportContainer').innerHTML = html;
        });
    </script>
@endsection
