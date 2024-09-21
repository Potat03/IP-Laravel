@extends('admin.layout.main')
{{-- Author: Tan Wei Siang --}}

@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('css')
    <style>
        .btn {
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div>
        <div class="px-2 py-3">
            <h1>Orders</h1>
            <div class="nav-status text-muted fw-bold">Home > Orders</div>
        </div>
    </div>
    <div class="card shadow-sm p-3">
        <div class="card-body">
            <div class="card-title d-flex px-3">
                <div class="ms-auto">
                        <button disabled class="btn btn-primary">
                            <i class="fa-regular fa-square-plus pe-2"></i>Prepare
                        </button>                    
                        <button class="btn btn-primary" onclick="location.href='{{url('/admin/orders/delivery')}}'">
                            <i class="fa-regular fa-square-plus pe-2"></i>Delivery
                        </button>
                        <button class="btn btn-primary" onclick="location.href='{{url('/admin/orders/delivered')}}'">
                            <i class="fa-regular fa-square-plus pe-2"></i>Delivered
                        </button>
                </div>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Delivery Address</th>
                        <th scope="col">Total</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Tracking Number</th>
                        <th scope="col">Receive</th>
                        <th scope="col">Status</th>
                        <th scope="col">To Next Status</th>
                    </tr>
                </thead>
                <tbody id="data-holder">
                    @if($orders != null)
                        @foreach($orders as $order)
                            <tr id="row_{{ $order->order_id }}" class="animate-row" style="animation-delay: 0.05s;">
                                <td style="text-align:left!important">{{ $order->order_id }}</td>
                                <td style="text-align:left!important;">{{ $order->delivery_address }}</td>
                                <td style="text-align:left!important;">RM {{ $order->total }}</td>
                                <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                                <td style="text-align:left!important;">{{ $order->tracking_number ?? '-' }}</td>
                                <td style="text-align:left!important;">{{ $order->rating ?? '-' }}</td>
                                <td style="text-align:left!important;">
                                    PREPARE                                  
                                </td>
                                <td>                                        
                                    <button type="button" class="btn btn-primary" onclick="proceedToNext({{ $order->order_id }})">&#10143; DELIVERY</button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection

<script>
    function proceedToNext(id) {
        var row = document.getElementById(`row_${id}`);
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/api/order/proceedToNext/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            // If you need to send additional data, include it in the body
            // body: JSON.stringify({ /* data */ })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Order updated successfully');
                row.remove();
            } else {
                console.error('Error updating order');
            }
        })
        .catch(error => console.error('Error:', error));
    }
    </script>
    
