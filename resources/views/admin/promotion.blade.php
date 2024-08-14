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
        <h1>Promotion</h1>
        <div class="nav-status text-muted fw-bold">Home > Promotion</div>
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
            <tr>
                    <td class='col'>{$i}</td>
                    <td class='col'>{$product->name}<span class='text-muted ps-1'>({$product->product_id})</span></td>
                    <td class='col'>{$product->price}</td>
                    <td class='col'>{$product->stock}</td>
                    <td class='col'>
                        <div class='d-flex align-items-center'>
                            <a href='#' class='btn btn-sm btn-primary me-2'><i class='fas fa-edit'></i></a>
                            <a href='#' class='btn btn-sm btn-danger'><i class='fas fa-eye-slash'></i></a>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('js')
<script>
</script>

@endsection