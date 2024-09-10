<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/sass/app.scss','resources/js/app.js','resources/css/general.css'])

    <style>
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

    .outline-divv {
        text-align: center;
        border: 1px solid #d3d3d3fa;
        margin-top: 0.5%;
        margin-bottom: 0.5%;
        margin-left: 3.5%;
        margin-right: 3.5%;
        padding-left: 0.5%;
        padding-right: 0.5%;
        padding-top: 0.5%;
        padding-bottom: 0.5%;
        border-radius: 10px;
        flex: 1;
    }

    .no-outline-divv {
        text-align: center;
        margin-top: 0.5%;
        margin-bottom: 0.5%;
        margin-left: 3.5%;
        margin-right: 3.5%;
        padding-left: 0.5%;
        padding-right: 0.5%;
        padding-top: 0.5%;
        padding-bottom: 0.5%;
        flex: 1;

    }



    #cart-items-table td:nth-child(1),
#cart-items-table td:nth-child(2) {
    text-align: left !important;
}

/* Ensure the body and the main container fill the viewport height */
body, html {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
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
        <div class="sticky-top">
            <table class="table" style="margin-bottom: 0%;">
                <thead>
                    <tr>
                        <th scope="col" style="width:15%;text-align:left!important">Product</th>
                        <th scope="col" style="width:25%;text-align:left!important">Product Name</th>
                        <th scope="col" style="width:15%;">Unit Price</th>
                        <th scope="col" style="width:15%;">Quantity</th>
                        <th scope="col" style="width:15%;">Total Price</th>
                        <th scope="col" style="width:15%;">Action</th>
                    </tr>
                </thead>
            </table>
        </div>
        <table class="table" id="cart-items-table" >
            <tbody >

                <?php
for ($x = 0; $x <= 10; $x++) {
    echo '
      <tr class="animate-row" style="animation-delay:'. 0.05 * $x .'s;">
        <td style="width:15%;text-align:left!important">
          <img src="' . URL('storage/images/pika.jpg') . '" alt="pokemon" width="135" height="135">
          
        </td>
                <td style="width:25%;text-align:left!important">

        <p>Pokemon Card</p>
        </td>
        <td style="width:15%;">RM8.00</td>
        <td style="width:15%;">
          <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
            <button id="'.$x.'decrease" class="btn btn-outline-secondary decrease-btn" onclick=minus("'.$x.'quantity") type="button" style="border-right:none;">-</button>
            <input id="'.$x.'quantity" value=1 style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text" class="form-control" aria-describedby="basic-addon1">
            <button id="'.$x.'increase" class="btn btn-outline-secondary increase-btn" onclick=add("'.$x.'quantity") type="button" style="border-left:none;">+</button>
          </div>
        </td>
        <td style="width:15%;">RM8.00</td>
        <td style="width:15%;"><button type="button" class="btn btn-danger">DELETE</button></td>
      </tr>';
}
?>
            </tbody>

        </table>

    </div>

    <div class="sticky-bottom">
        <div>
            <table style="width:100%;margin:0%" class="table discount-detail-table">
                <tbody>
                    <tr>

                        <td colspan=2
                            style="text-align:right!important;padding-top:0.5%!important;padding-bottom:0.5%!important;">
                            Discount Details<button style="background-color: #ffffff;border:0" onclick=showDiscount()><i
                                    id="show-discount-icon" style="display:inline">&#9650;</i><i id="hide-discount-icon"
                                    style="display:none;">&#9660;</i></button></td>

                    </tr>
                    <?php
                echo 
                '<tr class="discount-row" style="display:none">  
                    <td>description</td>
                    <td>-RM8.00</td>
                </tr>';
                ?>

                </tbody>
            </table>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="outline-divv">
                Discount RM0.00
            </div>
            <div class="outline-divv">
                Delivery RM0.00
            </div>
            <div class="outline-divv">
                Subtotal RM0.00
            </div>
            <div class="outline-divv">
                Total RM0.00
            </div>
            <div class="no-outline-divv">
                <td style="width:20%;"><button type="button" class="btn btn-success">CHECKOUT</button>
            </div>
        </div>
    </div>

</body>

</html>

<script>
function add(quantityid, i) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(quantityid);
    var currentValue = parseInt(quantityInput.value, 10);
    var newValue = currentValue + 1;
    quantityInput.value = newValue;

    // Get the total price and each price elements
    var totalPrice = document.getElementById(`${i}totalPrice`);
    var eachPrice = document.getElementById(`${i}eachPrice`);

    // Get the numeric value of the product price (remove "RM" and convert to float)
    var priceValue = parseFloat(eachPrice.textContent.replace('RM', ''));

    // Calculate the new total price
    var newTotalPrice = priceValue * newValue;

    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM${newTotalPrice.toFixed(2)}`;
}

function minus(quantityid, i) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(quantityid);
    var currentValue = parseInt(quantityInput.value, 10);
    
    // Ensure quantity does not go below 1
    var newValue = currentValue > 1 ? currentValue - 1 : 1;
    quantityInput.value = newValue;

    // Get the total price and each price elements
    var totalPrice = document.getElementById(`${i}totalPrice`);
    var eachPrice = document.getElementById(`${i}eachPrice`);

    // Get the numeric value of the product price (remove "RM" and convert to float)
    var priceValue = parseFloat(eachPrice.textContent.replace('RM', ''));

    // Calculate the new total price
    var newTotalPrice = priceValue * newValue;

    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM${newTotalPrice.toFixed(2)}`;
}


