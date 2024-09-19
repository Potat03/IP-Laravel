<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss','resources/js/app.js','resources/css/general.css'])
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
</head>

<body>
    <nav class="navbar navbar-expand-lg nav-bar justify-content-between">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="/docs/4.0/assets/brand/bootstrap-solid.svg" width="30" height="30" alt=""
                    class="d-inline-block align-text-top">
                <h2 class="text-white d-inline-block" style="vertical-align: middle;margin-left:3%;">Futatabi</h2>
            </a>
            <div class="d-flex navbar">
                <form>
                    <div class="input-group mb-3" style="margin:0px!important;">
                        <input type="text" class="form-control" placeholder="Product Name"
                            aria-label="Recipient's username" aria-describedby="button-addon2">
                        <button class="btn" type="button" id="button-addon2" style="background-color:white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0">
                                </path>
                            </svg>
                        </button>
                    </div>
                </form>

                <div class="navbar-nav">
                    <a class="nav-link active text-white" aria-current="page" href="#">Home</a>
                    <a class="nav-link text-white" href="#">Product</a>
                    <a class="nav-link text-white" href="{{ url('/cart') }}">Cart</a>
                    <a class="nav-link disabled text-white" aria-disabled="true">Profile</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-xl content-div">
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
                        <th style="width:8%;text-align:left!important">ORDER ID</th>
                        <th style="width:20%;text-align:left!important;">DELIVERY ADDRESS</th>
                        <th style="width:15%;text-align:left!important;">TOTAL</th>
                        <th style="width:12%;text-align:left!important;">CREATED AT</th>
                        <th style="width:12%;text-align:left!important;">UPDATED AT</th>
                        <th style="width:15%;text-align:left!important;">TRACKING NUMBER</th>
                        <th style="width:12%;text-align:left!important;">RECEIVED</th>
                        <th style="width:15%;text-align:right!important;">STATUS</th>
                    </tr>

                    @if(count($orders) > 0)
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
                                <button disabled type="button" class="btn btn-primary">RECEIVE</button>
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
                                <button id="receiveButton_{{$order->order_id}}"type="button" class="btn btn-primary" onclick="receiveOrder({{$order->order_id}})">RECEIVE</button>
                            </td>

                            <td style="text-align:right!important;"><button disabled type="button" class="btn btn-primary">DELIVERED</button></td>
                        </tr>
                    @endif
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

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
            var receiveButton = document.getElementById(`receiveButton_${id}`);
            receiveButton.disabled = true; // Disable the button
        receiveButton.classList.remove('btn-primary'); // Remove existing class
        receiveButton.classList.add('btn-success'); // Add new class
        receiveButton.textContent = 'RECEIVED'; // Optional: Change button text
    
        fetch(`/api/order/receive/${id}`, {
                method: 'POST',
               
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
</body>

</html>
