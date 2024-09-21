@extends('layout.shop')
{{-- Author: Tan Wei Siang --}}

@section('title', 'Cart')

@push('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
@vite(['resources/css/general.css'])
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

body,
html {
    /* height: 100%; */
    margin: 0;
    display: flex;
    flex-direction: column;
}
</style>
@endpush

@section('content')
 
   


@php
$subtotal=0;
$deliveryFee = 5;
$totalDiscount=0;
@endphp

   
<div class="container-xl content-div" style="margin-bottom:6%;height:fit-content;">
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
        <table class="table" id="cart-items-table">
            <tbody>
                @if($cartItems!=null)
                @php
                    $x = 1;
                @endphp
                @foreach($cartItems as $cartItem)
                    @if($cartItem->product_id != null)
                        @php
                            $id = $cartItem->id;
                            $quantity = $cartItem->quantity;
            
                            // Use raw values for calculation
                            $unitPrice = $cartItem->product->price; 
                            $totalForItem = $cartItem->quantity * $unitPrice;
            
                            // Format for display after calculation
                            $formattedUnitPrice = number_format($unitPrice, 2);
                            $formattedTotalForItem = number_format($totalForItem, 2);
                        @endphp
                        <tr id="cartItemRow_{{$id}}" class="animate-row" style="animation-delay:'. 0.05 * {{$x}} .'s;">
                            <td style="width:15%;text-align:left!important">
                                <div class="card-img-top">
                                   
<img src="{{ asset('storage/images/products/' . $cartItem->product->product_id . '/main.png') }}"
class="d-block img-thumbnail border-0" alt="product image">
                                   
                                </div>                            
                            </td>
                            <td style="width:25%;text-align:left!important">
                                <p>{{$cartItem->product->name}}</p>
                            </td>
                            <td style="width:15%;" id="oriUnitPrice_{{$id}}">RM {{$formattedUnitPrice}}</td>
                            <td style="width:15%;">
                                <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                                    <button id="decrease{{$id}}" class="btn btn-outline-secondary decrease-btn"
                                        onclick="productMinus({{$id}})" type="button" style="border-right:none;">-</button>
                                    <input id="quantity_{{$id}}" value={{$quantity}}
                                        style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text"
                                        class="form-control" aria-describedby="basic-addon1">
                                    <button id="'.$x.'increase" class="btn btn-outline-secondary increase-btn"
                                        onclick="productAdd({{$id}})" type="button" style="border-left:none;">+</button>
                                </div>
                            </td>
                            <td style="width:15%;" id="totalForItem_{{$id}}">RM {{$formattedTotalForItem}}</td>
                            <td style="width:15%;"><button type="button" class="btn btn-danger"  onclick="removeCartItem({{ $id }}, false)">REMOVE</button></td>
                        </tr>
                        @php
                            // Use raw values for subtotal calculation
                            $subtotal += $cartItem->quantity * $unitPrice;
                            $x += 1;
                        @endphp
                    @else
                        @php
                            $id = $cartItem->id;
                            $quantity = $cartItem->quantity;
            
                            // Use raw values for calculation
                            $oriUnitPrice = $cartItem->promotion->original_price;
                            $disUnitPrice = $cartItem->promotion->discount_amount;
                            $unitPriceAfterDis =  $oriUnitPrice- $disUnitPrice;
                            $totalForItem = $cartItem->quantity * $disUnitPrice;
            
                            // Format for display after calculation
                            $formattedOriUnitPrice = number_format($oriUnitPrice, 2);
                            $formattedunitPriceAfterDis = number_format($unitPriceAfterDis, 2);
                            $formattedTotalForItem = number_format($totalForItem, 2);
                        @endphp
                        <tr id="cartItemRow_{{$id}}" class="animate-row" style="animation-delay:'. 0.05 * {{$x}} .'s;">
                            <td style="width:15%;text-align:left!important">
                                <div class="card-img-top">
                                    <div class="container">
                                        <div class="row pt-3 p-2" style="min-height:250px;">
                                            @foreach ($cartItem->promotion->products as $product)
                                            @if ($loop->index >= 4)
                                            @break
                                            @endif
                                            <div class="{{count($cartItem->promotion->products) == 1 ? 'col-12' : 'col-6'}} p-0">
                                                <img src="{{ asset('storage/images/products/' . $product->product_id . '/main.png') }}"
                                                    class="d-block img-thumbnail border-0" alt="product image">
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>                       
                                </td>
                            <td style="width:25%;text-align:left!important">
                                <p>{{$cartItem->promotion->title}}</p>
                            </td>
                            <td style="width:15%;" id="unitPrice_{{$id}}">
                                <span style="text-decoration: line-through;" id="oriUnitPrice_{{$id}}">RM {{$formattedOriUnitPrice}}</span><br>
                                <span id="disUnitPrice_{{$id}}">RM {{$formattedunitPriceAfterDis}}</span>
                            </td>
                                                        <td style="width:15%;">
                                <div class="input-group mb-3" style="justify-content: center;margin-bottom:0!important;">
                                    <button id="decrease{{$id}}" class="btn btn-outline-secondary decrease-btn"
                                        onclick="promotionMinus({{$id}})" type="button" style="border-right:none;">-</button>
                                    <input id="quantity_{{$id}}" value={{$quantity}}
                                        style="border: #6c757d 1px solid;max-width:60px;text-align:center;" type="text"
                                        class="form-control" aria-describedby="basic-addon1">
                                    <button id="'.$x.'increase" class="btn btn-outline-secondary increase-btn"
                                        onclick="promotionAdd({{$id}})" type="button" style="border-left:none;">+</button>
                                </div>
                            </td>
                            <td style="width:15%;" id="totalForItem_{{$id}}">RM {{$formattedTotalForItem}}</td>
                            <td style="width:15%;"><button type="button" class="btn btn-danger"  onclick="removeCartItem({{ $id }},true)">REMOVE</button></td>
                        </tr>
                        @php
                            // Use raw values for subtotal calculation
                            $totalDiscount += $disUnitPrice * $quantity;
                            $subtotal += $cartItem->quantity * $oriUnitPrice;
                            $x += 1;
                        @endphp
                    @endif
                @endforeach
            @else
            <tr>
                <td colspan="6">
                <p style="width:100%;text-align:center;height:100%; display: flex;justify-content: center;align-items: center;">No Items</p>
                </td>
            </tr>
                @endif
            
              
            </tbody>

        </table>

    </div>

    <div class="fixed-bottom" style="border-top: solid #d3d3d3fa 1px;background-color: white; ">
        
        <div class="d-flex justify-content-between align-items-center">
            <div id="totalDiscount" class="outline-divv">
                Discount RM {{number_format($totalDiscount,2)}}
            </div>
            <div id="deliveryfee" class="outline-divv">
                Delivery RM {{number_format($deliveryFee,2)}}
            </div>
            <div id="subtotal" value="{{$subtotal}}" class="outline-divv">
                Subtotal RM {{number_format($subtotal,2)}}
            </div>
            @php
            $total = $deliveryFee + $subtotal - $totalDiscount;
            @endphp
            <div id="total" class="outline-divv">
                Total RM {{number_format($total,2)}}
            </div>
            <div class="no-outline-divv">
                <td style="width:20%;"><button type="button" class="btn btn-success" onclick="location.href='{{url('/payment')}}'">CHECKOUT</button>
            </div>
        </div>
    </div>


@endsection

<script>
function productAdd(id) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(`quantity_${id}`);
    var currentValue = parseInt(quantityInput.value, 10);
    var newValue = currentValue + 1;
    quantityInput.value = newValue;

    // Get the total price and unit price elements
    var totalPrice = document.getElementById(`totalForItem_${id}`);
    var unitPriceElement = document.getElementById(`oriUnitPrice_${id}`);

    // Get the numeric value of the unit price (remove "RM" and commas, then convert to float)
    var unitPriceValue = parseFloat(unitPriceElement.textContent.replace('RM', '').replace(',', ''));

    // Calculate the new total price
    var newTotalPrice = unitPriceValue * newValue;

    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM ${newTotalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    // Update the subtotal
    var subtotalDiv = document.getElementById("subtotal");
    var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
    var totalDiv = document.getElementById("total");
    var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

    // Add the unit price to the subtotal
    var newSubtotal = subtotalValue + unitPriceValue;
    var newTotal = totalValue + unitPriceValue;

    // Update the subtotal value, formatted with RM
    subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    updateCartItemQuantity(id, newValue);
    updateCartItemSubtotal(id, newTotalPrice);
    updateCartItemTotal(id, newTotalPrice);

    updateCartSubtotal(newSubtotal);
    updateCartTotal(newTotal);

}

function promotionAdd(id) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(`quantity_${id}`);
    var currentValue = parseInt(quantityInput.value, 10);
    var newValue = currentValue + 1;
    quantityInput.value = newValue;

    // Get the total price and unit price elements
    var totalPrice = document.getElementById(`totalForItem_${id}`);
    var oriUnitPriceElement = document.getElementById(`oriUnitPrice_${id}`);
    var disUnitPriceElement = document.getElementById(`disUnitPrice_${id}`);

    // Get the numeric value of the unit price (remove "RM" and commas, then convert to float)
    var oriUnitPriceValue = parseFloat(oriUnitPriceElement.textContent.replace('RM', '').replace(',', ''));
    var disUnitPriceValue = parseFloat(disUnitPriceElement.textContent.replace('RM', '').replace(',', ''));

    // Calculate the new total price
    var newSubtotalPrice = oriUnitPriceValue * newValue;
    var newTotalPrice = disUnitPriceValue * newValue;
    var newDiscountValue = newSubtotalPrice - newTotalPrice;

    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM ${newTotalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    // Update the subtotal
    var totalDiscountDiv = document.getElementById("totalDiscount");
    var totalDiscountValue = parseFloat(totalDiscountDiv.textContent.replace('Discount RM ', '').replace(',', ''));
    var subtotalDiv = document.getElementById("subtotal");
    var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
    var totalDiv = document.getElementById("total");
    var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

    // Add the unit price to the subtotal
    var newSubtotal = subtotalValue + oriUnitPriceValue;
    var newTotal = totalValue + disUnitPriceValue;
    var newTotalDiscount = totalDiscountValue + oriUnitPriceValue - disUnitPriceValue;

    // Update the subtotal value, formatted with RM
    totalDiscountDiv.textContent = `Discount RM ${newTotalDiscount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    
    updateCartItemQuantity(id, newValue);
    updateCartItemDiscount(id, newDiscountValue);
    updateCartItemSubtotal(id, newSubtotalPrice);
    updateCartItemTotal(id, newTotalPrice);

    
    updateCartSubtotal(newSubtotal);
    updateCartTotal(newTotal);
    updateCartDiscount(newTotalDiscount);
}



function productMinus(id) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(`quantity_${id}`);
    var currentValue = parseInt(quantityInput.value, 10);

    // Ensure quantity does not go below 1
    var newValue = currentValue > 1 ? currentValue - 1 : 1;
    quantityInput.value = newValue;

    // Get the total price and unit price elements
    var totalPrice = document.getElementById(`totalForItem_${id}`);
    var unitPriceElement = document.getElementById(`oriUnitPrice_${id}`);

    // Get the numeric value of the unit price (remove "RM" and commas, then convert to float)
    var unitPriceValue = parseFloat(unitPriceElement.textContent.replace('RM', '').replace(',', ''));

    // Calculate the new total price
    var newTotalPrice = unitPriceValue * newValue;

    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM ${newTotalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

   // Update the subtotal
    var subtotalDiv = document.getElementById("subtotal");
    var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
    var totalDiv = document.getElementById("total");
    var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

    // Add the unit price to the subtotal
    var newSubtotal = subtotalValue - unitPriceValue;
    var newTotal = totalValue - unitPriceValue;

    // Update the subtotal value, formatted with RM
    subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    
    updateCartItemQuantity(id, newValue);
    updateCartItemSubtotal(id, newTotalPrice);
    updateCartItemTotal(id, newTotalPrice);
    updateCartSubtotal(newSubtotal);
    updateCartTotal(newTotal);

}

function promotionMinus(id) {
    // Get the quantity input element and update its value
    var quantityInput = document.getElementById(`quantity_${id}`);
    var currentValue = parseInt(quantityInput.value, 10);

    // Ensure quantity does not go below 1
    var newValue = currentValue > 1 ? currentValue - 1 : 1;
    quantityInput.value = newValue;

    // Get the total price and unit price elements
    var totalPrice = document.getElementById(`totalForItem_${id}`);
    var oriUnitPriceElement = document.getElementById(`oriUnitPrice_${id}`);
    var disUnitPriceElement = document.getElementById(`disUnitPrice_${id}`);


    // Get the numeric value of the unit price (remove "RM" and commas, then convert to float)
    var oriUnitPriceValue = parseFloat(oriUnitPriceElement.textContent.replace('RM', '').replace(',', ''));
    var disUnitPriceValue = parseFloat(disUnitPriceElement.textContent.replace('RM', '').replace(',', ''));

    // Calculate the new total price
    var newSubtotalPrice = oriUnitPriceValue * newValue;
    var newTotalPrice = disUnitPriceValue * newValue;
    var newDiscountValue = newSubtotalPrice - newTotalPrice;


    // Update the total price in the cell, formatted with RM
    totalPrice.textContent = `RM ${newTotalPrice.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

 // Update the subtotal
    var totalDiscountDiv = document.getElementById("totalDiscount");
    var totalDiscountValue = parseFloat(totalDiscountDiv.textContent.replace('Discount RM ', '').replace(',', ''));
    var subtotalDiv = document.getElementById("subtotal");
    var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
    var totalDiv = document.getElementById("total");
    var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

    // Add the unit price to the subtotal
    var newSubtotal = subtotalValue - oriUnitPriceValue;
    var newTotal = totalValue - disUnitPriceValue;
    var newTotalDiscount = totalDiscountValue - (oriUnitPriceValue - disUnitPriceValue);

    // Update the subtotal value, formatted with RM
    totalDiscountDiv.textContent = `Discount RM ${newTotalDiscount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

    updateCartItemQuantity(id, newValue);
    updateCartItemDiscount(id, newDiscountValue);
    updateCartItemSubtotal(id, newSubtotalPrice);
    updateCartItemTotal(id, newTotalPrice);

    updateCartSubtotal(newSubtotal);
    updateCartTotal(newTotal);
    updateCartDiscount(newTotalDiscount);

}

function updateCartItemQuantity(id, quantity) {
    fetch(`/api/cartItem/updateQuantity/${id}`, {
        method: 'POST',
        body: JSON.stringify({ quantity: quantity }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartItemDiscount(id, discount) {
    fetch(`/api/cartItem/updateDiscount/${id}`, {
        method: 'POST',
        body: JSON.stringify({ discount: discount }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}


function updateCartItemSubtotal(id, subtotal){
    fetch(`/api/cartItem/updateSubtotal/${id}`, {
        method: 'POST',
        body: JSON.stringify({ subtotal: subtotal }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartItemTotal(id, total){
    fetch(`/api/cartItem/updateTotal/${id}`, {
        method: 'POST',
        body: JSON.stringify({ total: total }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}


function updateCartSubtotal(subtotal){
    fetch(`/api/cart/updateSubtotal`, {
        method: 'POST',
        body: JSON.stringify({ subtotal: subtotal }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartTotal(total){
    fetch(`/api/cart/updateTotal`, {
        method: 'POST',
        body: JSON.stringify({ total: total }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}

function updateCartDiscount(discount){
    fetch(`/api/cart/updateDiscount`, {
        method: 'POST',
        body: JSON.stringify({ discount: discount }),
        headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Cart item updated successfully');
        } else {
            console.error('Error updating cart item');
        }
    })
    .catch(error => console.error('Error:', error));
}


function removeCartItem(id, promotion) {
    var row = document.getElementById(`cartItemRow_${id}`);

    if (row) {
        if (promotion != true) {
            console.log("1Promotion value:", promotion);

            var quantityInput = document.getElementById(`quantity_${id}`);
            var currentValue = parseInt(quantityInput.value, 10);

            var totalPriceElement = document.getElementById(`totalForItem_${id}`);
            var unitPriceElement = document.getElementById(`oriUnitPrice_${id}`);

            var unitPriceValue = parseFloat(unitPriceElement.textContent.replace('RM', '').replace(',', ''));
            var totalPriceValue = parseFloat(totalPriceElement.textContent.replace('RM', '').replace(',', ''));

            var productTotalPrice = totalPriceValue;

            var totalDiscountDiv = document.getElementById("totalDiscount");
            var totalDiscountValue = parseFloat(totalDiscountDiv.textContent.replace('Discount RM ', '').replace(',', ''));
            var subtotalDiv = document.getElementById("subtotal");
            var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
            var totalDiv = document.getElementById("total");
            var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

            var newSubtotal = subtotalValue - productTotalPrice;
            var newTotal = totalValue - productTotalPrice;
            var newTotalDiscount = totalDiscountValue;

            totalDiscountDiv.textContent = `Discount RM ${totalDiscountValue.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

            var payload = {
                newSubtotal: newSubtotal.toFixed(2),
                newTotal: newTotal.toFixed(2),
                newTotalDiscount: newTotalDiscount.toFixed(2)
            };

            fetch(`http://127.0.0.1:8000/api/cartItem/removeCartItem/${id}`, {
                method: 'POST',
                body: JSON.stringify(payload),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cart item updated successfully');
                    row.remove();
                    checkIfAnyRowsExist();
                } else {
                    console.error('Error updating cart item');
                }
            })
            .catch(error => console.error('Error:', error));
        } else {
            console.log("2Promotion value:", promotion);

            var quantityInput = document.getElementById(`quantity_${id}`);
            var currentValue = parseInt(quantityInput.value, 10);

            var oriUnitPriceElement = document.getElementById(`oriUnitPrice_${id}`);
            var disUnitPriceElement = document.getElementById(`disUnitPrice_${id}`);

            var oriUnitPriceValue = parseFloat(oriUnitPriceElement.textContent.replace('RM', '').replace(',', ''));
            var disUnitPriceValue = parseFloat(disUnitPriceElement.textContent.replace('RM', '').replace(',', ''));

            var newSubtotalPrice = oriUnitPriceValue * currentValue;
            var totalPriceValue = disUnitPriceValue * currentValue;
            var newDiscountValue = newSubtotalPrice - totalPriceValue;

            var totalDiscountDiv = document.getElementById("totalDiscount");
            var totalDiscountValue = parseFloat(totalDiscountDiv.textContent.replace('Discount RM ', '').replace(',', ''));
            var subtotalDiv = document.getElementById("subtotal");
            var subtotalValue = parseFloat(subtotalDiv.textContent.replace('Subtotal RM ', '').replace(',', ''));
            var totalDiv = document.getElementById("total");
            var totalValue = parseFloat(totalDiv.textContent.replace('Total RM ', '').replace(',', ''));

            var newSubtotal = subtotalValue - newSubtotalPrice;
            var newTotal = totalValue - totalPriceValue;
            var newTotalDiscount = totalDiscountValue - newDiscountValue;

            totalDiscountDiv.textContent = `Discount RM ${newTotalDiscount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            subtotalDiv.textContent = `Subtotal RM ${newSubtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            totalDiv.textContent = `Total RM ${newTotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

            var payload = {
                newSubtotal: newSubtotal.toFixed(2),
                newTotal: newTotal.toFixed(2),
                newTotalDiscount: newTotalDiscount.toFixed(2)
            };

            fetch(`http://127.0.0.1:8000/api/cartItem/removeCartItem/${id}`, {
                method: 'POST',
                body: JSON.stringify(payload),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    console.log('Cart item updated successfully');
                    row.remove();
                    checkIfAnyRowsExist();
                } else {
                    console.error('Error updating cart item');
                }
            })
            .catch(error => console.error('Error:', error));
        }
    } else {
        console.error('Row not found.');
    }
}

