@extends('layout.product')

@section('title', $product->name)

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

        .bundle-item {
            position: relative;
            display: flex;
            flex-direction: column;
            margin-bottom: 20px;
            padding-right: 30px;
        }

        .bundle-item:not(:last-child)::after {
            content: '+';
            position: absolute;
            top: 25%;
            right: -3%;
            transform: translateY(0);
            font-size: 2.5rem;
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
            <div class="main-image mb-3">
                @php
                    $mainImageUrl = $mainImageExtension
                        ? asset('storage/images/products/' . $product->product_id . '/main.' . $mainImageExtension)
                        : asset('storage/images/products/default.jpg'); // Default image
                @endphp
                <img id="mainImage" src="{{ $mainImageUrl }}" class="img-fluid main-square" alt="Main Product Image"
                    draggable="false">

            </div>

            <!-- Thumbnail Images -->
            <div class="thumbnails d-flex">
                @foreach ($images as $image)
                    <div class="thumbnail-wrapper">
                        <img src="{{ asset('storage/images/products/' . $product->product_id . '/' . $image) }}"
                            class="thumbnail img-thumbnail thumbnail-square" alt="Thumbnail Image"
                            data-image="{{ asset('storage/images/products/' . $product->product_id . '/' . $image) }}"
                            draggable="false">
                    </div>
                @endforeach
            </div>
        </div>

        <div class="product-info">
            <div class="row">
                <h5 class="text-muted">
                    @php
                        $productType = $product->getProductType();
                    @endphp
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                    href="{{ url('/home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                    href="{{ url('/shop') }}">Shop</a></li>
                            @if ($productType)
                                <li class="breadcrumb-item"><a class="text-muted text-decoration-none"
                                        href="{{ url('/shop/' . strtolower($productType)) }}">{{ $productType }}</a></li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
                        </ol>
                    </nav>
                </h5>
            </div>
            <div>
                <h1 class="fw-bold">{{ $product->name }}</h1>
                <h4 class="text-muted">RM {{ $product->price }}</h4>
                <div class="d-flex align-items-center text-warning">
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <span class="text-dark ms-2">(20)</span>
                </div>
                <h4 class="text-muted pt-2">{{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}</h4>
            </div>
        @endsection

        @if ($product->wearable)
            @section('variation')
                <div class="mt-5">
                    @if ($product->wearable->size)
                        @php
                            $sizes = explode(',', $product->wearable->size);
                        @endphp

                        <div class="mb-2">
                            <h5>Select Size:</h5>
                            <div class="btn-group" role="group" aria-label="Product Variations">
                                @foreach ($sizes as $size)
                                    @php
                                        // Capitalize the first letter of each size and trim any extra spaces
                                        $size = strtoupper(trim($size));
                                    @endphp
                                    <button type="button" class="btn btn-variation btn-outline-dark fw-bold"
                                        onclick="selectVariation(this)">{{ trim($size) }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if ($product->wearable->color)
                        @php
                            $colors = explode(',', $product->wearable->color);
                        @endphp

                        <div class="mt-2">
                            <h5>Select Color:</h5>
                            <div class="btn-group" role="group" aria-label="Product Variations">
                                @foreach ($colors as $color)
                                    @php
                                        // Capitalize the first letter of each size and trim any extra spaces
                                        $color = ucfirst(trim($color));
                                    @endphp
                                    <button type="button" class="btn btn-variation-2 btn-outline-dark fw-bold"
                                        onclick="selectVariation2(this)">{{ trim($color) }}</button>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endsection
        @endif

        @section('mid')
            <div class="quantity-selector mt-4">
                <h5>Quantity:</h5>
                <div class="input-group">
                    <button class="btn btn-outline-dark fw-bold" type="button" onclick="changeQuantity(-1)">-</button>
                    <input type="text" class="form-control" id="quantity" value="1">
                    <button class="btn btn-outline-dark fw-bold" type="button" onclick="changeQuantity(1)">+</button>
                </div>
            </div>

            <div class="pt-5 border-top-0 bg-transparent">
                <div class="text-center text-uppercase">
                    <a class="btn btn-outline-dark btn-add-to-cart mt-auto w-100 fw-bold {{ $product->stock > 0 ? '' : 'disabled' }}"
                        href="#">Add to Cart</a>
                </div>
            </div>

            <div class="product-details mt-5">
                <h5>Product Description:</h5>
                <p style="font-size: 1.2rem;">
                    {{ $product->description }}
                    @if ($product->collectible)
                        <hr /><span style="font-size: 1.2rem;">
                            <h5 style="display: inline; margin: 0;">Supplier:</h5>
                            {{ $product->collectible->supplier }}
                        </span>
                    @endif

                    @if ($product->consumable)
                        <hr /><span style="font-size: 1.2rem;">
                            <h5 style="display: inline; margin: 0;">Expiry Date:</h5>
                            {{ \Carbon\Carbon::parse($product->consumable->expire_date)->format('d-m-Y') }} <br />
                            <h5 style="display: inline; margin: 0;">Portion:</h5>
                            {{ $product->consumable->portion }}
                            @if ($product->consumable->portion > 1)
                                items <br />
                            @elseif ($product->consumable->portion == 1)
                                item <br />
                            @endif
                            @if ($product->consumable->is_halal)
                                <h5 style="display: inline; margin: 0;">Halal:</h5> Yes
                            @else
                                <h5 style="display: inline; margin: 0;">Halal:</h5> No
                            @endif
                        </span>

                    @endif

                    @if ($product->wearable)
                        @if ($product->wearable->user_group)
                            @php
                                $userGroups = explode(',', $product->wearable->user_group);
                                $userGroups = array_map('trim', $userGroups);
                                $userGroups = array_map(function ($group) {
                                    return ucwords(strtolower($group));
                                }, $userGroups);
                                $userGroupsList = implode(', ', $userGroups);
                            @endphp

                            <hr /><span style="font-size: 1.2rem;">
                                <h5 style="display: inline; margin: 0;">Suitable For:</h5>
                                {{ $userGroupsList }}
                            </span>
                        @endif
                    @endif
                </p>
            </div>
        </div>
    </div>

@endsection

@section('bundle')
    <div class="container bundle-deal">
        <h2>Bundle Deal</h2>
        <div class="row">
            <div class="col-md-8">
                <div class="d-flex flex-wrap">
                    @for ($i = 0; $i < 4; $i++)
                        <div class="bundle-item d-flex flex-column mb-3 me-3">
                            <img src="{{ URL('storage/images/pokemon.png') }}" class="img-fluid bundle-image"
                                alt="Product A">
                            <div class="bundle-details mt-2">
                                <h5>Product {{ $i + 1 }}</h5>
                                <h5 class="text-muted original-price">RM 20.00</h5>
                                <h5 class="discounted-price">RM 15.00</h5>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>

            <div class="col-md-4">
                <div class="bundle-summary">
                    <h3>Total Price: RM 60.00</h3>
                    <div class="pt-3 border-top-0 bg-transparent">
                        <div class="text-center text-uppercase">
                            <a class="btn btn-outline-dark btn-add-to-cart mt-auto w-100 fw-bold"
                                href="{{ url('/promotion') }}">View More</a>
                        </div>
                    </div>
                </div>
            </div>
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