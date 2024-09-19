@extends('admin.layout.main')

@section('title', 'Chat Report')

@section('css')
<link href="{{ asset('css/chat_report.css') }}" rel="stylesheet">
@endsection


@section('page_title', 'Customer Service Performance Report')
@section('page_gm', 'Check on the performance of the customer service team')

@section('content')
<div class="report_content_wrap">
    <div class="report_header_wrap">
        <h6>Overall Summary</h6>
        <div class="option_group">
            <select name="admin" id="admin_select">
                <option value="0">All</option>
                <option value="1">Thiam Wei</option>
                <option value="2">Thiam Cai</option>
                <option value="3">Thiam Kai</option>
            </select>
        </div>
    </div>
    <div class="report_body_warp">
        <div class="report_content_wrap">
            
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    
</script>
@endsection