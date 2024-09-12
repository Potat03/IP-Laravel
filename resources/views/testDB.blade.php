<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        @csrf
        <input type="text" value="1" name="customer_id" id="customer_id">
        <input type="text" value="1" name="product_id" id="product_id">
        <input type="text" value="1" name="promotion_id" id="promotion_id">
        <input type="text" value="1" name="quantity" id="quantity">
        <input type="text" value="100.00" name="subtotal" id="subtotal">
        <input type="text" value="20.00" name="discount" id="discount">
        <input type="text" value="80.00" name="total" id="total">
        <button type="submit">Upload</button>
    </form>

    <!-- <div id="cart-item-details">
    </div> -->
    <div id="cart-items-details"></div>

    <script>
    
    
    //handle form submit
    form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let formData = new FormData(form);

        fetch('/api/cartItem/upload', {
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
                alert('An error occurred while uploading the image.');
            });
    });

    // document.addEventListener('DOMContentLoaded', function() {
    //     fetch('/api/cartItem/getCartItem/1')
    //         .then(response => response.json())
    //         .then(responseData => {
    //             if (responseData) {
    //                 // Assuming responseData contains the cart item details
    //                 const cartItem = responseData;

    //                 // Display the cart item details
    //                 console.log('Cart Item:', cartItem);

    //                 // You could do something like this:
    //                 const cartItemDetailsDiv = document.getElementById('cart-item-details');
    //                 cartItemDetailsDiv.innerHTML = `

    //                 <p>Price: $${cartItem.subtotal}</p>

    //             `;
    //             } else {
    //                 console.error('Error: Cart item not found.');
    //                 alert('Cart item not found.');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error:', error);
    //             alert('An error occurred while fetching the product data.');
    //         });
    // });

    //     document.addEventListener('DOMContentLoaded', function() {
    //     // Array of cart item IDs
    //     const cartItemIds = [1, 3]; // Replace with actual IDs

    //     fetch('/api/cartItems/get', {
    //         method: 'POST',
    //         headers: {
    //             'Content-Type': 'application/json' // Indicates JSON payload
    //         },
    //         body: JSON.stringify({
    //             ids: cartItemIds
    //         }) // Ensure body is JSON string
    //     })
    //     .then(response => response.json())
    //     .then(cartItems => {
    //         // Handle the response directly as an array of cart items
    //         if (Array.isArray(cartItems)) {
    //             const cartItemsDetailsDiv = document.getElementById('cart-items-details'); // Ensure this element exists
    //             cartItemsDetailsDiv.innerHTML = ''; // Clear any existing content

    //             // Iterate over the array and display prices
    //             for (let i = 0; i < cartItems.length; i++) {
    //                 const cartItem = cartItems[i];
    //                 const price = parseFloat(cartItem.subtotal);

    //                 // Create a new div for each price
    //                 const priceDiv = document.createElement('div');
    //                 priceDiv.textContent = `Price: $${price.toFixed(2)}`;

    //                 // Append the new div to the container
    //                 cartItemsDetailsDiv.appendChild(priceDiv);
    //             }
    //         } else {
    //             console.error('Error: Unexpected response format');
    //             alert('An error occurred while fetching the cart items.');
    //         }
    //     })
    //     .catch(error => {
    //         console.error('Network Error:', error); // More descriptive error message
    //         alert('An error occurred while fetching the cart items.');
    //     });
    // });

    document.addEventListener('DOMContentLoaded', function() {
        const customerID = 1;
        fetch(`/api/cartItem/getCartItemByCustomerID/${customerID}`)
            .then(response => response.json())
            .then(data => {
                if (data.cartItems) {
                    // Handle the response as an array of cart items
                    const cartItems = data.cartItems;
                    const products = data.products;
                    const promotions = data.promotions;

                    const cartItemsDetailsDiv = document.getElementById(
                    'cart-items-details'); // Ensure this element exists
                    
                    cartItemsDetailsDiv.innerHTML = ''; // Clear any existing content

                    // Iterate over the array and display prices
                    for (let i = 0; i < cartItems.length; i++) {
                        const cartItem = cartItems[i];
                        const product = products[i];
                      


                        if(cartItem.promotion_id == null){
                        const nameDiv = document.createElement('div');
                        nameDiv.textContent = `Name: ${product.name}`;
                            
                        // Create a new div for each price
                        const quantityDiv = document.createElement('div');
                        quantityDiv.textContent = `Quantity: ${cartItem.quantity}`;

                        
                        const price = parseFloat(product.price);
                        const priceDiv = document.createElement('div');
                        priceDiv.textContent = `Price: $${price.toFixed(2)}`;

                        // Append the new div to the container
                        cartItemsDetailsDiv.appendChild(nameDiv);
                        cartItemsDetailsDiv.appendChild(quantityDiv);
                        cartItemsDetailsDiv.appendChild(priceDiv);
                        }

                    }
                } else if (data.error) {
                    // Handle error messages from the backend
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
</body>

</html>