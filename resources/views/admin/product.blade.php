@extends('admin.layout.main')

@section('css')
<style>
    .btn {
        font-weight: 600;
    }
</style>
@endsection

@section('content')
<div>
    <div class="px-2 py-3">
        <h1>Product</h1>
        <div class="nav-status text-muted fw-bold">Home > Product</div>
    </div>
</div>
<div class="card shadow-sm p-3">
    <div class="card-body">
        <div class="card-title d-flex px-3">
            <div class="ms-auto">
                <button class="btn btn-primary"><i class="fa-regular fa-square-plus pe-2"></i>Add Product</button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Stock</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="data-holder">
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('js')
<script>
    //when page complete load
    document.addEventListener('DOMContentLoaded', function() {
        fetch('/api/product/generateTable')
            .then(response => response.json())
            .then(responseData => {
                if (responseData.success) {
                    let data = responseData.data;
                    let dataHolder = document.getElementById('data-holder');
                    dataHolder.innerHTML = '';
                    data.forEach((product, index) => {
                        let tr = document.createElement('tr');
                        tr.innerHTML = product;
                        dataHolder.appendChild(tr);
                    });
                } else {
                    console.error('Error:', responseData.message);
                    alert('An error occurred while fetching the product data.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching the product data.');
            });
    });
</script>

@endsection