@extends('admin.layout.main')

@section('css')
<style>
    .btn {
        font-weight: 600;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }
</style>
@endsection

@section('title', 'Promotion')
@section('page_title', 'Promotion')
@section('page_gm', 'Edit promotion')

@section('content')
<div class="card shadow-sm p-3 mb-5 w-100">
    <div class="overflow-auto">
        <div class="card-body">
            <form method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Promotion Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $promotion->title }}" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" required>{{ $promotion->description }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="discount" class="form-label">Discount (%)</label>
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ $promotion->discount }}" required>
                </div>
                <div class="mb-3">
                    <label for="product_id" class="form-label">Type</label>
                    <select class="form-select" id="type" name="type" value="{{ $promotion->type }}" required>
                        <option value="1">Single</option>
                        <option value="2">Bundle</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="limit" class="form-label">Limit</label>
                    <input type="number" class="form-control" id="limit" name="limit" value="{{ $promotion->limit }}" required>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $promotion->start_at }}" required>
                        </div>
                        <div class="col-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $promotion->end_at }}" required>
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
                <button type="submit" class="btn btn-primary">Edit Promotion</button>
                <button type="button" class="btn btn-secondary">Cancel</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    let product_list = @json($products);
    let selected_products = @json($promotion - > product_list);

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
                            <input type="number" class="form-control" id="quantity" name="product_qty" placeholder="Quantity" value="${product.quantity}" min="1" max="${product.stock}" required>
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

        let productLimit = parseInt(document.getElementById('limit').value);

        displayProducts()

        $('#start_date').on('change', function() {
            $('#end_date').attr('min', this.value);
        });

        $('#end_date').on('change', function() {
            $('#start_date').attr('max', this.value);
        });

        document.getElementById('type').addEventListener('change', function() {
            let type = this.value;
            if (type == 1) {
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
            let product = product_list.find(p => p.product_id == product_id);
            if (selected_products.find(p => p.product_id == product_id)) {
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
            if (!confirm('Are you sure you want to cancel?')) {
                e.preventDefault();
            }
            window.location.href = "{{ route('admin.promotion') }}";

        });

        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            let form = new FormData(this);
            let invalid_qty = selected_products.find(p => p.quantity > p.stock);
            if (invalid_qty) {
                alert('Quantity exceeds stock :' + invalid_qty.name);
                return;
            }
            form.append('products', JSON.stringify(selected_products));
            fetch("{{ route('promotion.update', $promotion->promotion_id) }}", {
                    method: 'POST',
                    body: form
                }).then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.href = "{{ route('admin.promotion') }}";
                    } else {
                        alert('Failed to update promotion');
                    }
                });
        });
    });
</script>

@endsection