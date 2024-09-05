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
    .bottom-outline-div{
    border-bottom: 1px solid #d3d3d3fa;
    margin-bottom: 1%;
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
        <form>
            <div class="mb-3 bottom-outline-div" >
                <label class="form-label">Delivery Details</label>
                <div class="row input-layout">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="First name">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Last name">
                    </div>
                </div>

                <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Delivery Address">

            </div>
            <div class="mb-3 bottom-outline-div">
                <label class="form-label">Contact Information</label>
                <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Email">
                <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                aria-describedby="emailHelp" placeholder="Phone Number">

            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Card Details</label>
                <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Name on Card">
                <input name="card_number" type="text" class="form-control input-layout" id="exampleInputEmail1"
                    aria-describedby="emailHelp" placeholder="Card Number">
                <div class="row">
                    <div class="col">

                        <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                            style="display:inline-block;flex-grow: 1!important" aria-describedby="emailHelp"
                            placeholder="CVV">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control input-layout" id="exampleInputEmail1"
                            style="display:inline-block; flex-grow: 1!important" aria-describedby="emailHelp"
                            placeholder="MM/YY">
                    </div>
                </div>


            </div>


            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success">Checkout</button>
            </div>
    </div>

</body>

</html>
<