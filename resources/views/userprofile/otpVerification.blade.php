@extends('userprofile.layout.userProfile')
<!-- Loo Wee Kiat -->
@section('title', 'Verify OTP')

@section('content')
    <div class="card shadow p-3">
        <div class="card-body">
            <h1>Verify OTP</h1>
            <form method="POST" action="{{ route('profile.verifyOtp') }}">
                @csrf

                <div class="mb-3">
                    <label for="otp" class="form-label">Enter OTP</label>
                    <input type="text" id="otp" name="otp" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Verify OTP</button>
            </form>
        </div>
    </div>
@endsection
