{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        .container {
            max-width: 75%;
            margin: 0 auto;
        }

        .carousel-inner {
            padding: 1em;
        }

        .card {
            margin: 0 0.5em;
            box-shadow: 2px 6px 8px 0 rgba(22, 22, 26, 0.18);
            border: none;
        }

        .carousel-control-prev,
        .carousel-control-next {
            background-color: #e1e1e1;
            width: 6vh;
            height: 6vh;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
        }

        @media (min-width: 768px) {
            .carousel-item {
                margin-right: 0;
                flex: 0 0 calc(100%/5);
                display: block;
            }

            .carousel-inner {
                display: flex;
            }
        }

        .card .img-wrapper {
            max-width: 100%;
            height: 13em;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card img {
            max-height: 100%;
        }

        @media (max-width: 767px) {
            .card .img-wrapper {
                height: 17em;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="pb-4 text-uppercase">Best Sellers in Japan</h1>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-link fw-bold">View all</a>
            </div>
        </div>

        <div id="carouselExampleControls" class="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }} class="d-block w-100"
                                alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 1</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }} class="d-block w-100"
                                alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 2</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }} class="d-block w-100"
                                alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 3</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }} class="d-block w-100"
                                alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 4</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                                class="d-block w-100" alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 5</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                                class="d-block w-100" alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 6</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                                class="d-block w-100" alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 7</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                                class="d-block w-100" alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 8</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card h-100">
                        <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                                class="d-block w-100" alt="product image" width="280" height="300"> </div>
                        <div class="card-body">
                            <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 9</p>
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
                                    class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                    Cart</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                  <div class="card h-100">
                      <div class="card-img-top"><img src={{ URL('storage/images/pokemon.png') }}
                              class="d-block w-100" alt="product image" width="280" height="300"> </div>
                      <div class="card-body">
                          <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">Product 10</p>
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
                                  class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to
                                  Cart</a>
                          </div>
                      </div>
                  </div>
              </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- jQuery migrate (for compatibility with older jQuery versions) -->
    <script src="https://code.jquery.com/jquery-migrate-3.3.2.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        var multipleCardCarousel = document.querySelector(
            "#carouselExampleControls"
        );
        if (window.matchMedia("(min-width: 768px)").matches) {
            var carousel = new bootstrap.Carousel(multipleCardCarousel, {
                interval: false,
            });
            var carouselWidth = $(".carousel-inner")[0].scrollWidth;
            var cardWidth = $(".carousel-item").width();
            var scrollPosition = 0;
            $("#carouselExampleControls .carousel-control-next").on("click", function() {
                if (scrollPosition < carouselWidth - cardWidth * 5) {
                    scrollPosition += cardWidth * 5;
                    $("#carouselExampleControls .carousel-inner").animate({
                            scrollLeft: scrollPosition
                        },
                        600
                    );
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
                }
            });
        } else {
            $(multipleCardCarousel).addClass("slide");
        }
    </script>
</body>

</html>
