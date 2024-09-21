@extends('layout.shop')
{{-- Author: Tan Wei Siang --}}

@section('title', 'Promotion')

@push('styles')
@vite(['resources/css/general.css'])
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    

    .custom-confirm-button {
        background-color: black; /* Black background color */
        color: white; /* White text color */
        border: none; /* Remove border */
        border-radius: 4px; /* Optional: Add rounded corners */
    }
    
    .custom-confirm-button:hover {
        background-color: #333; /* Darker black on hover */
    }

    </style>
    @endpush

@section('content')
    <div class="container-xl content-div" style="height: fit-content">
        <form id="payment_form" method="POST" action="/session">
            <div class="mb-3 bottom-outline-div" >
                <label class="form-label" style="font-weight: bold;">Delivery Details</label>
                <div class="row input-layout">
                    <div class="col">
                        {{-- <input type="text" id="input_firstname" class="form-control" name="first_name" placeholder="First name" value="Tan"> --}}
                        <input type="text" id="input_firstname" class="form-control" name="first_name" placeholder="First name">
                    </div>
                    <div class="col">
                        {{-- <input type="text" id="input_lastname" class="form-control" name="last_name" placeholder="Last name" value="Wei Ming"> --}}
                        <input type="text" id="input_lastname" class="form-control" name="last_name" placeholder="Last name">
                    </div>
                </div>
{{--                <input type="text" class="form-control input-layout" name="delivery_address"id="input_deliveryaddress"
                     placeholder="Delivery Address" value="123, jalan 123"> --}}
               <input type="text" class="form-control input-layout" name="delivery_address"id="input_deliveryaddress"
                          placeholder="Delivery Address">

            </div>
            <div class="mb-3 bottom-outline-div">
                <label class="form-label" style="font-weight: bold;">Contact Information</label>
                {{-- <input type="text"  class="form-control input-layout" id="input_email" name="email" placeholder="Email" value="example@example.com"> --}}
                <input type="text"  class="form-control input-layout" id="input_email" name="email" placeholder="Email">

                {{-- <input type="text" class="form-control input-layout" id="input_phonenumber" name="phone_number" placeholder="Phone Number" value="0123456789"> --}}
                <input type="text" class="form-control input-layout" id="input_phonenumber" name="phone_number" placeholder="Phone Number">

            </div>
           


            <div class="d-flex justify-content-end">
                 <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-success" onclick="submitForm(event)" >Checkout</button>
            </div>
        </form>
    </div>

@endsection

<script>

function submitForm(event) {
    event.preventDefault(); // Prevent form submission until validation is successful
    
    if (validateForm()) {
        // If validation passes, submit the form using the standard way
        document.getElementById('payment_form').submit();
    } 
}

   


function validateForm() {
    // Get input elements
    var firstName = document.getElementById('input_firstname').value.trim();
    var lastName = document.getElementById('input_lastname').value.trim();
    var deliveryAddress = document.getElementById('input_deliveryaddress').value.trim();
    var email = document.getElementById('input_email').value.trim();
    var phoneNumber = document.getElementById('input_phonenumber').value.trim();

    // Patterns for validation
    var namePattern = /^[a-zA-Z\s]+$/;  // Only letters and spaces
    var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;  // Email validation
    var phonePattern = /^[0-9]{10,15}$/;  // Only numbers (10-15 digits)
    
    // Validations
    if (!namePattern.test(firstName)) {
        Swal.fire({
            title: 'Error: Invalid Input',
            text: 'First name must contain only letters and spaces',
            icon: 'error',
            confirmButtonText: 'OK',
            customClass: {
            confirmButton: 'custom-confirm-button'
        }
        });
        return false;
    }

    if (!namePattern.test(lastName)) {
        Swal.fire({
            title: 'Error: Invalid Input',
            text: 'Last name must contain only letters and spaces',
            icon: 'error',
            confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'custom-confirm-button'
        }
        });
        return false;
    }

    if (deliveryAddress === "") {
        Swal.fire({
            title: 'Error: Invalid Input',
            text: 'Delivery address cannot be empty',
            icon: 'error',
            confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'custom-confirm-button'
        }
        });
        return false;
    }

    if (!emailPattern.test(email)) {
        Swal.fire({
            title: 'Error: Invalid Input',
            text: 'Please enter a valid email address',
            icon: 'error',
            confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'custom-confirm-button'
        }        });
        return false;
    }

    if (!phonePattern.test(phoneNumber)) {
        Swal.fire({
            title: 'Error: Invalid Input',
            text: 'Please enter a valid phone number',
            icon: 'error',
            confirmButtonText: 'OK',
        customClass: {
            confirmButton: 'custom-confirm-button'
        }        });
        return false;
    }

    return true;
}

</script>