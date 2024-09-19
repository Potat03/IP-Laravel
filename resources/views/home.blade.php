<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Futatabi</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
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

        .container {
            max-width: 1920px;
            min-width: 1024px;
            padding: 32px 48px;
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
    @include('header')

    <!-- Header -->
    <header class="bg-dark py-5" style="min-height: 600px; display: flex; align-items: center; user-select: none;">
        <div class="overlay"></div> <!-- Add this overlay element -->
        <div class="container px-4 px-lg-5">
            <div class="text-center text-white" style="user-select: none; position: relative; z-index: 2;">
                <h1 class="display-1 fw-bolder">Futatabi</h1>
                <p class="lead fs-2 fw-medium text-white-50 mb-0 text-slideshow">
                    <span class="slideshow-text fs-2">Malaysia Best Selling Japanese Store</span>
                </p>
            </div>
        </div>
    </header>

    <section>
        <div class="container mt-5">
            <div class="row">
                <!-- Card 1 -->
                <div class="col-md-4 align-self-center">
                    <div class="card card-showcase mb-4">
                        <img class="card-img" src={{ URL('storage/images/collectible.png') }} alt="Card image">
                        <div class="card-img-overlay mainthree text-white">
                            <div class="m-5 py-5">
                                <h5 class="card-title fw-bold display-4 mb-0">Collectible</h5>
                                <p class="card-text display-5">収集品</p>
                                <a href="{{ url('/shop/collectible') }}"
                                    class="btn btn-outline-light btn-lg mt-4 custom-btn fw-bold fs-3">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="col-md-4 align-self-center">
                    <div class="card card-showcase mb-4">
                        <img class="card-img" src={{ URL('storage/images/consumable.png') }} alt="Card image">
                        <div class="card-img-overlay mainthree text-white">
                            <div class="m-5 py-5">
                                <h5 class="card-title fw-bold display-4 mb-0">Consumable</h5>
                                <p class="card-text display-5">消耗品</p>
                                <a href="{{ url('/shop/consumable') }}"
                                    class="btn btn-outline-light btn-lg mt-4 custom-btn fw-bold fs-3">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="col-md-4 align-self-center">
                    <div class="card card-showcase mb-4">
                        <img class="card-img" src={{ URL('storage/images/wearable.png') }} alt="Card image">
                        <div class="card-img-overlay mainthree text-white">
                            <div class="m-5 py-5">
                                <h5 class="card-title fw-bold display-4 mb-0">Wearable</h5>
                                <p class="card-text display-5">着用可能</p>
                                <a href="{{ url('/shop/wearable') }}"
                                    class="btn btn-outline-light btn-lg mt-4 custom-btn fw-bold fs-3">View
                                    More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products -->
    <!-- New Arrivals -->
    <section>
        <div class="container p-3">
            <div class="pt-4 row align-items-center">
                <div class="col">
                    <h1 class="pb-4 text-uppercase" style="padding-left: 25px;">New Arrivals</h1>
                </div>
                <div class="col-auto">
                    <a href="{{ route('shop.newArrivals') }}" class="btn btn-link fs-4">View all</a>
                </div>
            </div>

            <div id="carouselExampleControls" class="carousel">
                <div class="carousel-inner">
                    @foreach ($newArrivals as $index => $data)
                        @php
                            $product = $data['product'];
                            $mainImage = $data['mainImage'];
                            $averageRating = $data['averageRating'];
                            $reviewsCount = $data['reviewsCount'];
                        @endphp
                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                            <a href="{{ url('product/' . $product->product_id) }}"
                                class="text-decoration-none text-dark" draggable="false">
                                <div class="card h-100">
                                    <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5"
                                        style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;">
                                        <span class="fs-4">New</span>
                                    </div>
                                    <div class="card-img-top" style="height: 300px; width: 100%;">
                                        <!-- Use the main image URL -->
                                        @if ($mainImage)
                                            <img src="{{ $mainImage }}" class="d-block w-100"
                                                style="height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ URL('storage/images/products/default.jpg') }}"
                                                class="d-block w-100" style="height: 100%; object-fit: cover;"
                                                alt="{{ $product->name }}">
                                        @endif
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">{{ $product->name }}</p>
                                        <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM {{ $product->price }}</h4>
                                        <div class="d-flex justify-content align-items-center small text-warning">
                                            @php
                                                $fullStars = floor($averageRating);
                                                $halfStar = $averageRating - $fullStars >= 0.5;
                                            @endphp
                                            @for ($i = 0; $i < $fullStars; $i++)
                                                <i class="bi bi-star-fill me-1"></i>
                                            @endfor
                                            @if ($halfStar)
                                                <i class="bi bi-star-half me-1"></i>
                                            @endif
                                            @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                                <i class="bi bi-star me-1"></i>
                                            @endfor
                                            <span class="text-dark ms-lg-2">({{ $reviewsCount }})</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <button class="carousel-control-prev bg-dark" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next bg-dark" type="button" data-bs-target="#carouselExampleControls"
                    data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
    </section>

    <!-- Best Sellers -->
    {{-- <section>
        <div class="container p-3">
            <div class="pt-4 row align-items-center">
                <div class="col">
                    <h1 class="pb-4 text-uppercase" style="padding-left: 25px;">Best Sellers in Japan</h1>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-link fs-4">View all</a>
                </div>
            </div>

            <div id="carouselExampleControls2" class="carousel">
                <div class="carousel-inner carousel-inner2">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                            <a href="{{ url('product') }}" class="text-decoration-none text-dark" draggable="false">
                                <div class="card h-100">
                                    <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5"
                                        style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;"><span
                                            class="fs-4">Best Seller</span></div>
                                    <div class="card-img-top"><img src="{{ URL('storage/images/pokemon.png') }}"
                                            class="d-block w-100" alt="product image" width="280" height="300">
                                    </div>
                                    <div class="card-body">
                                        <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product {{ $i + 1 }}</p>
                                        <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM40.00 - RM80.00</h4>
                                        <div class="d-flex justify-content align-items-center small text-warning">
                                            <i class="bi bi-star-fill me-1"></i>
                                            <i class="bi bi-star-fill me-1"></i>
                                            <i class="bi bi-star-fill me-1"></i>
                                            <i class="bi bi-star-fill me-1"></i>
                                            <i class="bi bi-star-fill me-1"></i>
                                            <span class="text-dark ms-lg-2">(20)</span>
                                        </div>
                                    </div>
                                    <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
                                        <div class="text-center text-uppercase"><a
                                                class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add
                                                to
                                                Cart</a>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endfor
                </div>
                <button class="carousel-control-prev carousel-control-prev2 bg-dark" type="button"
                    data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next carousel-control-next2 bg-dark" type="button"
                    data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section> --}}

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- jQuery migrate (for compatibility with older jQuery versions) -->
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        var multipleCardCarousel = document.querySelector(
            "#carouselExampleControls"
        );
        if (window.matchMedia("(min-width: 1025px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#carouselExampleControls .carousel-control-prev").hide();
            $("#carouselExampleControls .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 5) {
                    scrollPosition += cardWidth * 5;
                    $("#carouselExampleControls .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#carouselExampleControls .carousel-control-prev").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 6) {
                        $("#carouselExampleControls .carousel-control-next").hide();
                    }
                }
            });
            $("#carouselExampleControls .carousel-control-prev").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 5;
                    $("#carouselExampleControls .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#carouselExampleControls .carousel-control-prev").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 6) {
                        $("#carouselExampleControls .carousel-control-next").show();
                    }
                }
            });
        } else if (window.matchMedia("(min-width: 1024px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#carouselExampleControls .carousel-control-prev").hide();
            $("#carouselExampleControls .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 3) {
                    scrollPosition += cardWidth * 3;
                    $("#carouselExampleControls .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#carouselExampleControls .carousel-control-prev").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 3) {
                        $("#carouselExampleControls .carousel-control-next").hide();
                    }
                }
            });
            $("#carouselExampleControls .carousel-control-prev").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 3;
                    $("#carouselExampleControls .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#carouselExampleControls .carousel-control-prev").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 3) {
                        $("#carouselExampleControls .carousel-control-next").show();
                    }
                }
            });
        } else {
            $(multipleCardCarousel).addClass("slide");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.querySelector('.carousel-inner');
            const prevButton = document.querySelector('#carouselExampleControls .carousel-control-prev');
            const nextButton = document.querySelector('#carouselExampleControls .carousel-control-next');
            let isMouseDown = false;
            let startX, scrollLeft;

            scrollContainer.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                startX = e.pageX - scrollContainer.offsetLeft;
                scrollLeft = scrollContainer.scrollLeft;
            });

            scrollContainer.addEventListener('mouseleave', () => {
                isMouseDown = false;
            });

            scrollContainer.addEventListener('mouseup', () => {
                isMouseDown = false;
            });

            scrollContainer.addEventListener('mousemove', (e) => {
                if (!isMouseDown) return;
                e.preventDefault();
                const x = e.pageX - scrollContainer.offsetLeft;
                const walk = (x - startX) * 2; //scroll-fast
                scrollContainer.scrollLeft = scrollLeft - walk;

                // Update button visibility
                const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                if (scrollContainer.scrollLeft <= 0) {
                    prevButton.style.display = 'none';
                } else {
                    prevButton.style.display = 'block';
                }
                if (scrollContainer.scrollLeft >= maxScrollLeft) {
                    nextButton.style.display = 'none';
                } else {
                    nextButton.style.display = 'block';
                }
            });
        });

        //2
        var multipleCardCarousel = document.querySelector(
            "#carouselExampleControls2"
        );
        if (window.matchMedia("(min-width: 1025px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner2")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#carouselExampleControls2 .carousel-control-prev2").hide();
            $("#carouselExampleControls2 .carousel-control-next2").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 5) {
                    scrollPosition += cardWidth * 5;
                    $("#carouselExampleControls2 .carousel-inner2").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#carouselExampleControls2 .carousel-control-prev2").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 6) {
                        $("#carouselExampleControls2 .carousel-control-next2").hide();
                    }
                }
            });
            $("#carouselExampleControls2 .carousel-control-prev2").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 5;
                    $("#carouselExampleControls2 .carousel-inner2").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#carouselExampleControls2 .carousel-control-prev2").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 6) {
                        $("#carouselExampleControls2 .carousel-control-next2").show();
                    }
                }
            });
        } else if (window.matchMedia("(min-width: 1024px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner2")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#carouselExampleControls2 .carousel-control-prev2").hide();
            $("#carouselExampleControls2 .carousel-control-next2").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 3) {
                    scrollPosition += cardWidth * 3;
                    $("#carouselExampleControls2 .carousel-inner2").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#carouselExampleControls2 .carousel-control-prev2").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 3) {
                        $("#carouselExampleControls2 .carousel-control-next2").hide();
                    }
                }
            });
            $("#carouselExampleControls2 .carousel-control-prev2").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 3;
                    $("#carouselExampleControls2 .carousel-inner2").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#carouselExampleControls2 .carousel-control-prev2").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 3) {
                        $("#carouselExampleControls2 .carousel-control-next2").show();
                    }
                }
            });
        } else {
            $(multipleCardCarousel).addClass("slide");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.querySelector('.carousel-inner2');
            const prevButton = document.querySelector('#carouselExampleControls2 .carousel-control-prev2');
            const nextButton = document.querySelector('#carouselExampleControls2 .carousel-control-next2');
            let isMouseDown = false;
            let startX, scrollLeft;

            scrollContainer.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                startX = e.pageX - scrollContainer.offsetLeft;
                scrollLeft = scrollContainer.scrollLeft;
            });

            scrollContainer.addEventListener('mouseleave', () => {
                isMouseDown = false;
            });

            scrollContainer.addEventListener('mouseup', () => {
                isMouseDown = false;
            });

            scrollContainer.addEventListener('mousemove', (e) => {
                if (!isMouseDown) return;
                e.preventDefault();
                const x = e.pageX - scrollContainer.offsetLeft;
                const walk = (x - startX) * 2; //scroll-fast
                scrollContainer.scrollLeft = scrollLeft - walk;

                // Update button visibility
                const maxScrollLeft = scrollContainer.scrollWidth - scrollContainer.clientWidth;
                if (scrollContainer.scrollLeft <= 0) {
                    prevButton.style.display = 'none';
                } else {
                    prevButton.style.display = 'block';
                }
                if (scrollContainer.scrollLeft >= maxScrollLeft) {
                    nextButton.style.display = 'none';
                } else {
                    nextButton.style.display = 'block';
                }
            });
        });

        let slideIndex = 0;
        const texts = [
            "Malaysia Best-Selling Japanese Store",
            "Discover Authentic Japanese Products",
            "Experience Japan at Your Doorstep"
        ];
        const slideText = document.querySelector(".slideshow-text");

        function showSlides() {
            slideText.classList.remove("show"); // Start fade-out

            setTimeout(() => {
                slideText.textContent = texts[slideIndex]; // Update text content
                slideText.classList.add("show"); // Start fade-in
            }, 1000); // Wait for fade-out to complete (1 second)

            slideIndex++;
            if (slideIndex >= texts.length) {
                slideIndex = 0; // Loop back to the first text
            }

            setTimeout(showSlides, 4000); // Change text every 4 seconds
        }

        showSlides();
    </script>
</body>

</html>
