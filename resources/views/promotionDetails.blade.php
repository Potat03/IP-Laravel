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
        <div class="main-image mb-3" style="
    width: 500px;
    height: 500px;">
            <div class="row">
                <div class="col-6 p-0">
                    <img src={{ URL('storage/images/pokemon.png') }}
                        class="d-block img-thumbnail border-0" alt="product image">
                </div>

                <div class="col-6 p-0">
                    <img src={{ URL('storage/images/consumable.png') }}
                        class="d-block img-thumbnail border-0" alt="product image">
                </div>

                <div class="col-6 p-0">
                    <img src={{ URL('storage/images/collectible.png') }}
                        class="d-block img-thumbnail border-0" alt="product image">
                </div>

                <div class="col-6 p-0">
                    <img src={{ URL('storage/images/pika.jpg') }}
                        class="d-block img-thumbnail border-0" alt="product image">
                </div>
            </div>
        </div>

        <!-- Thumbnail Images -->
        <div class="thumbnails d-flex">
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
                    href="#">Add to Cart</a>
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
                    <h5>{{ $product->name }}</h5>
                    <div>
                        <span>Quantity:</span>
                        <span>{{ $product->quantity }}</span>
                    </div>
                    <a href="{{ route('product', ['id' => $product->product_id]) }}" class="btn btn-outline-dark mt-3">View Product</a>
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

    function selectVariation(element) {
        var buttons = document.querySelectorAll('.btn-variation');

        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        element.classList.add('active');
    }

    function selectVariation2(element) {
        var buttons = document.querySelectorAll('.btn-variation-2');

        buttons.forEach(function(button) {
            button.classList.remove('active');
        });

        element.classList.add('active');
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

    document.getElementById('quantity').addEventListener('change', function() {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);

        if (currentQuantity < 1 || isNaN(currentQuantity)) {
            quantityInput.value = 1;
        }
    });

    document.addEventListener("DOMContentLoaded", function() {
        // Get all thumbnails and the main image element
        const thumbnails = document.querySelectorAll('.thumbnail');
        const mainImage = document.getElementById('mainImage');

        // Add click event listener to each thumbnail
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', function() {
                // Get the image URL from the data-image attribute
                const imageUrl = this.getAttribute('data-image');
                // Update the src attribute of the main image
                mainImage.src = imageUrl;

                // Optionally update thumbnail styling to indicate the active state
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                this.classList.add('active');
            });
        });
    });
</script>
@endpush