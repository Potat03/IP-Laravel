@extends('admin.layout.main')
<!-- Loo Wee Kiat -->
@section('vite')
    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js'])
@endsection

@section('css')
    <style>
        .createForm {
            max-width: 600px;
            margin: 0 auto;
        }

        .createForm .form-group {
            margin-bottom: 15px;
        }

        .createForm label {
            font-weight: 600;
        }

        .createForm input {
            padding: 10px;
            font-size: 14px;
        }

        .createForm select {
            padding: 10px;
            font-size: 14px;
        }
    </style>
@endsection

@section('title', 'Staff')
@section('page_title', 'Staff')
@section('page_gm', 'Create Staff')

@section('content')
    <div class="card shadow-sm p-3 createForm">
        <div class="card-body">
            <h4 class="card-title">Create New Staff</h4>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.createStaff') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="" disabled selected>Select a role</option>
                        <option value="admin">Admin</option>
                        <option value="manager">Manager</option>
                        <option value="customer_service">Customer Service</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                        required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}"
                        required>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Create Staff</button>
                </div>
            </form>
        </div>
    </div>
@endsection
