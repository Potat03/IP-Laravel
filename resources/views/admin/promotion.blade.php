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
        <div class="nav-status text-muted fw-bold">Home > Promotion</div>
    </div>
</div>
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
            <div class="ms-auto">
                <button class="btn btn-primary" onclick="window.location.href='/admin/promotion/add'"><i class="fa-solid fa-plus pe-2"></i>Add</button>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col"></th>
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
                <tr>
                    <th scope="row">1</th>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                        </div>
                    </td>
                    <td>Christmas Sale</td>
                    <td><i class="fa-solid fa-cubes"></i><span class="ps-2">Bundle</span></td>
                    <td>3 products
                        <a class="text-decoration-none text-secondary ps-1" data-bs-toggle="modal" data-bs-target="#viewProducts"><i class="fa-solid fa-eye"></i></a>
                    </td>
                    <td> Feb 1, 2024</td>
                    <td> Feb 1, 2024</td>
                    <td>
                        <span class="badge bg-success">Active</span>
                    </td>
                    <td>
                        <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                        <button class="btn btn-danger"><i class="fa-solid fa-trash-can pe-2"></i>Delete</button>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" checked>
                        </div>
                    </td>
                    <td>Christmas Sale</td>
                    <td><i class="fa-solid fa-cube"></i><span class="ps-2">Single</span></td>
                    <td>3 products
                        <a class="text-decoration-none text-secondary ps-1" data-bs-toggle="modal" data-bs-target="#viewProducts"><i class="fa-solid fa-eye"></i></a>
                    </td>
                    <td> Feb 1, 2024</td>
                    <td> Feb 1, 2024</td>
                    <td>
                        <span class="badge bg-success">Active</span>
                    </td>
                    <td>
                        <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                        <button class="btn btn-danger"><i class="fa-solid fa-trash-can pe-2"></i>Delete</button>
                    </td>
                </tr>
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

@endsection

@section('js')
<script>
    promotion_list = []
    //when page complete load
    document.addEventListener('DOMContentLoaded', function() {
        fetch("{{ route('promotion.index') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let dataHolder = document.getElementById('data-holder');
                    dataHolder.innerHTML = '';
                    $count = 1;
                    console.log(data);
                    data.data.forEach(promotion => {
                        promotion_list.push(promotion);
                        let tr = document.createElement('tr');
                        tr.innerHTML = `
                            <tr>
                                <th scope="row">${$count++}</th>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" ${promotion.status == "active" ? "checked":""}>
                                    </div>
                                </td>
                                <td>Christmas Sale</td>
                                <td><i class="fa-solid ${promotion.status == "bundle" ? "fa-cube":"fa-cubes"}"></i><span class="ps-2">${promotion.type}</span></td>
                                <td>${promotion.product_list.length} product(s)
                                    <a class="text-decoration-none text-secondary ps-1" data-bs-toggle="modal" data-bs-target="#viewProducts"><i class="fa-solid fa-eye"></i></a>
                                </td>
                                <td> ${promotion.start_at}</td>
                                <td> ${promotion.end_at}</td>
                                <td>
                                    <span class="badge bg-success">${promotion.status}</span>
                                </td>
                                <td>
                                    <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                                    <button class="btn btn-danger"><i class="fa-solid fa-trash-can pe-2"></i>Delete</button>
                                </td>
                            </tr>
                            `;
                        dataHolder.appendChild(tr);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching the product data.');
            });
    });

    //view product modal
    document.getElementById('viewProducts').addEventListener('show.bs.modal', function(event) {
        let button = event.relatedTarget;
        let modal = this;
        let modalBody = modal.querySelector('.modal-body');
        let modalTitle = modal.querySelector('.modal-title');
        let modalFooter = modal.querySelector('.modal-footer');
        let modalBodyTable = modalBody.querySelector('table tbody');
        let promotionIndex = button.closest('tr').rowIndex - 1;
        let promotion = promotion_list[promotionIndex];
        console.log(promotion);
        modalTitle.textContent = promotion.title;
        modalBodyTable.innerHTML = '';
        promotion.product_list.forEach((product, index) => {
            let tr = document.createElement('tr');
            tr.innerHTML = `
            <tr>
                <th scope="row">${index + 1}</th>
                <td>${product.name}</td>
                <td>${product.price}</td>
                <td>${product.stock}</td>
            </tr>
            `;
            modalBodyTable.appendChild(tr);
        });
    });
</script>

@endsection