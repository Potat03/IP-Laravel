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
        <form id="payment_form" method="POST" action="">
            <div class="mb-3 bottom-outline-div" >
                <label class="form-label">Delivery Details</label>
                <div class="row input-layout">
                    <div class="col">
                        <input type="text" id="input_firstname" class="form-control" name="first_name" placeholder="First name" value="Tan">
                    </div>
                    <div class="col">
                        <input type="text" id="input_lastname" class="form-control" name="last_name" placeholder="Last name" value="Wei Ming">
                    </div>
                </div>

                <input type="text" class="form-control input-layout" name="delivery_address"id="input_deliveryaddress"
                     placeholder="Delivery Address" value="123, jalan 123">

            </div>
            <div class="mb-3 bottom-outline-div">
                <label class="form-label">Contact Information</label>
                <input type="text"  class="form-control input-layout" id="input_email" name="email" placeholder="Email" value="example@example.com">
                <input type="text" class="form-control input-layout" id="input_phonenumber" name="phone_number" placeholder="Phone Number" value="0123456789">

            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Card Details</label>
                <input type="text" class="form-control input-layout" id="input_nameoncard" name="name_on_card" placeholder="Name on Card" value="John Doe">
                <input name="card_number" type="text" class="form-control input-layout" id="input_cardnumber"  name="card_number"  placeholder="Card Number" value="1234123412341234">
                <div class="row">
                    <div class="col">
                        <input type="text" class="form-control input-layout" id="input_ccv"
                            style="display:inline-block;flex-grow: 1!important" name="ccv" placeholder="CVV" value="123">
                    </div>
                    <div class="col">
                        <input type="text" class="form-control input-layout" id="input_mmyy"
                            style="display:inline-block; flex-grow: 1!important" name="expiry_date"  placeholder="MM/YY" value="11/25">
                    </div>
                </div>


            </div>


            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success" >Checkout</button>
            </div>
        </form>
    </div>

</body>

</html>

<script>
     form = document.getElementById('payment_form');

form.addEventListener('submit', function(e) {
    e.preventDefault();
        
        let formData = new FormData(form);

        fetch('/api/checkout', {
                method: 'POST',
                body: formData 
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Upload Success');
                } else {
                    alert('Upload Failed');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while send the payment to the controller.');
            });
          
    });

   


    function validateForm() {
        // event.preventDefault(); // Prevent form from submitting automatically

        // // Get input elements
        // var firstName = document.getElementById('input_firstname').value.trim();
        // var lastName = document.getElementById('input_lastname').value.trim();
        // var deliveryAddress = document.getElementById('input_deliveryaddress').value.trim();
        // var email = document.getElementById('input_email').value.trim();
        // var phoneNumber = document.getElementById('input_phonenumber').value.trim();
        // var nameOnCard = document.getElementById('input_nameoncard').value.trim();
        // var cardNumber = document.getElementById('input_cardnumber').value.trim();
        // var ccv = document.getElementById('input_ccv').value.trim();
        // var expiryDate = document.getElementById('input_mmyy').value.trim();

        // // Patterns for validation
        // var namePattern = /^[a-zA-Z\s]+$/;  // Only letters and spaces
        // var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;  // Email validation
        // var phonePattern = /^[0-9]{10,15}$/;  // Only numbers (10-15 digits)
        // var cardNumberPattern = /^[0-9]{16}$/;  // 16 digits for card number
        // var ccvPattern = /^[0-9]{3,4}$/;  // 3 or 4 digits for CVV
        // var expiryDatePattern = /^(0[1-9]|1[0-2])\/[0-9]{2}$/;  // MM/YY format for expiry date

        // // Validations
        // if (!namePattern.test(firstName)) {
        //     alert('First name must contain only letters and spaces');
        //     return false;
        // }

        // if (!namePattern.test(lastName)) {
        //     alert('Last name must contain only letters and spaces');
        //     return false;
        // }

        // if (deliveryAddress === "") {
        //     alert('Delivery address cannot be empty');
        //     return false;
        // }

        // if (!emailPattern.test(email)) {
        //     alert('Please enter a valid email address');
        //     return false;
        // }

        // if (!phonePattern.test(phoneNumber)) {
        //     alert('Phone number must contain only numbers (10 to 15 digits)');
        //     return false;
        // }

        // if (!namePattern.test(nameOnCard)) {
        //     alert('Name on card must contain only letters and spaces');
        //     return false;
        // }

        // if (!cardNumberPattern.test(cardNumber)) {
        //     alert('Card number must be 16 digits long');
        //     return false;
        // }

        // if (!ccvPattern.test(ccv)) {
        //     alert('CVV must be 3 or 4 digits');
        //     return false;
        // }

        // if (!expiryDatePattern.test(expiryDate)) {
        //     alert('Expiry date must be in MM/YY format');
        //     return false;
        // }

        // alert('Form is valid!');
        // If all validations pass, submit the form (or perform further processing)
    }

  

</script>