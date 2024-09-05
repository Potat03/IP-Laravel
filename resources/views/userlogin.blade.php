<!-- resources/views/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/userlogin.css'])
    <title>User Login</title>
</head>

<body>
    @include('header')
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-8 col-md-10">
                <div class="cont">
                    <div class="form sign-in">
                        <h1>Logo</h1>
                        <h2>Welcome to Futatabi</h2>
                        <form action="{{ route('auth.login') }}" method="POST">
                            @csrf
                            <label>
                                <span>Email</span>
                                <input type="email" name="email" required />
                            </label>
                            <label>
                                <span>Password</span>
                                <input type="password" name="password" required />
                            </label>
                            <p class="forgot-pass">Forgot password?</p>
                            <button type="submit" class="submit">Sign In</button>
                        </form>
                    </div>
                    <div class="sub-cont">
                        <div class="img">
                            <div class="img__text m--up">
                                <h3>Don't have an account? Please Sign up!</h3>
                            </div>
                            <div class="img__text m--in">
                                <h3>If you already have an account, just sign in.</h3>
                            </div>
                            <div class="img__btn">
                                <span class="m--up">Sign Up</span>
                                <span class="m--in">Sign In</span>
                            </div>
                        </div>
                        <div class="form sign-up">
                            <h2>Create your Account</h2>
                            <form action="{{ route('auth.register') }}" method="POST">
                                @csrf
                                <div class="form-row">
                                    <label>
                                        <span>Username</span>
                                        <input type="text" name="username" required />
                                    </label>
                                    <label>
                                        <span>Email</span>
                                        <input type="email" name="email" required />
                                    </label>
                                </div>
                                <div class="form-row">
                                    <label>
                                        <span>Phone number</span>
                                        <input type="text" name="phone" required />
                                    </label>
                                    <label>
                                        <span>Birthday</span>
                                        <input type="date" name="birthday" required />
                                    </label>
                                </div>
                                <div class="form-row">
                                    <label>
                                        <span>Password</span>
                                        <input type="password" name="password" required />
                                    </label>
                                    <label>
                                        <span>Confirm Password</span>
                                        <input type="password" name="password_confirmation" required />
                                    </label>
                                </div>
                                <button type="submit" class="submit">Sign Up</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        //animation
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });

        //handle form
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                let formData = new FormData(form);
                let actionUrl = form.action;

                fetch(actionUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Operation Success');
                        } else {
                            alert('Operation Failed');
                            console.log(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Fetch error:', error);
                        alert('An unexpected error occurred.');
                    });
            });
        });
    </script>
</body>

</html>
