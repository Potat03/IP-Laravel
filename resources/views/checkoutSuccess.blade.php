@extends('layout.shop')
{{-- Author: Tan Wei Siang --}}

@section('title', 'Cart')

@push('styles')
@vite(['resources/css/general.css'])
@endpush

@section('content')
 

    <div class="container-xl content-div" style="margin-bottom:6%;height:fit-content;">
        <p class="h2">Checkout Success<i class="fa fa-check-circle" aria-hidden="true" style="color: green;"></i></p>
        <p>Thank you for your purchase, {{ $first_name }} {{ $last_name }}!</p>

        <p class='h5'>Delivery Details:</p>
        <p>Address: {{ $delivery_address }}</p>
        <p>Email: {{ $email }}</p>
        <p>Phone Number: {{ $phone_number }}</p>

        <p class='h5'>Order Summary:</p>
        <p>Order ID: {{ $order->order_id }}</p>
        <p>Subtotal: RM {{ $order->subtotal }}</p>
        <p>Total Discount: RM {{ $order->total_discount }}</p>
        <p>Total: RM {{ $order->total }}</p>

        Press here <a href="{{ url('/') }}" style="color: blue; text-decoration: underline;">"Go to Home"</a>

        
    </div>

  


@endsection

<script>

</script>