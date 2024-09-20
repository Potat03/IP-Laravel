@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password</div>

                <div class="card-body">
                    <p>Are you sure you want to change your password? An OTP will be sent to your registered email for confirmation.</p>

                    <form method="POST" action="{{ route('user.sendOtp') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">Yes, Send OTP</button>
                        <a href="{{ route('user.profileSec') }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
