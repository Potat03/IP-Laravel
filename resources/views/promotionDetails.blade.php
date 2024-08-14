<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Promotion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    {{-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" /> --}}
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        html {
            -webkit-user-drag: none;
            /* For WebKit browsers (e.g., Chrome, Safari) */
            user-select: none;
        }

        .img-carousel {
            width: 500px;
            height: 500px;
        }

        .img-carousel .carousel-item,
        .img-carousel .carousel-item img {
            height: 100%;

            -webkit-user-drag: none;
            /* For WebKit browsers (e.g., Chrome, Safari) */
            user-select: none;
        }

        .tiny-carousel img {
            height: 100px;
            width: 100px;

            -webkit-user-drag: none;
            /* For WebKit browsers (e.g., Chrome, Safari) */
            user-select: none;
        }

        .tiny-carousel .carousel-inner {
            padding: 1em;
        }

        .tiny-carousel .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
            user-select: none;
        }

        .tiny-carousel .carousel-control-prev,
        .tiny-carousel .carousel-control-next {
            width: 6vh;
            height: 6vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        .tiny-carousel .card-img-top .img {
            user-select: none;
        }

        /* .card img {
            max-width: 100%;
            height: 13em;
            display: flex;
            justify-content: center;
            align-items: center;
        } */

        .tiny-carousel .card img {
            max-height: 100%;
            -webkit-user-drag: none;
            /* For WebKit browsers (e.g., Chrome, Safari) */
            user-select: none;
        }

        @media (min-width: 1025px) {
            .tiny-carousel .carousel-item {
                margin-right: 0;
                flex: 0 0 calc(100%/5);
                display: block;
            }

            .tiny-carousel .carousel-inner {
                display: flex;
            }
        }

        @media (max-width: 1024px) {
            .tiny-carousel .carousel-item {
                margin-right: 0;
                flex: 0 0 calc(100%/3);
                display: block;
            }

            .tiny-carousel .carousel-inner {
                display: flex;
            }

            .tiny-carousel .card img {
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


    <section>
        <div class="container pt-5">
            <div class="row">
                <div class="col-5 justify-content-center d-flex">
                    <div>
                        <div id="product-carousel" class="carousel slide carousel-fade img-carousel">
                            <div class="carousel-inner h-100">
                                <div class="carousel-item active">
                                    <img src={{ URL('storage/images/pokemon.png') }} class="d-block img-fluid" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src={{ URL('storage/images/pinkglock.png') }} class="d-block img-fluid" alt="...">
                                </div>
                                <div class="carousel-item">
                                    <img src={{ URL('storage/images/pika.jpg') }} class="d-block img-fluid" alt="...">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#product-carousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#product-carousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-7">
                    <div class="h3 ps-1">Title</div>
                    <hr>
                    <div>
                    <div class="h6 ps-3">Items :</div>
                        <ul class="list-group list-group-flush px-3">
                            <li class="list-group-item d-flex w-100">An item<span class="ms-auto">x 2</span></li>
                            <li class="list-group-item d-flex w-100">An item 2<span class="ms-auto">x 1</span></li>
                            <li class="list-group-item d-flex w-100">An item 3<span class="ms-auto">x 3</span></li>
                            <li class="list-group-item d-flex w-100">An item 4<span class="ms-auto">x 1</span></li>
                        </ul>
                    </div>
                    <div id="tiny-carousel" class="carousel tiny-carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src={{ URL('storage/images/pokemon.png') }} class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src={{ URL('storage/images/pinkglock.png') }} class="d-block img-fluid" alt="...">
                            </div>
                            <div class="carousel-item">
                                <img src={{ URL('storage/images/pika.jpg') }} class="d-block img-fluid" alt="...">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- jQuery migrate (for compatibility with older jQuery versions) -->
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script defer>
        var imgCarousel = document.querySelector("#img-carousel");
        var multipleCardCarousel = document.querySelector("#tiny-carousel");


        if (window.matchMedia("(min-width: 1025px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#tiny-carousel .carousel-control-prev").hide();
            $("#tiny-carousel .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 5) {
                    scrollPosition += cardWidth * 5;
                    $("#tiny-carousel .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#tiny-carousel .carousel-control-prev").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 6) {
                        $("#tiny-carousel .carousel-control-next").hide();
                    }
                }
            });
            $("#tiny-carousel .carousel-control-prev").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 5;
                    $("#tiny-carousel .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#tiny-carousel .carousel-control-prev").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 6) {
                        $("#tiny-carousel .carousel-control-next").show();
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
            $("#tiny-carousel .carousel-control-prev").hide();
            $("#tiny-carousel .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 3) {
                    scrollPosition += cardWidth * 3;
                    $("#tiny-carousel .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition > 0) {
                        $("#tiny-carousel .carousel-control-prev").show();
                    }
                    if (scrollPosition > carouselWidth - cardWidth * 3) {
                        $("#tiny-carousel .carousel-control-next").hide();
                    }
                }
            });
            $("#tiny-carousel .carousel-control-prev").on("click", function() {
                if (scrollPosition > 0) {
                    scrollPosition -= cardWidth * 3;
                    $("#tiny-carousel .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
                    if (scrollPosition <= 0) {
                        $("#tiny-carousel .carousel-control-prev").hide();
                    }
                    if (scrollPosition < carouselWidth - cardWidth * 3) {
                        $("#tiny-carousel .carousel-control-next").show();
                    }
                }
            });
        } else {
            $(multipleCardCarousel).addClass("slide");
        }

        document.addEventListener("DOMContentLoaded", function() {
            const scrollContainer = document.querySelector('#tiny-carousel .carousel-inner');
            const tinyCarouselItems = document.querySelectorAll('#tiny-carousel .carousel-item img');
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
            });

            tinyCarouselItems.forEach((item, index) => {
                item.addEventListener('click', function() {
                    const mainCarousel = document.querySelector('#product-carousel');
                    console.log(index)
                    const bootstrapCarousel = new bootstrap.Carousel(mainCarousel);
                    bootstrapCarousel.to(index);
                });
            });
        });
    </script>

</body>

</html>