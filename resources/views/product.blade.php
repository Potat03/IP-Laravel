<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Product Detail</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    <style>
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
            /* Increase font size for product name */
        }

        .product-info h4 {
            font-size: 1.5rem;
            /* Increase font size for price */
        }

        .product-info h5 {
            font-size: 1.3rem;
            /* Increase font size for product variation */
        }

        .product-info .d-flex {
            font-size: 1.2rem;
            /* Increase font size for rating */
        }

        .product-details {
            margin-top: 10px;
            /* Reduce space between product info and product details */
        }

        /* Variation Button Styling */
        .btn-variation {
            /* Match border color to primary color */
            background-color: #ffffff;
            /* White background for default state */
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
            /* Adjust space below each item */
            padding-right: 30px;
            /* Space for the plus symbol */
        }

        .bundle-item:not(:last-child)::after {
            content: '+';
            position: absolute;
            top: 25%;
            /* Adjust this value to move the plus symbol higher */
            right: -3%;
            transform: translateY(0);
            /* Remove vertical centering */
            font-size: 2.5rem;
            /* Adjust the size of the plus symbol */
        }

        .bundle-image {
            max-width: 150px;
            /* Adjust this value as needed to increase the image size */
            height: auto;
            /* Maintain aspect ratio */
            object-fit: cover;
            /* Ensure the image covers the area while maintaining aspect ratio */
        }

        .bundle-details {
            text-align: center;
            /* Center-align text within the details section */
        }

        .price {
            font-size: 1rem;
        }

        .original-price {
            text-decoration: line-through;
            /* Crosses out the original price */
        }

        .discounted-price {
            font-size: 1.3rem;
            /* Larger size for the discounted price */
            color: #dc3545;
            /* Make the discounted price stand out */
        }

        .bundle-summary {
            text-align: center;
            /* Center-align the summary */
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
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container px-4 px-lg-5">
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#!">All Products</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#!">Popular Items</a></li>
                            <li><a class="dropdown-item" href="#!">New Arrivals</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="bi-cart-fill me-1"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Product Detail Section -->
    <div class="container product-detail-container">
        <!-- Product Image -->
        <div class="product-image">
            <img src="{{ URL('storage/images/pokemon.png') }}" class="img-fluid" alt="Product Image">
        </div>

        <!-- Product Info -->
        <div class="product-info">
            <div class="mb-5">
                <h1 class="fw-bold">Product Name</h1>
                <h4 class="text-muted">RM 40.00</h4>
                <div class="d-flex align-items-center text-warning">
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <i class="bi bi-star-fill me-1"></i>
                    <span class="text-dark ms-2">(20)</span>
                </div>
                <h4 class="text-muted pt-2">In Stock</h4>
            </div>

            <!-- Product Variation -->
            <div class="mt-1">
                <h5>Select Variation:</h5>
                <div class="btn-group" role="group" aria-label="Product Variations">
                    <button type="button" class="btn btn-variation btn-outline-dark fw-bold"
                        onclick="selectVariation(this)">Small</button>
                    <button type="button" class="btn btn-variation btn-outline-dark fw-bold"
                        onclick="selectVariation(this)">Medium</button>
                    <button type="button" class="btn btn-variation btn-outline-dark fw-bold"
                        onclick="selectVariation(this)">Large</button>
                    <button type="button" class="btn btn-variation btn-outline-dark fw-bold"
                        onclick="selectVariation(this)">Xtra Large</button>
                </div>
            </div>

            <!-- Quantity Selector -->
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
                    <a class="btn btn-outline-dark btn-add-to-cart mt-auto w-100 fw-bold" href="#">Add to
                        Cart</a>
                </div>
            </div>

            <!-- Product Details -->
            <div class="product-details mt-5">
                <h5>Product Details:</h5>
                <p style="font-size: 1.2rem;">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce auctor eros ac eros vehicula,
                    eget vehicula lectus scelerisque. Suspendisse nec efficitur sem, in luctus risus.
                </p>
            </div>
        </div>
    </div>

    <!-- Bundle Deal Section -->
    <div class="container bundle-deal">
        <h2>Bundle Deal</h2>
        <div class="row">
            <!-- Bundle Products -->
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
                    <!-- Add more bundle items as needed -->
                </div>
            </div>

            <!-- Bundle Summary -->
            <div class="col-md-4">
                <div class="bundle-summary">
                    <h3>Total Price: RM 60.00</h3>
                    <div class="pt-3 border-top-0 bg-transparent">
                        <div class="text-center text-uppercase">
                            <a class="btn btn-outline-dark btn-add-to-cart mt-auto w-100 fw-bold" href="{{ url('/promotion') }}">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script>
        function selectVariation(element) {
            // Remove active class from all variation buttons
            var buttons = document.querySelectorAll('.btn-variation');
            buttons.forEach(function(button) {
                button.classList.remove('active');
            });

            // Add active class to the clicked button
            element.classList.add('active');
        }

        function changeQuantity(amount) {
            var quantityInput = document.getElementById('quantity');
            var currentQuantity = parseInt(quantityInput.value);
            var newQuantity = currentQuantity + amount;

            if (newQuantity < 1) {
                newQuantity = 1; // Prevent quantity from going below 1
            }

            quantityInput.value = newQuantity;
        }
    </script>
</body>

</html>
