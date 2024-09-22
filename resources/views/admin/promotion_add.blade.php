{{-- Author: Nicholas Yap Jia Wey --}}
@extends('admin.layout.main')

@push('promotion', 'class="active"')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js','resources/js/bootstrap.js'])
@endsection

@section('css')
<style>
    .btn {
        font-weight: 600;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .alert-fixed {
        position: fixed;
        top: 10%;
        left: 25%;
        width: 50%;
        z-index: 9999;
        border-radius: 25px;
    }
</style>
@endsection

@section('title', 'Promotion')
@section('page_title', 'Promotion')
@section('page_gm', 'Add a promotion')

@section('content')
<div id="liveAlertPlaceholder"></div>
<div class="card shadow-sm p-3 mb-5 w-100 position-static">
    <div class="overflow-auto">
        <div class="card-body">
            <form method="POST" id="promotion-form">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Promotion Title</label>
                    <input type="text" class="form-control" id="title" name="title"required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input type="number" class="form-control" id="discount" name="discount" required>
                </div>
                <div class="mb-3">
                    <label for="product_id" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type" required>
                        <option value="single">Single</option>
                        <option value="bundle">Bundle</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="limit" class="form-label">Limit</label>
                    <input type="number" class="form-control" id="limit" name="limit" required>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" required>
                        </div>
                        <div class="col-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" required>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select class="form-select" id="product_select" name="product_select">
                        <option value="-1">-- Select Product --</option>
                        @foreach ($products as $product)
                        @if ($product->stock != 0 && $product->status != 'inactive')
                        <option value="{{ $product->product_id }}">{{ $product->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="container mx-0">

                        <div class="row" id="product_list">
                        </div>
                    </div>

                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Promotion</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let product_list = @json($products);
    let selected_products = [];

    function displayProducts() {
        let display = document.getElementById('product_list');
        display.innerHTML = '';
        selected_products.forEach(product => {
            let div = document.createElement('div');
            div.classList.add('col-12');
            div.innerHTML = `
                <div class="card shadow-sm p-3 mt-3 w-75">
                    <div class="d-flex justify-content-start gap-5">
                        <input type="hidden" name="product_id" value="${product.product_id}">
                        <div class="input-group">
                            <span class="input-group-text">Name</span>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="${product.name}" required disabled>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Quantity</span>
                            <input type="number" class="form-control" id="quantity" name="product_qty" placeholder="Quantity" value="1" min="1" max="${product.stock}" required>
                        </div>
                        <div class="input-group">
                            <span class="input-group-text">Stock</span>
                            <input type="text" class="form-control" id="stock" name="stock" value="${product.stock}" required disabled>
                        </div>
                        <button type="button" class="btn btn-danger" id="remove_product">X</button>
                    </div>
                </div>
                `;
            display.appendChild(div);


            div.querySelector('#remove_product').addEventListener('click', function() {
                let index = selected_products.findIndex(p => p.id == product.id);
                selected_products.splice(index, 1);
                div.remove();
            });


            div.querySelector('#quantity').addEventListener('change', function() {
                let qty = parseInt(this.value);
                let index = selected_products.findIndex(p => p.id == product.id);
                selected_products[index].quantity = qty;
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {

        let suggestion = "";
        fetch("{{ route('suggestion.weather')}}", {
                method: 'GET',
            })
            .then(response => response.json())
            .then(data => {
                suggestion = data.message;

                $('#title').on('click', function() {
                    if (suggestion != "" && $('#liveAlertPlaceholder').html() == "") {
                        $('#liveAlertPlaceholder').html(`<div class="alert alert-info alert-dismissible fade show alert-fixed" role="alert">
                            ${suggestion}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`);
                    }
                });
            });


            let productLimit = {{ $promotion->type == 'single' ? 1 : 0 }};

        $('#start_date').on('change', function() {
            $('#end_date').attr('min', this.value);
        });

        $('#end_date').on('change', function() {
            $('#start_date').attr('max', this.value);
        });
        document.getElementById('type').addEventListener('change', function() {
            let type = this.value;
            if (type == "single") {
                selected_products.splice(1, selected_products.length);
                displayProducts()
                productLimit = 1;
            } else {
                productLimit = 0;
            }
        });

        document.getElementById('product_select').addEventListener('change', function() {
            let product_id = this.value;

            if (product_id == -1) {
                return;
            }

            if ((productLimit == 1 && selected_products.length > 0)) {
                alert('Only one product can be selected');
                this.value = -1;
                return;
            }
            let product = product_list.find(product => product.product_id == product_id);
            if (selected_products.find(p => p.product_id == product.product_id)) {
                alert('Product already selected');
                this.value = -1;
                return;
            } else if (product != null) {
                product.quantity = 1;
                selected_products.push(product);
                displayProducts();

            }
            this.value = -1;
        });

        document.querySelector('form').addEventListener('reset', function(e) {
            if (!confirm('Are you sure you want to reset the form?')) {
                e.preventDefault();
            }
            selected_products = [];
            document.getElementById('product_list').innerHTML = '';

        });

        document.getElementById('promotion-form').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(this);
            let invalid_qty = selected_products.find(p => p.quantity > p.stock);
            if (invalid_qty) {
                alert('Quantity exceeds stock :' + invalid_qty.name);
                return;
            }
            form.append('products', JSON.stringify(selected_products));
            fetch("{{ route('promotion.create') }}", {
                    method: 'POST',
                    body: form
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "../promotion";
                    } else {
                        alert(data.message);
                    }
                });
        });
    });
</script>

@endsection