// Function to check if any rows with the class 'animate-row' still exist
function checkIfAnyRowsExist() {
    var rows = document.querySelectorAll('tr.animate-row');
    var tableBody = document.querySelector('#cart-items-table tbody');

    if (rows.length === 0) {
        // Clear the table body
        tableBody.innerHTML = '';

        // Create and insert the <p> element with the desired style
        var noItemsMessage = document.createElement('p');
        noItemsMessage.textContent = 'No Items';

        // Apply the style
        noItemsMessage.style.width = '100%';
        noItemsMessage.style.textAlign = 'center';
        noItemsMessage.style.height = '100%';
        noItemsMessage.style.display = 'flex';
        noItemsMessage.style.justifyContent = 'center';
        noItemsMessage.style.alignItems = 'center';

        // Insert the <p> element into the table body
        var noItemsRow = document.createElement('tr');
        var noItemsCell = document.createElement('td');
        noItemsCell.colSpan = 6;  // Set the colspan to cover the entire table width
        noItemsCell.appendChild(noItemsMessage);
        noItemsRow.appendChild(noItemsCell);
        tableBody.appendChild(noItemsRow);
    }
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
        var popupButtons = document.querySelectorAll('.popup_btn');
        var popupImages = document.querySelectorAll('.popup_image_big_preview');
        var popupBoxes = document.querySelectorAll('.popup_box');

        popupButtons.forEach(function(button) {
            button.remove();
        });

        popupImages.forEach(function(image) {
            image.remove();
        });

        popupBoxes.forEach(function(box) {
            box.remove();
        });
    });
</script>