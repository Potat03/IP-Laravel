<!-- resources/views/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/userlogin.css'])
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>User Login</title>
    <style>
        html {
            overflow: hidden;
        }
    </style>
</head>

<body>
    @include('header')
    <main class="login_content">
        <div class="container">
            <div class="row justify-content-center align-items-center min-vh-100">
                <div class="col-lg-8 col-md-10">
                    <div class="cont">
                        <div class="form sign-in">
                            <h1>Logo</h1>
                            <h2>Welcome to Futatabi</h2>
                            <form id="loginForm" action="{{ route('auth.userLogin') }}" method="POST">
                                @csrf
                                <label class="formlabel">
                                    <span>Email</span>
                                    <input class="logInput" type="email" name="email" required />
                                </label>
                                <label class="formlabel">
                                    <span>Password</span>
                                    <input class="logInput" type="password" name="password" required />
                                </label>
                                <label class="formlabel">
                                    <a class="forgot-pass" style="color:red;" href="{{ route('user.forget') }}">Forgot
                                        password?</a>
                                </label>
                                <script src="<https://www.google.com/recaptcha/api.js>" async defer></script>
                                <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                                <button type="submit" class="submit authsubmit">Sign In</button>
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
                                <form id="registerForm" action="{{ route('auth.userRegister') }}" method="POST">
                                    @csrf
                                    <div class="form-row">
                                        <label class="formlabel">
                                            <span>Username</span>
                                            <input class="regInput" type="text" name="username" required />
                                        </label>
                                        <label class="formlabel">
                                            <span>Email</span>
                                            <input class="regInput" type="email" name="email" required />
                                        </label>
                                    </div>
                                    <div class="form-row">
                                        <label class="formlabel">
                                            <span>Phone number</span>
                                            <input class="regInput" type="text" name="phone" required />
                                        </label>
                                        <label class="formlabel">
                                            <span>Password</span>
                                            <input class="regInput" type="password" name="password" required />
                                        </label>
                                    </div>
                                    <div class="form-row">
                                        <label class="formlabel">
                                            <span>Confirm Password</span>
                                            <input class="regInput" type="password" name="password_confirmation"
                                                required />
                                        </label>
                                    </div>
                                    <div class="form-row">
                                        <label class="formlabel" style="display:block;width:fit-content;">
                                            <input type="checkbox" name="terms" required />
                                            I agree to the <a href="#">terms and conditions</a>
                                        </label>
                                    </div>

                                    <button type="submit" class="submit authsubmit">Sign Up</button>
                                </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        // animation to toggle
        document.querySelector('.img__btn').addEventListener('click', function() {
            document.querySelector('.cont').classList.toggle('s--signup');
        });

        // handle login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Logged in');
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

        // handle register
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            console.log(formData);
            console.log(this.action);
            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Registration successful. Please proceed to verification.');
                        window.location.href = data.redirect_url;
                    } else {
                        alert('Registration Failed');
                        console.log(data);
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
