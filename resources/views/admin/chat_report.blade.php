@extends('admin.layout.main')

@section('title', 'Chat Report')

@section('css')
<link href="{{ asset('css/chat_report.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection


@section('page_title', 'Customer Service Performance Report')
@section('page_gm', 'Check on the performance of the customer service team')

@section('content')
<div class="report_content_wrap">
    <div class="report_content_scroll">
        <div class="report_header_wrap">
            <h6 id="report_title">Overall Summary</h6>
            <div class="option_group">
                <label for="admin_select">Select a user</label>
                <select name="admin" id="admin_select">
                    <option value="0">All</option>
                    <option value="1">Thiam Wei</option>
                    <option value="2">Thiam Cai</option>
                    <option value="3">Thiam Kai</option>
                </select>
            </div>
        </div>
        <div class="report_body_warp">
            <div class="report_body_content_wrap">
                <div class="content_wrap_1">
                    <div class="chat_rating">
                        <canvas id="chat_rating_chart"></canvas>
                    </div>
                </div>
                <div class="content_wrap_2">
                    <div class="small_content">
                        <p>Total Chat</p>
                        <h6>100</h6>
                    </div>
                    <div class="small_content">
                        <p>Average Chat Duration</p>
                        <h6>2<span>(min)</span></h6>
                    </div>
                    <div class="small_content">
                        <p>Average Rating</p>
                        <h6>2 <span>out of 5</span></h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection

@section('js')
<script>
    //create a bar chart using jquery
    $(document).ready(function() {
        var ctx = document.getElementById('chat_rating_chart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['1', '2', '3', '4', '5'],
                datasets: [{
                    label: 'Total Chat',
                    data: [12, 19, 3, 5, 2],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)', // Rating 1 - Red
                        'rgba(255, 159, 64, 0.2)', // Rating 2 - Orange
                        'rgba(255, 205, 86, 0.2)', // Rating 3 - Yellow
                        'rgba(130, 224, 143, 0.2)', // Rating 4 - Light Green
                        'rgba(64, 207, 83, 0.2)' // Rating 5 - Green
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)', // Rating 1 - Red
                        'rgba(255, 159, 64, 1)', // Rating 2 - Orange
                        'rgba(255, 205, 86, 1)', // Rating 3 - Yellow
                        'rgba(130, 224, 143, 1)', // Rating 4 - Light Green
                        'rgba(64, 207, 83, 1)' // Rating 5 - Green
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
                            text: 'Chat Count', // Label for y-axis
                            font: {
                                size: 14
                            },
                            color: '#666'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Rating', // Label for x-axis
                            font: {
                                size: 14
                            },
                            color: '#666'
                        }
                    }
                },
                plugins: {
                    title: {
                        display: true, // Set to true to display the title
                        text: 'Customer Chat Ratings', // Title text
                        font: {
                            size: 18 // Font size of the title
                        },
                        align: 'center', // Align the title to the center (default)
                        color: '#000' // Color of the title text
                    }
                }
            }
        });
    });
</script>
@endsection