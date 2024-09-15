@extends('layout.promotion')

@section('title', "Promotion")

@push('styles')
<!-- Include Bootstrap CSS -->
<style>
    /*Thumbnail CSS*/
    .main-square {
        width: 100%;
        max-width: 600px;
        height: 600px;
        object-fit: contain;
        object-position: center;
    }

    .thumbnail-square {
        width: 100px;
        height: 100px;
        object-fit: contain;
        object-position: center;
        border: 3px solid transparent;
        transition: border-color 0.3s;
        cursor: pointer;
    }

    /* Flexbox layout for thumbnails */
    .thumbnails {
        gap: 5px;
    }

    .thumbnail.active {
        border-color: rgb(17, 16, 16);
    }

    /*END*/

    .breadcrumb-item+.breadcrumb-item::before {
        content: ' > ';
        padding: 0 0.5rem;
        color: #6c757d;
    }

    .product-detail-container {
        display: flex;
        flex-wrap: wrap;
        margin-top: 50px;
    }

    .product-image {
        flex: 1;
        max-width: 50%;
        padding-right: 20px;
    }

    .product-info {
        flex: 1;
        max-width: 50%;
        display: flex;
        flex-direction: column;
    }

    .product-info h1 {
        font-size: 2.5rem;
    }

    .product-info h4 {
        font-size: 1.5rem;
    }

    .product-info h5 {
        font-size: 1.3rem;
    }

    .product-info .d-flex {
        font-size: 1.2rem;
    }

    .product-details {
        margin-top: 10px;
    }

    /* Variation Button Styling */
    .btn-variation,
    .btn-variation-2 {
        background-color: #ffffff;
        padding: 10px 20px;
        margin-right: 10px;
        margin-bottom: 10px;
        cursor: pointer;
        font-size: 1.2rem;
        border-radius: 0.25rem;
    }

    .quantity-selector {
        margin-top: 10px;
    }

    .quantity-selector .input-group {
        width: 200px;
    }

    .quantity-selector .input-group button {
        font-size: 1.2rem;
    }

    .quantity-selector .input-group input {
        text-align: center;
        font-size: 1.2rem;
    }

    .btn-add-to-cart {
        display: block;
        width: 100%;
        padding: 12px;
        font-size: 1.2rem;
        text-align: center;
        border-radius: 0.25rem;
    }

    /* Bundle Deal Section */
    .bundle-deal {
        margin-top: 50px;
    }

    .bundle-image {
        max-width: 150px;
        height: auto;
        object-fit: cover;
    }

    .bundle-details {
        text-align: center;
    }

    .price {
        font-size: 1rem;
    }

    .original-price {
        text-decoration: line-through;
    }

    .discounted-price {
        font-size: 1.3rem;
        color: #dc3545;
    }

    .bundle-summary {
        text-align: center;
    }

    .bundle-deal,
    .review-section {
        margin-top: 50px;
        padding: 20px;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }

    .bundle-deal h2,
    .review-section h2 {
        font-size: 2rem;
        margin-bottom: 20px;
    }

    .review-section .review-item {
        border-bottom: 1px solid #ddd;
        padding: 10px 0;
    }

    .review-section .review-item:last-child {
        border-bottom: none;
    }
</style>
@endpush

