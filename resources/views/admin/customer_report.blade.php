@extends('admin.layout.main')
<!-- Loo Wee Kiat -->
@push('report', 'class="active"')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js','resources/js/bootstrap.js'])
@endsection

@section('title', 'Customer Report')
@section('page_title', 'Reports')
@section('page_gm', 'Customer report')

@section('css')
<style>

</style>
@endsection

@section('content')
<div class="d-flex align-items-center ps-1 py-2">
    <h1>Customer Report</h1>
    <div class="ms-auto">
        <a href="{{ route('admin.customer.generateXML') }}" class="btn btn-primary me-2">Download XML</a>
        <button id="viewXsltReport" class="btn btn-secondary">View XSLT Report</button>
    </div>
</div>

<div id="reportContainer" class="mt-4">

</div>
@endsection

@section('js')
<script>
    document.getElementById('viewXsltReport').addEventListener('click', function () {
        fetch("{{ route('admin.customer.generateXSLT') }}")
            .then(response => response.text())  
            .then(data => {
                document.getElementById('reportContainer').innerHTML = data;
            })
            .catch(error => console.error('Error fetching the XSLT report:', error));
    });
</script>
@endsection

