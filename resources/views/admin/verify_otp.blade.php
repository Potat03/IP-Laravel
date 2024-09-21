<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Loo Wee Kiat -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verify OTP</title>
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
            background-color: blue;
            color: #fff;
            font-size: 24px;
            font-weight: bold;
            text-align: center;
        }

        .btn-primary {
            background-color: blue;
            border-color: blue;
        }

        .btn-primary:hover {
            background-color: darkblue;
            border-color: darkblue;
        }

        .alert {
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
                        Verify OTP
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.verifyOtp') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <label for="otp">Enter OTP</label>
                                <input type="text" name="otp" class="form-control" id="otp" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Verify OTP</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