@section('top')
<div class="container product-detail-container">
    <div class="container mt-4 product-image">
        <!-- Main Image Display -->
        <div class="main-image border p-3 rounded mb-3" style="
    width: 500px;
    height: 500px;">
            <div class="row">
                @foreach ($promotion->product_list as $product)
                @if ($loop->index >= 4)
                @break
                @endif
                <div class="col-6 p-0">
                    <img src="{{ asset('storage/images/products/' . $product->product_id . '/main.png') }}"
                        class="d-block img-thumbnail border-0" alt="product image">
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="product-info">
        <div class="row">
            <h5 class="text-muted">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                href="{{ url('/home') }}">Home</a></li>
                        <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                href="{{ url('/promotion') }}">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $promotion->title }}</li>
                    </ol>
                </nav>
            </h5>
        </div>
        <div>
            <h1 class="fw-bold">{{ $promotion->title }}</h1>
            <h4 class="text-muted">RM {{ $promotion->discount_amount }}</h4>
            <div class="d-flex align-items-center text-warning">
                <i class="bi bi-star-fill me-1"></i>
                <i class="bi bi-star-fill me-1"></i>
                <i class="bi bi-star-fill me-1"></i>
                <i class="bi bi-star-fill me-1"></i>
                <i class="bi bi-star-fill me-1"></i>
                <span class="text-dark ms-2">(20)</span>
            </div>
        </div>
        <div class="quantity-selector mt-4">
            <div class="input-group">
                <button class="btn btn-outline-dark fw-bold" type="button" onclick="changeQuantity(-1)">-</button>
                <input type="text" class="form-control" id="quantity" value="1">
                <button class="btn btn-outline-dark fw-bold" type="button" onclick="changeQuantity(1)">+</button>
            </div>
        </div>

        <div class="pt-5 border-top-0 bg-transparent">
            <div class="text-center text-uppercase">
                <a class="btn btn-outline-dark btn-add-to-cart mt-auto w-100 fw-bold {{ $promotion->limit > 0 ? '' : 'disabled' }}"
                    data-bs-toggle="modal" data-bs-target="#selectModal">Add to Cart</a>
            </div>
        </div>

        <div class="product-details mt-5">
            <h5>Promotion Description:</h5>
            <p style="font-size: 1.2rem;">
                {{ $promotion->description }}
            </p>
        </div>
    </div>
</div>
<div class="modal fade modal-xl" id="selectModal" tabindex="-1" aria-labelledby="selectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectModalLabel">Select Variation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        @foreach ($promotion->product_list as $product)
                        @for ($i = 0; $i < $product->quantity; $i++)
                            <div class="card mb-3 col-12">
                                <div class="row g-0">
                                    <div class="col-md-2 border-end">
                                        <img src="{{ asset('storage/images/products/' . $product->product_id . '/main.png') }}"
                                            class="img-fluid p-5" alt="product image">
                                    </div>
                                    <div class="col-md-10">
                                        <div class="card-body">
                                            <h5 class="card-title"><span class="h4">Name : </span>{{ $product->name }}</h5>
                                            @if(strtoupper($product->type) == strtoupper('wearable'))
                                            @php
                                            $sizes = explode(',', $product->wearable->size);
                                            $colors = explode(',', $product->wearable->color);
                                            @endphp
                                            <div class="d-flex flex-wrap pt-3 align-items-center">
                                                <h5 class="col-1 text-secondary m-0">Color :</h5>
                                                @foreach ($colors as $color)
                                                <button class="btn btn-color"
                                                    onclick="selectColor(this, {{$product->product_id}}, {{($product->quantity > 1) ? $i : '-1'}})">{{ $color }}</button>
                                                @endforeach
                                            </div>
                                            <div class="d-flex flex-wrap pt-3 align-items-center">
                                                <h5 class="col-1 text-secondary m-0">Size :</h5>

                                                @foreach ($sizes as $size)
                                                <button class="btn btn-size"
                                                    onclick="selectSize(this, {{$product->product_id}}, {{($product->quantity > 1) ? $i : '-1'}})">{{ $size }}</button>
                                                @endforeach
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endfor
                            @endforeach
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="btn-submit-cart">Save changes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('bundle')
<div class="container bundle-deal">
    <h2>Bundle Deal</h2>
    <div class="container">

        @foreach ($promotion->product_list as $product)
        <div class="row py-3 {{ $loop->last ? '' : ' border-bottom' }}">
            <div class="col-2">
                <img src="{{ asset('storage/images/products/' . $product->product_id . '/main.png') }}" class="bundle-image" alt="product image">
            </div>
            <div class="col">
                <div class="container">
                    <h4>{{ $product->name }}</h4>
                    <div class="pt-1">
                        <span>Quantity:</span>
                        <span>{{ $product->quantity }}</span>
                    </div>
                    <a href="{{ url('/product/' . $product->product_id) }}" class="btn btn-outline-dark mt-4">View Product</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('bottom')
