<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header</title>
    @include('partials.fontawesome')

    <style>
        .nav-link:hover,
        .nav-item:hover {
            color: darkred !important;
        }
    </style>
</head>


<body class="headerBody">
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container px-4 bg-light">
            <a class="navbar-brand" href="#!">Futatabi</a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('/home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#!">About</a>
                    </li>
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

                <!-- Cart -->
                <form class="d-flex">
                    <button class="btn btn-outline-dark" type="submit">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Cart
                        <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
                    </button>
                </form>

                <ul class="navbar-nav mb-lg-0">
                    <!-- Profile or Sign-in -->
                    @auth('customer')
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-user"></i> Profile
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                                <li><a class="dropdown-item" href="{{ url('/profileSec') }}">User Profile</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('auth.logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <a href="{{ url('/userlogin') }}">
                            <button class="btn btn-outline-dark mx-lg-2">
                                <i class="fa-solid fa-sign-in"></i> Sign in
                            </button>
                        </a>
                    @endauth

                </ul>
            </div>
        </div>
    </nav>
</body>

</html>
