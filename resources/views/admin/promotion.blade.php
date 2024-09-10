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
            <div class="ms-auto">
                <button class="btn btn-secondary me-2"><i class="fa-regular fa-trash-undo pe-2"></i>Restore</button>
                <button class="btn btn-primary" onclick="window.location.href='{{ route('promotion.create') }}'"><i class="fa-regular fa-plus pe-2"></i>Create</button>
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
    promotion_list = []
    //when page complete load
    document.addEventListener('DOMContentLoaded', function() {
        fetchPromotion();
    });

    //function to fetch promotion data
    function fetchPromotion() {
        fetch("{{ route('promotion.getAll') }}")
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let dataHolder = document.getElementById('data-holder');
                    dataHolder.innerHTML = '';
                    $count = 1;
                    console.log(data);
                    data.data.forEach(promotion => {
                        promotion_list.push(promotion);
                        if (promotion.status != 'deleted') {
                            let tr = document.createElement('tr');
                            tr.innerHTML = `
                            <tr>
                                <th scope="row">${$count++}</th>
                                <td>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckDefault" ${promotion.status == "active" ? "checked":""}>
                                    </div>
                                </td>
                                <td>${promotion.title}</td>
                                <td><i class="fa-solid ${promotion.status == "bundle" ? "fa-cubes":"fa-cube"}"></i><span class="ps-2">${promotion.type}</span></td>
                                <td>${promotion.product_list.length} product(s)
                                    <a class="text-decoration-none text-secondary ps-1" data-bs-toggle="modal" data-bs-target="#viewProducts"><i class="fa-solid fa-eye"></i></a>
                                </td>
                                <td> ${promotion.start_at}</td>
                                <td> ${promotion.end_at}</td>
                                <td>
                                    <span class="badge ${promotion.status == 'active' ? 'bg-success' : 'bg-danger'}">${promotion.status}</span>
                                </td>
                                <td>
                                    <button class="btn btn-warning"><i class="fa-regular fa-pen-to-square pe-2"></i>Edit</button>
                                    <button class="btn btn-danger"><i class="fa-regular fa-trash pe-2"></i>Delete</button>
                                </td>
                            </tr>
                            `;
                            dataHolder.appendChild(tr);
                            //add button event listener
                            tr.querySelector('button.btn-warning').addEventListener('click', function() {
                                window.location.href = 'http://127.0.0.1:8000/admin/promotion/edit/' + promotion.promotion_id;
                            });
                            tr.querySelector('button.btn-danger').addEventListener('click', function() {
                                $('#deletePromotion').modal('show');
                                $('#deletePromotion #promotion_id').val(promotion.promotion_id);
                            });
                        }
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while fetching the product data.');
            });
    }

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

    //switch status
    document.getElementById('data-holder').addEventListener('change', function(event) {
        let switchElement = event.target;
        let promotionIndex = switchElement.closest('tr').rowIndex - 1;
        let promotion = promotion_list[promotionIndex];
        let status = switchElement.checked ? 'active' : 'inactive';
        let api = "../../api/promotion/edit/status/" + promotion.promotion_id;
        fetch(api, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    promotion_id: promotion.promotion_id,
                    status: status
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    promotion_list[promotionIndex].status = status;
                    //update status badge in same row
                    let badge = switchElement.parentElement.parentElement.parentElement.querySelector('.badge');
                    console.log(badge)
                    badge.innerHTML = status;
                    if (status == 'active') {
                        badge.classList.remove('bg-danger');
                        badge.classList.add('bg-success');
                    } else {
                        badge.classList.remove('bg-success');
                        badge.classList.add('bg-danger');
                    }
                } else {
                    alert('An error has occured. Please contact administrator.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
    });

    //delete promotion
    document.getElementById('confirm-delete').addEventListener('click', function() {
        let promotion_id = document.getElementById('promotion_id').value;
        let api = "../../api/promotion/" + promotion_id;
        fetch(api, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    $('#deletePromotion').modal('hide');
                    fetchPromotion();
                } else {
                    alert('An error has occured. Please contact administrator.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the promotion.');
            });
    });
</script>

@endsection