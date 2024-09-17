<!DOCTYPE html>
<html lang="en">

<head>
    {{-- communication security --}}
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


    </nav>



    <div class="container-xl content-div">
        <div class="d-flex justify-content-between" style="margin-bottom:0.5%">
            <button type="button" class="btn tracking-page-btn tracking-page-btn-active"
                onclick="setActive(this)">All</button>
            <button type="button" class="btn tracking-page-btn" onclick="setActive(this)">To Ship</button>
            <button type="button" class="btn tracking-page-btn" onclick="setActive(this)">To Receive</button>
            <button type="button" class="btn tracking-page-btn" onclick="setActive(this)">Completed</button>
        </div>
        <div class="container">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width:10%;text-align:left!important">ORDER ID</th>
                        <th style="width:30%;text-align:left!important;">DELIVERY ADDRESS</th>
                        <th style="width:15%;text-align:left!important;">TOTAL</th>
                        <th style="width:20%;text-align:left!important;">CREATED AT</th>
                        <th style="width:15%;text-align:left!important;">TRACKING NUMBER</th>
                        <th style="width:15%;text-align:right!important;">STATUS</th>
                    </tr>
            
                    
                    @if(count($orders) > 0)
                    @php
                    $x = 1;
                @endphp
                @foreach($orders as $order)
                @if($order->status == 'prepare')
                    <tr class="animate-row" style="animation-delay:'. 0.05 * $x .'s;">
                        <td style="text-align:left!important">
                           {{$order->order_id}}
                        </td>
                        <td style="text-align:left!important;">
                           {{$order->delivery_address}}
                        </td>
                        <td style="text-align:left!important;">
                           RM {{$order->total}}
                        </td>
                        <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                        <td style="text-align:left!important;">-</td>
                        <td style="text-align:right!important;"><button type="button" class="btn btn-secondary">PREPARE</button></td>
                    </tr>
                @elseif($order->status =="delivery")
                <tr class="animate-row" style="animation-delay:'. 0.05 * $x .'s;">
                    <td style="text-align:left!important">
                       {{$order->order_id}}
                    </td>
                    <td style="text-align:left!important;">
                       {{$order->delivery_address}}
                    </td>
                    <td style="text-align:left!important;">
                       RM {{$order->total}}
                    </td>
                    <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                    <td style="text-align:left!important;">{{$order->tracking_number}}</td>
                    <td style="text-align:right!important;"><button type="button" class="btn btn-secondary">DELIVERY</button></td>
                </tr>
                @elseif($order->status =="delivered")
                <tr class="animate-row" style="animation-delay:'. 0.05 * $x .'s;">
                    <td style="text-align:left!important">
                       {{$order->order_id}}
                    </td>
                    <td style="text-align:left!important;">
                       {{$order->delivery_address}}
                    </td>
                    <td style="text-align:left!important;">
                       RM {{$order->total}}
                    </td>
                    <td style="text-align:left!important;">{{ \Carbon\Carbon::parse($order->created_at)->format('d-m-Y h:iA') }}</td>
                    <td style="text-align:left!important;">{{$order->tracking_number}}</td>
                    <td style="text-align:right!important;"><button type="button" class="btn btn-secondary">DELIVERED</button></td>
                </tr>
                @endif
                @endforeach

                    @endif



                </tbody>

            </table>
        </div>
    </div>

</body>

</html>
{{-- <tr class="animate-row" style="animation-delay:'. 0.05 * $x .'s;">
    <td style="width:15%;text-align:left!important">
    {{$order->order_id}}
    </td>
    <td style="width:55%;text-align:left!important;vertical-align:top">
        <p>Pokemon Card</p>
        <p>RM8.00</p>
        <p>x1</p>
    </td>
    <td style="width:15%;">Total: RM8.00</td>
    <td style="width:15%;"><button type="button" class="btn btn-secondary">STATUS</button></td>
</tr> --}}
<script>
function setActive(clickedButton) {
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(button => button.classList.remove('tracking-page-btn-active'));

    clickedButton.classList.add('tracking-page-btn-active');
}

    // This function will be triggered to fetch the orders in JSON format
    // function fetchOrders() {
    //     fetch('/tracking', { // Adjust the URL to match your route
    //         method: 'GET',
    //         headers: {
    //             'Accept': 'application/json'  // Expect JSON response
    //         }
    //     })
    //     .then(response => response.json())  // Parse the JSON response
    //     .then(data => {
    //         console.log('Orders:', data);  // You can see the response in the console
    //     })
    //     .catch(error => {
    //         console.error('Error fetching orders:', error);
    //     });
    // }

    // // Call the function (e.g., after page load)
    // fetchOrders();


</script>