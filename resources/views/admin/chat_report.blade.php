@extends('admin.layout.main')

@section('title', 'Chat Report')

@section('css')
<link href="{{ asset('css/chat_report.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    function generateChart(data) {
        var ctx = document.getElementById('chat_rating_chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5'],
                datasets: [{
                    label: 'Total Chat',
                    data: data,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 205, 86, 0.2)',
                        'rgba(130, 224, 143, 0.2)',
                        'rgba(64, 207, 83, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(130, 224, 143, 1)',
                        'rgba(64, 207, 83, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Chat Count',
                            font: {
                                size: 14
                            },
                            color: '#666'
                        },
                        ticks: {
                            min: 1,
                            stepSize: 1,
                            //make sure no decimal
                            callback: function(value) {
                                return Number(value).toFixed(0);
                            }
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Rating',
                            font: {
                                size: 14
                            },
                            color: '#666'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Customer Chat Ratings',
                        font: {
                            size: 18
                        },
                        align: 'center',
                        color: '#000'
                    }
                }
            }
        });
    }
</script>
@endsection


@section('page_title', 'Customer Service Performance Report')
@section('page_gm', 'Check on the performance of the customer service team')

@section('content')
<div class="report_content_wrap">
    <div class="report_content_scroll">
        <div class="report_header_wrap">
            <h6 id="report_title">Overall Summary</h6>
            <div class="option_group">
                <label for="date_select">Month</label>
                <input type="month" name="date" id="date_select">
            </div>
            <div class="option_group">
                <label for="admin_select">Select a user</label>
                <select name="admin" id="admin_select">
                    <option value="0" default>All</option>
                    @foreach ($admin_list as $admin)
                    <option value="{{ $admin->admin_id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="report_body_warp" id="report_append_zone">
            @if ($report_html != null)
            {!! $report_html !!}
            @endif
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        // make the date select default to the current month
        const today = new Date();
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0');
        const formattedDate = `${year}-${month}`;
        $('#date_select').val(formattedDate);

        $('#admin_select').change(function() {
            updateReport();
        });

        $('#date_select').change(function() {
            updateReport();
        });
    });

    function updateReport() {
        var admin_id = $('#admin_select').val();
        var date = $('#date_select').val();
        $.ajax({
            url: "{{ route('admin.chat_report') }}",
            type: 'POST',
            data: {
                admin_id: admin_id,
                year_month: date,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                $('#report_append_zone').html(data['html']);
                $('#report_title').text($('#admin_select option:selected').text() + ' Summary');
            }
        });
    }
</script>
@endsection