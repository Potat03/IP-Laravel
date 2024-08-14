<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Promotion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js','resources/css/app.css'])
    <style>
        /* .bg-image {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6)), URL('storage/images/banner3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        } */

        .mainthree {
            background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.6));
        }

        main {
            display: flex;
            min-height: 100vh;
        }

        /* Slideshow text styling */
        .slideshow-text {
            display: inline-block;
            opacity: 0;
            transition: opacity 1s ease-in-out;
            /* Adjust transition to 1 second */
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Adjust opacity as needed */
            z-index: 1;
        }

        .show {
            opacity: 1;
        }

        @keyframes fadeInOut {
            0% {
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            30% {
                opacity: 1;
            }

            40% {
                opacity: 0;
            }

            100% {
                opacity: 0;
            }
        }

        .custom-btn {
            border-radius: 50px;
            border: 3px solid whitesmoke;
            padding-left: 3rem;
            padding-right: 3rem;
            padding-top: 1rem;
            padding-bottom: 1rem;
            transition: background-color 0.2s ease, color 0.2s ease;
            background-color: rgba(221, 216, 216, 0.2);
        }

        .custom-btn:hover {
            background-color: whitesmoke;
            border-color: whitesmoke;
            color: black;
        }

        .card-showcase {
            overflow: hidden;
        }

        .card-img {
            object-fit: cover;
            transition: transform .2s;
        }

        .card-showcase:hover .card-img {
            transform: scale(1.5);
        }

        .carousel-inner {
            padding: 1em;
        }

        .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
            user-select: none;
        }

        .carousel-control-prev,
        .carousel-control-next {
            width: 6vh;
            height: 6vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .card-img-top .img {
            user-select: none;
        }

        /* .card img {
            max-width: 100%;
            height: 13em;
            display: flex;
            justify-content: center;
            align-items: center;
        } */

        .card img {
            max-height: 100%;
            -webkit-user-drag: none;
            /* For WebKit browsers (e.g., Chrome, Safari) */
            user-select: none;
        }

        .card-text {
            user-select: none;
        }

        .card .btn {
            -webkit-user-drag: none;
            user-select: none;
        }

        @media (min-width: 1025px) {
            .carousel-item {
                margin-right: 0;
                flex: 0 0 calc(100%/5);
                display: block;
            }

            .carousel-inner {
                display: flex;
            }
        }

        @media (max-width: 1024px) {
            .carousel-item {
                margin-right: 0;
                flex: 0 0 calc(100%/3);
                display: block;
            }

            .carousel-inner {
                display: flex;
            }

            .card img {
                height: 17em;
            }
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


    <main class="pt-5">
        <div class="flex-shrink-0 p-3 bg-white d-flex flex-column">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" id="search" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-btn">
                            <button class="btn btn-outline-secondary" type="button" id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="category" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="category" disabled>
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input">
                            </div>
                            <input type="text" class="form-control" aria-label="Text input with checkbox" value="category" disabled>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex-fill">
            <div class="container">
                <div class="row">
                    @for($i = 0 ; $i < 5; $i++)
                        <div class="col-xl-3 col-lg-4 col-md-6 col-8 pb-5 mx-auto mx-md-0 ">
                        <div class="card h-100">
                            <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5" style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;"><span class="fs-4">New</span></div>
                            <div class="card-img-top">
                                <div class="container">
                                    <div class="row pt-3 p-2">
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
                            </div>
                            <div class="card-body">
                                <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Promotion {{$i}}</p>
                                <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM90.00</h4>
                                <div class="px-1 py-2">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item d-flex w-100">An item<span class="ms-auto">x 2</span></li>
                                        <li class="list-group-item d-flex w-100">An item 2<span class="ms-auto">x 1</span></li>
                                        <li class="list-group-item d-flex w-100">An item 3<span class="ms-auto">x 3</span></li>
                                        <li class="list-group-item d-flex w-100">An item 4<span class="ms-auto">x 1</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
                                <div class="text-center text-uppercase"><a
                                        class="btn btn-outline-dark mt-auto w-100 fw-bold py-3 py-md-2" href="#">Add to
                                        Cart</a>
                                </div>
                            </div>
                        </div>
                </div>
                @endfor
                <div class="col-xl-3 col-lg-4 col-md-6 col-8 pb-5 mx-auto mx-md-0 ">
                    <div class="card h-100">
                        <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5" style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;"><span class="fs-4">New</span></div>
                        <div class="card-img-top">
                            <div class="container">
                                <div class="row pt-3">
                                    <div class="col-6 p-0">
                                        <img src={{ URL('storage/images/pokemon.png') }}
                                            class="d-block img-fluid" alt="product image">
                                    </div>

                                    <div class="col-6 p-0">
                                        <img src={{ URL('storage/images/consumable.png') }}
                                            class="d-block img-fluid" alt="product image">
                                    </div>

                                    <div class="col-6 p-0">
                                        <img src={{ URL('storage/images/collectible.png') }}
                                            class="d-block img-fluid" alt="product image">
                                    </div>

                                    <div class="col-6 p-0">
                                        <img src={{ URL('storage/images/pika.jpg') }}
                                            class="d-block img-fluid" alt="product image">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Promotion {{$i}}</p>
                            <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM90.00</h4>
                            <div class="px-1 py-2">
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex w-100">An item<span class="ms-auto">x 2</span></li>
                                    <li class="list-group-item d-flex w-100">An item 2<span class="ms-auto">x 1</span></li>
                                    <li class="list-group-item d-flex w-100">An item 3<span class="ms-auto">x 3</span></li>
                                    <li class="list-group-item d-flex w-100">An item 4<span class="ms-auto">x 1</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
                            <div class="text-center text-uppercase"><a
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold py-3 py-md-2" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- jQuery migrate (for compatibility with older jQuery versions) -->
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
    </script>
</body>

</html>