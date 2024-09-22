@extends('admin.layout.main')
<!-- Loo Wee Kiat -->
@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js'])
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

        .customerCont {
            overflow-x: hidden;
            max-height: 70vh;
            overflow-y: auto;
        }

        .editable input {
            width: 90%;
            height: 30px;
            font-size: 14px;
            padding: 5px;
            box-sizing: border-box;
        }

        .editable-status select {
            width: 50%;
            height: 30px;
            font-size: 14px;
        }
    </style>
@endsection

@section('title', 'Customer')
@section('page_title', 'Customer')
@section('page_gm', 'Customer Details')

@section('content')
    <div class="card shadow-sm p-3 w-90">
        <div class="customerCont">
            <div class="card-body">
                <div class="input-group mb-3">
                    <input type="text" name="search" class="form-control" placeholder="Search customers..."
                        value="{{ request('search') }}">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>

                <div class="row" id="product_list">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Username</th>
                                <th>Email address</th>
                                <th>Tier</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $customer)
                                <tr data-id="{{ $customer->customer_id }}">
                                    <td>{{ $customer->customer_id }}</td>
                                    <td>{{ $customer->username }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->tier }}</td>
                                    <td class="editable-status">
                                        <span
                                            data-original="{{ $customer->status }}">{{ ucfirst($customer->status) }}</span>
                                        <select class="form-control d-none status-select">
                                            <option value="active" {{ $customer->status == 'active' ? 'selected' : '' }}>
                                                active</option>
                                            <option value="inactive"
                                                {{ $customer->status == 'inactive' ? 'selected' : '' }}>inactive</option>
                                            <option value="ban" {{ $customer->status == 'ban' ? 'selected' : '' }}>ban
                                            </option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary editCustomer">Edit</button>
                                        <button class="btn btn-success d-none saveCustomer">Save</button>
                                        <button class="btn btn-secondary d-none cancelEdit">Cancel</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.editCustomer');
            const saveButtons = document.querySelectorAll('.saveCustomer');
            const cancelButtons = document.querySelectorAll('.cancelEdit');

            editButtons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const statusCell = row.querySelector('.editable-status');
                    const span = statusCell.querySelector('span');
                    const select = statusCell.querySelector('.status-select');
                    span.classList.add('d-none');
                    select.classList.remove('d-none');

                    this.classList.add('d-none');
                    row.querySelector('.saveCustomer').classList.remove('d-none');
                    row.querySelector('.cancelEdit').classList.remove('d-none');
                });
            });

            saveButtons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = row.dataset.id;
                    const status = row.querySelector('.status-select').value;

                    const data = {
                        status: status,
                        _token: '{{ csrf_token() }}'
                    };

                    fetch(`/admin/customer/${id}/update`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': data._token
                            },
                            body: JSON.stringify(data)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                const statusCell = row.querySelector('.editable-status');
                                const span = statusCell.querySelector('span');
                                const select = statusCell.querySelector('.status-select');
                                span.textContent = select.options[select.selectedIndex].text;
                                span.classList.remove('d-none');
                                select.classList.add('d-none');

                                this.classList.add('d-none');
                                row.querySelector('.editCustomer').classList.remove('d-none');
                                row.querySelector('.cancelEdit').classList.add('d-none');
                            } else {
                                console.error('Error updating status');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                        });
                });
            });

            cancelButtons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const statusCell = row.querySelector('.editable-status');
                    const span = statusCell.querySelector('span');
                    const select = statusCell.querySelector('.status-select');
                    select.classList.add('d-none');
                    span.classList.remove('d-none');

                    row.querySelector('.saveCustomer').classList.add('d-none');
                    row.querySelector('.editCustomer').classList.remove('d-none');
                    this.classList.add('d-none');
                });
            });
        });
    </script>
@endsection
