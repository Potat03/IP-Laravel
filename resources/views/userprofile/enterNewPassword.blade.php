@extends('userprofile.layout.userProfile')

@section('title', 'Change Password')

@section('content')
    <div class="card shadow p-3">
        <div class="card-body">
            <h1>Change Your Password</h1>

            {{-- Display validation errors --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <form method="POST" action="{{ route('profile.changePassword') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Change Password</button>
            </form>
        </div>
    </div>
@endsection
