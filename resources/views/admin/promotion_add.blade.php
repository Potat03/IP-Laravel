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

@section('content')
<div>
    <div class="px-2 py-3">
        <h1>Promotion</h1>
        <div class="nav-status text-muted fw-bold">Home > Promotion > Add</div>
    </div>
</div>
<div class="card shadow-sm p-3">
    <div class="card-body">
        <form method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Promotion Title</label>
                <input type="text" class="form-control" id="title" name="title" value="1" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" value="1" required></textarea>
            </div>
            <div class="mb-3">
                <label for="discount" class="form-label">Discount (%)</label>
                <input type="number" class="form-control" id="discount" name="discount" value="1" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Type</label>
                <select class="form-select" id="type" name="type" required>
                    <option value="1">Single</option>
                    <option value="2">Bundle</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="limit" class="form-label">Limit</label>
                <input type="number" class="form-control" id="limit" name="limit" value="1" required>
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
                </select>
                <div class="row" id="product_list">
                    <!-- Product List -->
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

@endsection

@section('js')
<script>
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').setAttribute('min', this.value);
    });

    document.getElementById('end_date').addEventListener('change', function() {
        document.getElementById('start_date').setAttribute('max', this.value);
    });

    let product_list = [];
    let selected_products = [];
    fetch("{{ route('product.index') }}")
        .then(response => response.json())
        .then(data => {
            let product_select = document.getElementById('product_select');

            data.forEach(product => {
                product_list.push(product);
                let option = document.createElement('option');
                option.value = product.id;
                option.text = product.name;
                product_select.appendChild(option);
            });
            console.log(product_list);
        });

    document.getElementById('product_select').addEventListener('change', function() {
        let product_id = this.value;
        if (product_id == -1) {
            return;
        }
        let product = product_list.find(product => product_id == product_id);

        if (selected_products.find(p => p.id == product.id)) {
            alert('Product already selected');
            this.value = -1;
            return;
        } else if (product != null) {
            product.quantity = 1;
            selected_products.push(product);
            let display = document.getElementById('product_list');
            let div = document.createElement('div');
            div.classList.add('col-12');
            div.innerHTML = `
                <div class="card shadow-sm p-3 mt-3 w-75">
                    <div class="d-flex justify-content-start gap-5">
                        <input type="hidden" name="product_id" value="${product.id}">
                        <input type="text" class="form-control" id="product_name" name="product_name" value="${product.name}" required disabled>
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

            //add event listener to remove product
            div.querySelector('#remove_product').addEventListener('click', function() {
                let index = selected_products.findIndex(p => p.id == product.id);
                selected_products.splice(index, 1);
                div.remove();
            });

            //add qty change event
            div.querySelector('#quantity').addEventListener('change', function() {
                let qty = parseInt(this.value);
                let index = selected_products.findIndex(p => p.id == product.id);
                selected_products[index].quantity = qty;
            });
        }
        this.value = -1;
    });

    //confirm reset
    document.querySelector('form').addEventListener('reset', function(e) {
        if (!confirm('Are you sure you want to reset the form?')) {
            e.preventDefault();
        }
        selected_products = [];
        document.getElementById('product_list').innerHTML = '';
        
    });

    //ajax request to add promotion
    document.querySelector('form').addEventListener('submit', function(e) {
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
</script>

@endsection