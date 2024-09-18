@extends('admin.layout.main')

@section('vite')
@vite(['resources/css/app.css','resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css','resources/js/bootstrap.js'])
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
</style>
@endsection

@section('title', 'Promotion')
@section('page_title', 'Promotion')
@section('page_gm', 'Prmotion bring smiles to faces')

@section('content')
<div class="card shadow-sm p-3">
    <div class="card-body">
        <div class="card-title d-flex px-3">
            <div class="me-auto">
                <div class="input-group">
                    <div class="form-outline">
                        <input type="search" id="form1" class="form-control rounded-0" placeholder="Search" />
                    </div>
                    <button type="button" class="btn border">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Effect</th>
                    <th scope="col">Items</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="data-holder">
                @php
                $index = 1;
                @endphp
                @foreach ($promotions as $promotion)
                <tr id="promotion_{{$promotion->promotion_id}}">
                            <th scope="row">{{$index++}}</th>
                            <td>{{$promotion->title}}</td>
                            <td><i class="fa-solid {{$promotion->status == " bundle" ? "fa-cubes" :"fa-cube"}}"></i><span class="ps-2">{{$promotion->type}}</span></td>
                            <td>{{count($promotion->product_list)}} product(s)
                                <a class="text-decoration-none text-secondary ps-1" data-bs-toggle="modal" data-bs-target="#viewProducts" onclick="displayProducts({{ json_encode($promotion->product_list) }})"><i class="fa-solid fa-eye"></i></a>
                            </td>
                            <td> {{$promotion->start_at}}</td>
                            <td> {{$promotion->end_at}}</td>
                            <td>
                                <span class="badge {{$promotion->status == 'active' ? 'bg-success' : 'bg-danger'}}">{{$promotion->status}}</span>
                            </td>
                            <td>
                                <button class="btn btn-success" onclick="confirmation({{$promotion->promotion_id}})"><i class="fa-regular fa-trash-can-undo pe-2"></i>Restore</button>
                            </td>
                        </tr>
                @endforeach
            </tbody>
        </table>
        <div class="modal fade" id="viewProducts" tabindex="-1" aria-labelledby="viewProductsLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="viewProductsLabel">Products</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="deletePromotion" tabindex="-1" aria-labelledby="deletePromotionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <input type="hidden" id="promotion_id">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="deletePromotionLabel">Delete Promotion</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this promotion?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                <button type="button" class="btn btn-danger" id="confirm-delete">Yes</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script>

    function displayProducts(products) {
        let tbody = document.querySelector('#viewProducts tbody');
        tbody.innerHTML = '';
        products.forEach((product, index) => {
            let tr = document.createElement('tr');
            tr.innerHTML = `
                <th scope="row">${index + 1}</th>
                <td>${product.name}</td>
                <td>${product.price}</td>
                <td>${product.stock}</td>
            `;
            tbody.appendChild(tr);
        });
    }

    function confirmation(promotion_id) {
        $('#promotion_id').val(promotion_id);
        $('#deletePromotion').modal('show');
    }

    document.querySelector('#confirm-delete').addEventListener('click', function() {
        let promotion_id = document.querySelector('#promotion_id').value;
        fetch('/api/promotion/restore/' + promotion_id, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#promotion_' + promotion_id).remove();
                    $('#deletePromotion').modal('hide');
                }
            });
    });
</script>

@endsection