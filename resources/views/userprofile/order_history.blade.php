@extends('userprofile.layout.userProfile')

@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
@endsection

@section('css')
    <style>
        .btn {
            font-weight: 600;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
@endsection

@section('title', 'Order History')
@section('page_title', 'Order History')
@section('page_gm', 'Your Orders')


@section('content')
    <div class="card shadow p-3">
        <div class="card-body">
            <h1>Your Order History</h1>

            @if ($orders->isEmpty())
                <p>No orders found.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>{{ $order->total }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>
                                    <button class="btn btn-info" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#orderItems_{{ $order->order_id }}">
                                        View Items
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <div id="orderItems_{{ $order->order_id }}" class="collapse">
                                        <table class="table table-sm">
                                            <thead>
                                                <tr>
                                                    <th>Product ID</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    <tr>
                                                        <td>{{ $item->product_id }}</td>
                                                        <td>{{ $item->quantity }}</td>
                                                        <td>{{ $item->subtotal }}</td>
                                                        <td>{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
