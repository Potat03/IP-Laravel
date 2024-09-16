@forelse ($products as $product)
    @if ($product->status == 'active')
        <div class="col-md-2-4 mb-4">
            <a href="{{ url('product/' . $product->product_id) }}" class="text-decoration-none text-dark">
                <div class="card h-100">
                    @if ($product->is_new)
                        <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5"
                            style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;">
                            <span class="fs-5">New</span>
                        </div>
                    @endif

                    <div class="card-img-top">
                        <img src="{{ URL('storage/images/pokemon.png') }}" class="d-block w-100"
                            alt="product image" width="280" height="300">
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">{{ $product->name }}</p>
                        <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM {{ $product->price }}</h4>
                        <div class="d-flex justify-content align-items-center small text-warning">
                            @for ($i = 0; $i < 5; $i++)
                                <i class="bi bi-star-fill me-1"></i>
                            @endfor
                            <span class="text-dark ms-lg-2">(20)</span>
                        </div>
                    </div>
                    <div class="card-footer p-3 pt-0 border-top-0 bg-transparent">
                        <div class="text-center text-uppercase">
                            <a class="btn btn-outline-dark mt-auto w-100 fw-bold" href="#">Add to Cart</a>
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
