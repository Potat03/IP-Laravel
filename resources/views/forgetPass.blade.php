<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/userlogin.css'])
    <title>Forget Password</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        html,
        body {
            height: 100%;
            display: grid;
            place-items: center;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            background: #f0f0f0;
            overflow-y: hidden;
        }

        .container {
            width: 500px;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 25px;
        }

        .centerbtn {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>

<body>
    <form id="forgetPasswordForm" method="POST" action="{{ route('auth.forget') }}">
        @csrf
        <div class="card text-center" style="width: 350px;height:350px;">
            <div class="card-header h5 text-white bg-danger">Forget Password</div>
            <div class="card-body px-5">
                <p class="card-text py-2">Enter your email address.</p>
                <p class="card-text py-2">An OTP will be sent through email for verification.</p>
                <div data-mdb-input-init class="form-outline">
                    <input type="email" id="email" name="email" class="form-control my-3" required />
                </div>
                <button type="submit" class="btn btn-danger w-100">Send OTP</button>
            </div>
        </div>
    </form>

    <script>
        // handle forget password
        document.getElementById('forgetPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('OTP has been sent to your email!');
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
