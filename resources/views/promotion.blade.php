@extends('layout.shop')

@section('title', 'Promotion')

@section('content')
<div class="flex-shrink-0 p-3 bg-white d-flex flex-column" data-spy="affix" data-offset-top="197">
    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search" name="search" placeholder="Search" aria-label="Search" aria-describedby="search-btn">
                    <button class="btn btn-outline-secondary" type="button" id="search-btn"><i class="fa-solid fa-magnifying-glass"></i></button>
                </div>
            </div>
            <div class="card-body">
                @forelse ($categories as $category)
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0" type="checkbox" value="{{$category->category_name}}">
                    </div>
                    <input type="text" class="form-control" aria-label="Text input with checkbox" value="{{$category->category_name}}" disabled>
                </div>
                @empty
                <div class="alert alert-secondary" role="alert">
                    No available category
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<div class="col-md-9">
    <div class="row" id="promotion_list">
        @forelse ($promotions as $promotion)
        <div class="col-md-2-4 mb-4">
            <a href="{{ route('promotion.details', $promotion->promotion_id) }}" class="text-decoration-none text-dark">
                <div class="card h-100">
                    @if ($promotion->is_new)
                    <div class="badge bg-dark text-white position-absolute w-50 d-flex align-items-center justify-content-center fs-5"
                        style="top: 0.5rem; left: 0rem; border-radius: 0 5px 5px 0;">
                        <span class="fs-5">New</span>
                    </div>
                    @endif

                    <div class="card-img-top">
                        <div class="container">
                            <div class="row pt-3 p-2" style="min-height:250px;">
                                @foreach ($promotion->product_list as $product)
                                @if ($loop->index >= 4)
                                @break
                                @endif
                                <div class="{{count($promotion->product_list) == 1 ? 'col-12' : 'col-6'}} p-0">
                                    <img src="{{ asset('storage/images/products/' . $product->product_id . '/main.png') }}"
                                        class="d-block img-thumbnail border-0" alt="product image">
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text mb-1 fs-5 fs-lg-5 fs-xl-3">{{ $promotion->title }}</p>
                        <h4 class="card-text fw-bold mb-2 fs-5 fs-xl-3">RM {{ $promotion->original_price }}</h4>
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
        @empty
        <div class="col-md-12">
            <div class="alert alert-info" role="alert">
                No promotion available
            </div>
        </div>
        @endforelse
    </div>
    <div class="justify-content-center mt-4">
        {{ $promotions->links() }}
    </div>
</div>
@endsection