<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futatabi Admin Site</title>
    @include('partials.fontawesome')
    <link href="{{ asset('css/admin-login.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <div class="bg"></div>
    <div class="content_wrap">
        <div class="login_wrap">
            <div class="login_form">
                <div class="login_title">
                    <img src="{{ asset('images/logo.png') }}">
                    <div class="login_title_text">
                        <h1>Futatabi</h1>
                        <p>Admin Login</p>
                    </div>
                </div>
                <div class="login_welcome">
                    <p>Welcome back!</p>
                </div>
                <form action="{{ route('admin.login') }}" method="POST" id="login_form">
                    @csrf
                    <div class="login_input">
                        <label for="email"><i class="fa-regular fa-envelope"></i></label>
                        <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" id="email" autocomplete="off" required>

                    </div>
                    <div class="login_input">
                        <label for="password"><i class="fa-regular fa-key"></i></label>
                        <input type="password" name="password" placeholder="Password" id="password" required> 
                    </div>

                    <div class="error_msg_box">
                        <div class="error_msg" id="error_msg">

                        </div>
                    </div>
                    <div class="login_button">
                        <button type="submit">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#login_form').submit(function(e) {
                e.preventDefault();
                var email = $('#email').val();
                var password = $('#password').val();
                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    data: {
                        email: email,
                        password: password,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            window.location.href = response.redirect;
                        } else {
                            $('#error_msg').text(response.error);
                        }
                    },
                    error: function(xhr) {
                        var response = xhr.responseJSON;
                        if (response && response.message) {
                            $('#error_msg').text(response.message);
                        } else {
                            $('#error_msg').text('Something went wrong. Please try again later.');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>