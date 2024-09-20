@extends('layout.shop')

@section('title', 'Cart')

@push('styles')
@vite(['resources/css/general.css'])
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .input-layout {
        margin-bottom: 1.5%;
    }

    .flex-container {
        display: flex;
        align-items: stretch;
    }

    .tracking-page-btn {
        flex-grow: 1;
        background-color: transparent;
        color: black;
        border: none;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .tracking-page-btn:hover {
        background-color: #b90f0f;
        color: white;
    }

    .tracking-page-btn-active {
        border-bottom: #b90f0f 5px solid;
    }

    p {
        margin-bottom: 0;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateX(100%);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    .animate-row {
        animation: slideIn 0.5s ease-out;
    }
</style>
@endpush

@section('content')
    <div class="container-xl content-div" style="margin-bottom: 2%;height:fit-content;">
        <div class="d-flex justify-content-between" style="margin-bottom:0.5%">
            <button type="button" class="btn tracking-page-btn tracking-page-btn-active" id="allBtn"
                onclick="filterRows('all',this)">All</button>
            <button type="button" class="btn tracking-page-btn" id="toShipBtn" onclick="filterRows('prepare',this)">To Ship</button>
            <button type="button" class="btn tracking-page-btn" id="toReceiveBtn" onclick="filterRows('delivery',this)">To Receive</button>
            <button type="button" class="btn tracking-page-btn" id="completedBtn" onclick="filterRows('delivered',this)">Completed</button>
        </div>
        <div class="container">
            <table class="table">
                <tbody>
                    <tr class="th">
                        <th style="width:10%;text-align:left!important">ORDER ID</th>
                        <th style="width:18%;text-align:left!important;">DELIVERY ADDRESS</th>
                        <th style="width:12%;text-align:left!important;">TOTAL</th>
                        <th style="width:12%;text-align:left!important;">CREATED AT</th>
                        <th style="width:12%;text-align:left!important;">UPDATED AT</th>
                        <th style="width:18%;text-align:left!important;">TRACKING NUMBER</th>
                        <th style="width:12%;text-align:left!important;">RECEIVED</th>
                        <th style="width:15%;text-align:left!important;">STATUS</th>
                    </tr>
                    @if(count($orders) > 1)
                    @php
                    $x = 1;
                    @endphp
                    @foreach($orders as $order)
                    @if($order->status == 'prepare')
                        <tr class="animate-row prepare" style="animation-delay: 0.05s * {{ $x }};">
                            <td style="text-align:left!important">{{ $order->order_id }}</td>
                            <td style="text-align:left!important;">{{ $order->delivery_address }}</td>
                            <td style="text-align:left!important;">RM {{ $order->total }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->updated_at)->format('d-m-Y h:iA') }}</td>
                            <td style="text-align:left!important;">-</td>
                            <td style="text-align:left!important;">
                                <button disabled type="button" class="btn btn-primary">RECEIVE</button>
                            </td>
                            <td style="text-align:right!important;"><button disabled type="button" class="btn btn-primary">PREPARE</button></td>
                        </tr>
                    @elseif($order->status =="delivery")
                        <tr class="animate-row delivery" style="animation-delay: 0.05s * {{ $x }};">
                            <td style="text-align:left!important">{{ $order->order_id }}</td>
                            <td style="text-align:left!important;">{{ $order->delivery_address }}</td>
                            <td style="text-align:left!important;">RM {{ $order->total }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->updated_at)->format('d-m-Y h:iA') }}</td>

                            <td style="text-align:left!important;">{{ $order->tracking_number }}</td>
                            <td style="text-align:left!important;">
                                @if($order->received)
                                <button id="receiveButton_2" type="button" class="btn btn-success" onclick="receiveOrder(2)" disabled="">RECEIVED</button>
                                @else
                                <button disabled type="button" class="btn btn-primary">RECEIVE</button>
                                @endif
                            </td>
                            <td style="text-align:right!important;"><button disabled type="button" class="btn btn-primary">DELIVERY</button></td>
                        </tr>
                    @elseif($order->status =="delivered")
                        <tr class="animate-row delivered" style="animation-delay: 0.05s * {{ $x }};">
                            <td style="text-align:left!important">{{ $order->order_id }}</td>
                            <td style="text-align:left!important;">{{ $order->delivery_address }}</td>
                            <td style="text-align:left!important;">RM {{ $order->total }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                            <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->updated_at)->format('d-m-Y h:iA') }}</td>

                            <td style="text-align:left!important;">{{ $order->tracking_number }}</td>
                            <td style="text-align:left!important;">
                                @if($order->received)
                                <button id="receiveButton_2" type="button" class="btn btn-success" onclick="receiveOrder(2)" disabled="">RECEIVED</button>
                                @else
                                <button id="receiveButton_{{$order->order_id}}"type="button" class="btn btn-primary" onclick="receiveOrder({{$order->order_id}})">RECEIVE</button>
                                @endif 
                            </td>
                            <td style="text-align:right!important;"><button disabled type="button" class="btn btn-primary">DELIVERED</button></td>
                        </tr>
                    @endif
                    @endforeach
                    @else
                    <tr>
                        <td colspan="8">
                        <p style="width:100%;text-align:center;height:100%; display: flex;justify-content: center;align-items: center;">No Orders</p>
                        </td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection

<script>
    function setActive(clickedButton) {
        const buttons = document.querySelectorAll('.btn.tracking-page-btn');
        buttons.forEach(button => button.classList.remove('tracking-page-btn-active'));

        clickedButton.classList.add('tracking-page-btn-active');
    }

    function filterRows(status,clickedButton) {
        const rows = document.querySelectorAll('tr');

        rows.forEach(row => {
            if (status === 'all') {
                row.style.display = '';
            } else if (row.classList.contains(status)) {
                row.style.display = '';
            }else if (row.classList.contains("th")) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Update active button
      setActive(clickedButton);
    }

    function receiveOrder(id) {
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        var receiveButton = document.getElementById(`receiveButton_${id}`);
        receiveButton.disabled = true; // Disable the button
    receiveButton.classList.remove('btn-primary'); // Remove existing class
    receiveButton.classList.add('btn-success'); // Add new class
    receiveButton.textContent = 'RECEIVED'; // Optional: Change button text

    fetch(`/api/order/receive/${id}`, {
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
            } else {
                console.error('Error updating order');
            }
        })
        .catch(error => console.error('Error:', error));
   
}
</script>

