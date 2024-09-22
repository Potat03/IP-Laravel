@extends('userprofile.layout.userProfile')
<!-- Loo Wee Kiat -->
@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js'])
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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total</th>
                            <th>Delivery Address</th>
                            <th>Status</th>
                            <th>Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->created_at->format('d-m-Y') }}</td>
                                <td>{{ number_format($order->total, 2) }}</td>
                                <td>{{ $order->delivery_address }}</td>
                                <td>{{ ucfirst($order->status) }}</td>
                                <td>
                                    <button class="btn btn-danger" type="button" data-bs-toggle="collapse"
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
                                                    <th>Product Name</th>
                                                    <th>Description</th>
                                                    <th>Quantity</th>
                                                    <th>Subtotal</th>
                                                    <th>Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->orderItems as $item)
                                                    @if($item->product)
                                                        <tr>
                                                            <td>{{ $item->product->name }}</td>
                                                            <td>{{ $item->product->description }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($item->subtotal, 2) }}</td>
                                                            <td>{{ number_format($item->total * $item->quantity, 2) }}</td>
                                                        </tr>
                                                    @elseif($item->promotion)
                                                        <tr>
                                                            <td>{{ $item->promotion->title }}</td>
                                                            <td>{{ $item->promotion->description }}</td>
                                                            <td>{{ $item->quantity }}</td>
                                                            <td>{{ number_format($item->subtotal, 2) }}</td>
                                                            <td>{{ number_format($item->total * $item->quantity, 2) }}</td>
                                                        </tr>
                                                    @endif
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