function showDiscount() {
    var discountRows = document.getElementsByClassName("discount-row");
    var showDiscountIcon = document.getElementById("show-discount-icon");
    var hideDiscountIcon = document.getElementById("hide-discount-icon");

    for (var i = 0; i < discountRows.length; i++) {
        if (discountRows[i].style.display != "table-row") {
            discountRows[i].style.display = "table-row";
            showDiscountIcon.style.display = "none";
            hideDiscountIcon.style.display = "inline";

        } else {
            discountRows[i].style.display = "none";
            showDiscountIcon.style.display = "inline";
            hideDiscountIcon.style.display = "none";

        }
    }
}

document.addEventListener('DOMContentLoaded', (event) => {
    // Select all rows with the animate-row class
    const rows = document.querySelectorAll('tr.animate-row');
    rows.forEach((row, index) => {
        // Remove the class to reset the animation
        row.classList.remove('animate-row');
        // Trigger reflow to restart the animation
        void row.offsetWidth;
        // Reapply the class to start the animation
        row.classList.add('animate-row');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const customerID = 1;
    fetch(`/api/cartItem/getCartItemByCustomerID/${customerID}`)
        .then(response => response.json())
        .then(data => {
            if (data.cartItems) {
                const cartItems = data.cartItems;
                const products = data.products;
                
                const tbody = document.querySelector('#cart-items-table tbody');
                tbody.innerHTML = '';

                for (let i = 0; i < cartItems.length; i++) {
                    const cartItem = cartItems[i];
                    const product = products[i];
                    
                    // Calculate delay for animation
                    const animationDelay = 0.05 * i;

                    // Create a new table row
                    const row = document.createElement('tr');
                    row.classList.add('animate-row');
                    row.style.animationDelay = `${animationDelay}s`;

                    // Create the first cell with an image
                    const imgCell = document.createElement('td');
                    imgCell.style.width = '15%';
                    imgCell.style.textAlign = 'left';
                    const img = document.createElement('img');
                    img.src = 'storage/images/pika.jpg'; // Assuming all products use this image
                    img.alt = product.name;
                    img.width = 135;
                    img.height = 135;
                    imgCell.appendChild(img);
                    row.appendChild(imgCell);

                    // Create the second cell with product name
                    const nameCell = document.createElement('td');
                    nameCell.style.width = '25%';
                    nameCell.style.textAlign = 'left';
                    const nameP = document.createElement('p');
                    nameP.textContent = product.name;
                    nameCell.appendChild(nameP);
                    row.appendChild(nameCell);

                    // Create the third cell with product price
                    const priceCell = document.createElement('td');
                    priceCell.id=`${i}eachPrice`;
                    priceCell.style.width = '15%';
                    priceCell.textContent = `RM${parseFloat(product.price).toFixed(2)}`;
                    row.appendChild(priceCell);

                    // Create the fourth cell with quantity input and buttons
                    const quantityCell = document.createElement('td');
                    quantityCell.style.width = '15%';

                    const inputGroupDiv = document.createElement('div');
                    inputGroupDiv.classList.add('input-group', 'mb-3');
                    inputGroupDiv.style.justifyContent = 'center';
                    inputGroupDiv.style.marginBottom = '0';

                    const decreaseBtn = document.createElement('button');
                    decreaseBtn.id = `${i}decrease`;
                    decreaseBtn.classList.add('btn', 'btn-outline-secondary', 'decrease-btn');
                    decreaseBtn.setAttribute('onclick', `minus("${i}quantity",${i})`);
                    decreaseBtn.type = 'button';
                    decreaseBtn.style.borderRight = 'none';
                    decreaseBtn.textContent = '-';
                    inputGroupDiv.appendChild(decreaseBtn);

                    const quantityInput = document.createElement('input');
                    quantityInput.id = `${i}quantity`;
                    quantityInput.value = cartItem.quantity;
                    quantityInput.style.border = '#6c757d 1px solid';
                    quantityInput.style.maxWidth = '60px';
                    quantityInput.style.textAlign = 'center';
                    quantityInput.type = 'text';
                    quantityInput.classList.add('form-control');
                    inputGroupDiv.appendChild(quantityInput);

                    const increaseBtn = document.createElement('button');
                    increaseBtn.id = `${i}increase`;
                    increaseBtn.classList.add('btn', 'btn-outline-secondary', 'increase-btn');
                    increaseBtn.setAttribute('onclick', `add("${i}quantity","${i}")`);
                    increaseBtn.type = 'button';
                    increaseBtn.style.borderLeft = 'none';
                    increaseBtn.textContent = '+';
                    inputGroupDiv.appendChild(increaseBtn);

                    quantityCell.appendChild(inputGroupDiv);
                    row.appendChild(quantityCell);

                    // Create the fifth cell with the total price
                    const totalCell = document.createElement('td');
                    totalCell.style.width = '15%';
                    totalCell.id=`${i}totalPrice`;
                    totalCell.textContent = `RM${(parseFloat(product.price) * cartItem.quantity).toFixed(2)}`;
                    row.appendChild(totalCell);

                    // Create the sixth cell with the delete button
                    const deleteCell = document.createElement('td');
                    deleteCell.style.width = '15%';
                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.classList.add('btn', 'btn-danger');
                    deleteButton.textContent = 'DELETE';
                    deleteCell.appendChild(deleteButton);
                    row.appendChild(deleteCell);

                    // Append the row to the table body
                    tbody.appendChild(row);
                }
            } else if (data.error) {
                console.error('Error:', data.error);
                alert(data.error);
            } else {
                console.error('Unexpected response format.');
                alert('Unexpected response format.');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while fetching the cart items.');
        });
});

</script>