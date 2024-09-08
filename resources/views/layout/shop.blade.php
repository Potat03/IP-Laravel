<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Shop')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
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
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, 0.5);
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
            user-select: none;
        }

        .card-text {
            user-select: none;
        }

        .card .btn {
            -webkit-user-drag: none;
            user-select: none;
        }

        .col-md-2-4 {
            flex: 0 0 calc(100% / 5);
            max-width: calc(100% / 5);
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
        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script></script>
</body>

</html>
