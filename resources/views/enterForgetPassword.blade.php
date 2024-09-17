<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Enter New Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f7f7f7;
        }

        .container {
            margin-top: 100px;
        }

        .card {
            border: none;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: red;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background-color: red;
            border-color: red;
        }

        .btn-primary:hover {
            background-color: red;
            border-color: red;
        }

        .form-control {
            border-radius: 0.25rem;
        }

        .alert-danger {
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        Enter New Password
                    </div>
                    <div class="card-body">
                        <form action="{{ route('auth.updatePassword') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter new password" required>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Confirm new password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Reset Password</button>
                        </form>

                        <div class="alert alert-danger" role="alert" style="display: none;">
                            <strong>Error!</strong> Password reset failed. Please try again.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            event.preventDefault();

            let formData = new FormData(this);

            let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(this.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Password has been changed.');
                        window.location.href = data.redirect_url;
                    } else {
                        alert(data.message || 'An unexpected error occurred.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('An unexpected error occurred.');
                });
        });
    </script>

</body>

</html>
