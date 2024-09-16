@extends('userprofile.layout.userProfile')

@section('content')
    <div class="container">
        <div class="d-flex px-2 py-3">
            <div class="nav-status">Profile</div>
            <div class="ms-auto">
                <button class="btn btn-primary" id="editButton">Edit Profile</button>
            </div>
        </div>
    </div>

    <div class="card shadow p-3">
        <div class="card-body">
            <h1>Your Profile Information</h1>
            <form id="profileForm" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" id="username" name="username" class="form-control" value="{{ $customer->username }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ $customer->email }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" class="form-control" value="{{ $customer->phone_number }}" disabled>
                </div>

                <div class="mb-3">
                    <label for="tier" class="form-label">Tier</label>
                    <input type="text" id="tier" name="tier" class="form-control" value="{{ $customer->tier }}" disabled>
                </div>

                <button type="button" class="btn btn-primary" id="saveButton" style="display: none;">Save</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('editButton').addEventListener('click', function() {
            document.querySelectorAll('#profileForm input').forEach(function(input) {
                input.disabled = false;
            });
            document.getElementById('editButton').style.display = 'none';
            document.getElementById('saveButton').style.display = 'inline-block';
        });

        document.getElementById('saveButton').addEventListener('click', function() {
            document.getElementById('profileForm').submit();
        });
    </script>
@endsection
