<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>@yield('title', 'Shop')</title>
    @include('partials.fontawesome')
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])
    @stack('styles')
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
    @include('header')

    <main class="pt-5">
        @if (View::hasSection('prodTitle'))
            @yield('prodTitle')
        @endif

        @if (request()->is('shop'))
            <div class="flex-shrink-0 p-3 bg-white d-flex flex-column">
                <div class="container">
                    <div class="card">
                        <div class="card-header">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" id="search" name="search"
                                    placeholder="Search" aria-label="Search" aria-describedby="search-btn">
                                <button class="btn btn-outline-secondary" type="button" id="search-btn"><i
                                        class="fa-solid fa-magnifying-glass"></i></button>
                            </div>
                        </div>
                        <div class="card-body">
                            @foreach ($categories as $category)
                                <div class="input-group mb-3">
                                    <div class="input-group-text">
                                        <input class="form-check-input mt-0" type="checkbox"
                                            value="{{ $category->category_name }}"
                                            aria-label="Checkbox for {{ $category->category_name }}"
                                            id="category-{{ $category->category_name }}">
                                    </div>
                                    <input type="text" class="form-control" aria-label="Text input with checkbox"
                                        value="{{ $category->category_name }}" disabled>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex-shrink-0 p-3 bg-white d-flex flex-column">
            <div class="container">
                <div class="card">
                </div>
            </div>
        </div>

        @yield('content')
    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @yield('script')

    <script>
        $(document).ready(function() {
            $('#search, .form-check-input').on('change keyup', function() {
                filterProducts();
            });

            function filterProducts() {
                let search = $('#search').val();
                let categories = [];
                $('.form-check-input:checked').each(function() {
                    categories.push($(this).val());
                });

                let url = window.location.pathname;

                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        search: search,
                        categories: categories
                    },
                    success: function(response) {
                        $('#product-list').html(response);
                    }
                });
            }
        });
    </script>

</body>

</html>