<!-- Review Section -->
<div class="container review-section mb-5">
    <h2>Reviews</h2>
    @for ($i = 0; $i < 10; $i++)
        <div class="review-item">
        <h5>John Doe</h5>
        <div class="d-flex align-items-center text-warning">
            <i class="bi bi-star-fill me-1"></i>
            <i class="bi bi-star-fill me-1"></i>
            <i class="bi bi-star-fill me-1"></i>
            <i class="bi bi-star-fill me-1"></i>
            <i class="bi bi-star-fill me-1"></i>
        </div>
        <p style="font-size: 1.2rem;">This is an amazing product! Highly recommended.</p>
</div>
@endfor
</div>
@endsection

@push('scripts')
<script>
    let limit = @json($promotion->limit);
    let bought_count = @json($promotion->bought_count);
    let promo_content = @json($promotion->product_list);

    function selectSize(element, id, index = -1) {
        if (element.classList.contains('active')) {
            element.classList.remove('active');
            let product = promo_content.find(product => product.product_id == id);
            if (index != -1) {
                if (product.size == null) {
                    product.size = [];
                }
                product.size[index] = null;
            } else {
                product.size = null;
            }
            return;
        }

        var buttons = element.parentElement.querySelectorAll('.btn-size');

        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        element.classList.add('active');
        let product = promo_content.find(product => product.product_id == id);
        if (index != -1) {
            if (product.size == null) {
                product.size = [];
            }
            product.size[index] = element.innerText;
        } else {
            product.size = element.innerText;
        }
        console.log(promo_content);
    }

    function selectColor(element, id, index = -1) {
        if (element.classList.contains('active')) {
            element.classList.remove('active');
            let product = promo_content.find(product => product.product_id == id);
            if (index != -1) {
                if (product.color == null) {
                    product.color = [];
                }
                product.color[index] = null;
            } else {
                product.color = null;
            }
            return;
        }

        var buttons = element.parentElement.querySelectorAll('.btn-color');

        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        element.classList.add('active');
        let product = promo_content.find(product => product.product_id == id);
        if (index != -1) {
            if (product.color == null) {
                product.color = [];
            }
            product.color[index] = element.innerText;
        } else {
            product.color = element.innerText;
        }
        console.log(promo_content);
    }

    function changeQuantity(amount) {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        var newQuantity = currentQuantity + amount;

        if (newQuantity < 1) {
            newQuantity = 1;
        }

        if (limit > 0 && newQuantity > limit - bought_count) {
            newQuantity = limit - bought_count;
        }

        quantityInput.value = newQuantity;
    }

    function addToCart() {
        var quantityInput = document.getElementById('quantity');
        var quantity = parseInt(quantityInput.value);

        if (quantity < 1) {
            alert('Please select a quantity greater than 0');
            return;
        }

        if (limit > 0 && quantity > limit - bought_count) {
            alert('You have exceeded the limit for this promotion');
            return;
        }

        alert('Added to cart');
    }


    document.addEventListener("DOMContentLoaded", function() {

        document.getElementById('quantity').addEventListener('change', function() {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);

            if (currentQuantity < 1 || isNaN(currentQuantity)) {
                quantityInput.value = 1;
            }
        });

        document.querySelector('#btn-submit-cart').addEventListener('click', function() {
            let allSelected = true;
            promo_content.forEach(product => {
                if (product.quantity > 1) {
                    if (product.size == null || product.color == null) {
                        allSelected = false;
                    } else {
                        try {
                            for (let i = 0; i < product.quantity; i++) {
                                if (product.size[i] == null || product.color[i] == null) {
                                    allSelected = false;
                                }
                            }
                        } catch (e) {
                            allSelected = false;
                        }

                    }
                } else if (product.size == null || product.color == null) {
                    allSelected = false;
                }
            });

            if (allSelected) {9
                addToCart();
            } else {
                alert('Please select a size and color for each product');
            }
        });

    });
</script>
@endpush