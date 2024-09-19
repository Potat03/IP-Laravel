@extends('userprofile.layout.userProfile')

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
    </style>
@endsection

@section('title', 'Profile')
@section('page_title', 'Profile')
@section('page_gm', 'Profile Details')


@section('content')
    <div class="card shadow p-3">
        <div class="card-body">
            <h1>Your Profile Information</h1>
            <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control"
                        value="{{ $customer->username }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $customer->email }}"
                        disabled>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control"
                        value="{{ $customer->phone_number }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="tier" class="form-label">Tier</label>
                    <input type="text" id="tier" name="tier" class="form-control" value="{{ $customer->tier }}"
                        disabled>
                </div>

                <button type="button" class="btn btn-secondary" id="editButton">Edit</button>
                <button type="button" class="btn btn-primary" id="saveButton" style="display: none;">Save</button>
            </form>
            <!-- Change Password Button -->
            <form method="POST" action="{{ route('profile.requestOtp') }}" id="changePasswordForm">
                @csrf
                <button type="submit" class="btn btn-danger">Change Password</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            document.getElementById('username').disabled = false;
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'inline-block';
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            document.getElementById('profileForm').submit();
        });
    </script>
@endsection
