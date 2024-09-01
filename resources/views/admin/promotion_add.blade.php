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
        <h1>Add Promotion</h1>
        <div class="nav-status text-muted fw-bold">Home > Promotion > Add</div>
    </div>
</div>
<div class="card shadow-sm p-3">
    <div class="card-body">
        <form method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Promotion Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
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
                    <option value="1">Single</option>
                    <option value="2">Bundle</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date</label>
                <input type="date" class="form-control" id="start_date" name="start_date" required>
            </div>
            <div class="mb-3">
                <label for="end_date" class="form-label">End Date</label>
                <input type="date" class="form-control" id="end_date" name="end_date" required>
            </div>
            <div class="mb-3">
                <label for="product_id" class="form-label">Product</label>
                <select class="form-select" id="product_select" name="product_select">
                    <option value="-1">-- Select Product --</option>
                </select>
                <div class="row" id="product_list">
                    <div class="col-12">
                        <div class="card shadow-sm p-3 mt-3">
                            <div class="d-flex">
                                <input type="text" class="form-control" id="product_name" name="product_name" required disabled>
                                <input type="text" class="form-control" id="quantity" name="product_qty" required disabled>
                                <button type="button" class="btn btn-primary ms-2" id="add_product">Add</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="1">Active</option>
                    <option value="0">Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Promotion</button>
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
        });

    document.getElementById('product_select').addEventListener('change', function() {
        let product_id = this.value;
        if (product_id == -1) {
            return;
        }
        let product = product_list.find(product => product.id == product_id);
        document.getElementById('product_name').value = product.name;
    });

    document.getElementById('add_product').addEventListener('click', function() {
        if (document.getElementById('quantity').value == '' || document.getElementById('quantity').value == 0) {
            alert('Please enter quantity');
            return;
        }

        if(selected_products.find(product => product.id == document.getElementById('product_select').value)) {
            alert('Product already added');
            return;
        }
        
        selected_products.push({
            id: document.getElementById('product_select').value,
            quantity: document.getElementById('quantity').value
        });
    });
</script>

@endsection