@extends('admin.layout.main')
<!-- Loo Wee Kiat -->
@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/css/admin-nav.css', 'resources/js/bootstrap.js'])
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

        .staffCont {
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

        .editable-status select,
        .editable-role select {
            width: 80%;
            height: 30px;
            font-size: 14px;
        }
    </style>
@endsection

@section('title', 'Staff')
@section('page_title', 'Staff')
@section('page_gm', 'Staff Details')

@section('content')
    <div class="card shadow-sm p-3 w-90">
        <div class="staffCont">
            <div class="card-body">
                <!-- Create User Button -->
                <div class="mb-3">
                    <a href="{{ route('admin.createStaff') }}" class="btn btn-primary">Create User</a>
                </div>

                <div class="row" id="staff_list">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($staff as $admin)
                                <tr data-id="{{ $admin->admin_id }}">
                                    <td>{{ $admin->admin_id }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td class="editable-role">
                                        <span data-original="{{ $admin->role }}">{{ ucfirst($admin->role) }}</span>
                                        <select class="form-control d-none role-select">
                                            <option value="manager" {{ $admin->role == 'manager' ? 'selected' : '' }}>
                                                manager</option>
                                            <option value="admin" {{ $admin->role == 'admin' ? 'selected' : '' }}>admin
                                            </option>
                                            <option value="customer_service" {{ $admin->role == 'customer_service' ? 'selected' : '' }}>customer_service
                                            </option>
                                        </select>
                                    </td>
                                    <td class="editable-status">
                                        <span data-original="{{ $admin->status }}">{{ ucfirst($admin->status) }}</span>
                                        <select class="form-control d-none status-select">
                                            <option value="active" {{ $admin->status == 'active' ? 'selected' : '' }}>
                                                active</option>
                                            <option value="inactive" {{ $admin->status == 'inactive' ? 'selected' : '' }}>
                                                inactive</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-primary editStaff">Edit</button>
                                        <button class="btn btn-success d-none saveStaff">Save</button>
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
            const editButtons = document.querySelectorAll('.editStaff');
            const saveButtons = document.querySelectorAll('.saveStaff');
            const cancelButtons = document.querySelectorAll('.cancelEdit');

            editButtons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const roleField = row.querySelector('.editable-role select');
                    const statusField = row.querySelector('.editable-status select');

                    row.querySelector('.editable-role span').classList.add('d-none');
                    roleField.classList.remove('d-none');

                    row.querySelector('.editable-status span').classList.add('d-none');
                    statusField.classList.remove('d-none');

                    this.classList.add('d-none');
                    row.querySelector('.saveStaff').classList.remove('d-none');
                    row.querySelector('.cancelEdit').classList.remove('d-none');
                });
            });

            saveButtons.forEach((btn) => {
                btn.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const id = row.dataset.id;
                    const role = row.querySelector('.role-select').value;
                    const status = row.querySelector('.status-select').value;

                    const data = {
                        role: role,
                        status: status,
                        _token: '{{ csrf_token() }}'
                    };

                    fetch(`/admin/staff/${id}/update`, {
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
                                row.querySelector('.editable-role span').textContent = role
                                    .charAt(0).toUpperCase() + role.slice(1);
                                row.querySelector('.editable-status span').textContent = status
                                    .charAt(0).toUpperCase() + status.slice(1);

                                row.querySelector('.editable-role span').classList.remove(
                                    'd-none');
                                row.querySelector('.editable-role select').classList.add(
                                    'd-none');

                                row.querySelector('.editable-status span').classList.remove(
                                    'd-none');
                                row.querySelector('.editable-status select').classList.add(
                                    'd-none');

                                row.querySelector('.editStaff').classList.remove('d-none');
                                row.querySelector('.saveStaff').classList.add('d-none');
                                row.querySelector('.cancelEdit').classList.add('d-none');
                            } else {
                                console.error('Error updating staff');
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
                    row.querySelector('.editable-role span').classList.remove('d-none');
                    row.querySelector('.editable-role select').classList.add('d-none');

                    row.querySelector('.editable-status span').classList.remove('d-none');
                    row.querySelector('.editable-status select').classList.add('d-none');

                    row.querySelector('.saveStaff').classList.add('d-none');
                    row.querySelector('.editStaff').classList.remove('d-none');
                    this.classList.add('d-none');
                });
            });
        });
    </script>
@endsection
