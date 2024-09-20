{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

@extends('layout.shop')

@section('title', 'Shop')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('content')
    {{-- <div class="flex-shrink-0 p-3 bg-white d-flex flex-column">
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search"
                            aria-label="Search" aria-describedby="search-btn">
                        <button class="btn btn-outline-secondary" type="button" id="search-btn"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>

                <div class="card-body">
                    <!-- Price and Rating Range -->
                    <div class="mb-3">
                        <label for="sort-by" class="form-label">Sort By</label>
                        <select class="form-select" id="sort-by" name="sort-by">
                            <option value="">Select</option>
                            <option value="price-low-high">Price: Low to High</option>
                            <option value="price-high-low">Price: High to Low</option>
                            <option value="rating-high-low">Rating: Highest to Lowest</option>
                            <option value="rating-low-high">Rating: Lowest to Highest</option>
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div> --}}
    <div class="col-md-9">
        <div class="row" id="product-list">
            @forelse ($products as $product)
                @if ($product->status == 'active')
                    <div class="col-md-2-4 mb-4">
                        <a href="{{ url('product/' . $product->product_id) }}" class="text-decoration-none text-dark">
                            <div class="card h-100">
                                @if ($product->is_new)
                                    <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5"
                                        style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;">
                                        {{-- <span class="fs-5">Best Seller</span> --}}
                                        <span class="fs-5">New</span>
                                    </div>
                                @endif

                                <div class="card-img-top" style="height: 300px; width: 100%;">
                                    @php
                                        $mainImage =
                                            $mainImages[$product->product_id] ??
                                            Storage::url('public/images/products/default.jpg');
                                    @endphp

                                    <img src="{{ $mainImage }}" class="d-block w-100"
                                        style="height: 100%; object-fit: cover;" alt="{{ $product->name }}">
                                </div>
                                <div class="card-body">
                                    <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">{{ $product->name }}</p>
                                    <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM {{ $product->price }}</h4>
                                    <div class="d-flex justify-content align-items-center small text-warning">
                                        @php
                                            $averageRating = $product->averageRating ?? 0;
                                            $reviewsCount = $product->reviewsCount ?? 0;

                                            $fullStars = floor($averageRating);
                                            $halfStar = $averageRating - $fullStars >= 0.5;
                                        @endphp
                                        @for ($i = 0; $i < $fullStars; $i++)
                                            <i class="fa-solid fa-star me-1"></i>
                                        @endfor
                                        @if ($halfStar)
                                            <i class="fa-solid fa-star-half-stroke me-1"></i>
                                        @endif
                                        @for ($i = $fullStars + ($halfStar ? 1 : 0); $i < 5; $i++)
                                            <i class="fa-regular fa-star me-1"></i>
                                        @endfor
                                        <span class="text-dark ms-lg-2">({{ $reviewsCount }})</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @empty
                <p>No products found.</p>
            @endforelse

            <div class="justify-content-center mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection

<script>
    // $(document).ready(function() {
    //     // Listen for filter changes
    //     $('#price-sort, #available, #rating-filter, #new-arrival, #search').on('change keyup', function() {
    //         filterProducts();
    //     });

    //     // AJAX function to get filtered products
    //     function filterProducts() {
    //         let priceSort = $('#price-sort').val();
    //         let available = $('#available').is(':checked') ? 1 : 0;
    //         let rating = $('#rating-filter').val();
    //         let newArrival = $('#new-arrival').is(':checked') ? 1 : 0;
    //         let search = $('#search').val();

    //         console.log('Search:', search); // Debugging line

    //         $.ajax({
    //             url: '/shop',
    //             method: 'GET',
    //             data: {
    //                 price_sort: priceSort,
    //                 available: available,
    //                 rating: rating,
    //                 new_arrival: newArrival,
    //                 search: search
    //             },
    //             success: function(response) {
    //                 $('#product-list').html(response);
    //             }
    //         });
    //     }
    // });
</script>
