{{-- 
    Author: Lim Weng Ni
    Date: 20/09/2024
--}}

@extends('admin.layout.main')

@push('product', 'class="active"')

@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
@endsection

@section('css')
    <style>
        .btn {
            font-weight: 600;
        }
    </style>
@endsection

@section('prev_page', route('admin.main'))
@section('title', 'Product')
@section('page_title', 'Product')
@section('page_gm', 'Product List')

@section('content')
    <div>
        <div class="px-2 py-3">
            <h1>Product</h1>
            <div class="nav-status text-muted fw-bold">Home > Product</div>
        </div>
    </div>
    <div class="card shadow-sm p-3">
        <div class="card-body">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="products-tab" data-bs-toggle="tab" href="#products" role="tab"
                        aria-controls="products" aria-selected="true">Products</a>
                </li>
                @if (Auth::guard('admin')->user()->role != 'customer_service') 
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="categories-tab" data-bs-toggle="tab" href="#categories" role="tab"
                        aria-controls="categories" aria-selected="false">Categories</a>
                </li>
                @endif
            </ul>
            <div class="tab-content mt-3" id="myTabContent">
                <div class="tab-pane fade show active" id="products" role="tabpanel" aria-labelledby="products-tab">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="search" name="search" placeholder="Search" aria-label="Search"
                            aria-describedby="search-btn">
                        <button class="btn btn-outline-secondary" type="button" id="search-btn"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    @if (Auth::guard('admin')->user()->role != 'customer_service') 
                    <div class="card-title d-flex px-3">
                        <div class="ms-auto">
                            <button class="btn btn-primary"
                                onclick="window.location.href='{{ route('admin.product.add') }}'"><i
                                    class="fa-regular fa-square-plus pe-2"></i>Add Product</button>
                        </div>
                    </div>
                    @endif
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Price</th>
                                <th scope="col">Stock</th>
                                <th scope="col">Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="data-holder">
                            @foreach ($products as $index => $product)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    @if ($product->stock < 50)
                                        <td class="text-danger fw-bold">{{ $product->stock }}</td>
                                    @else
                                        <td class="text-success fw-bold">{{ $product->stock }}</td>
                                    @endif
                                    <td>{{ $product->getProductType() }}</td>
                                    @if ($product->status == 'active')
                                        <td class="text-success fw-bold">{{ $product->status }}</td>
                                    @else
                                        <td class="text-danger fw-bold">{{ $product->status }}</td>
                                    @endif
                                    <td>
                                        @if (Auth::guard('admin')->user()->role != 'customer_service') 
                                        <button class="btn btn-warning"
                                            onclick="window.location.href='{{ route('admin.product.edit', $product->product_id) }}'"><i
                                                class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                                        @else
                                        <button class="btn btn-info"
                                            onclick="window.location.href='{{ route('admin.product.view', $product->product_id) }}'"><i
                                                class="fa-regular fa-pen-to-square pe-2"></i>View</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if (Auth::guard('admin')->user()->role != 'customer_service') 
                <div class="tab-pane fade" id="categories" role="tabpanel" aria-labelledby="categories-tab">
                    <div class="card-title d-flex px-3">
                        <div class="ms-auto">
                            <button class="btn btn-primary"
                                onclick="window.location.href='{{ route('admin.category.add') }}'"><i
                                    class="fa-regular fa-square-plus pe-2"></i>Add Category</button>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Category Name</th>
                                <th scope="col">Category Description</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="data-holder">
                            @foreach ($categories as $index => $category)
                                <tr>
                                    <th scope="row">{{ $index + 1 }}</th>
                                    <td>{{ $category->category_name }}</td>
                                    <td>{{ $category->description }}</td>
                                    <td>
                                        
                                        <button class="btn btn-warning"
                                            onclick="window.location.href='{{ route('admin.category.edit', $category->id) }}'"><i
                                                class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                                        <form action="{{ route('admin.category.delete', $category->id) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirmDeletion();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"><i
                                                    class="fa-solid fa-trash-can pe-2"></i>Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{-- <script>
        //when page complete load
        document.addEventListener('DOMContentLoaded', function() {
            fetch('/api/product/all')
                .then(response => response.json())
                .then(response => {
                    if (response.success) {
                        let dataHolder = document.getElementById('data-holder');
                        dataHolder.innerHTML = '';
                        let products = response.data; // Access the 'data' key
                        products.forEach((product, index) => {
                            let tr = document.createElement('tr');
                            tr.innerHTML = ` 
                        <th scope="row">${index + 1}</th>
                        <td>${product.name}</td>
                        <td>${product.price}</td>
                        <td>${product.stock}</td>
                        <td>
                            <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                            <button class="btn btn-danger"><i class="fa-solid fa-trash-can pe-2"></i>Delete</button>
                        </td>
                    `;
                            dataHolder.appendChild(tr);
                        });
                    } else {
                        console.error('Error:', response.message);
                        alert('An error occurred: ' + response.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while fetching the product data.');
                });
        });
    </script> --}}
    <script>
        function confirmDeletion() {
            return confirm('Are you sure you want to delete this category? This action cannot be undone.');
        }

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
                    },
                    success: function(response) {
                        $('#data-holder').html(response);
                    }
                });
            }
        });
    </script>
@endsection
