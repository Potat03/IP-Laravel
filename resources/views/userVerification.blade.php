<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/userlogin.css'])
    <title>OTP Verification</title>
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

        h3.title {
            font-size: 28px;
            font-weight: 700;
            color: #093030;
            margin-bottom: 25px;
        }

        p.sub-title {
            color: #B5BAB8;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .wrapper {
            width: 100%;
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            justify-items: space-between;
        }

        .wrapper input.field {
            width: 50px;
            line-height: 75px;
            font-size: 32px;
            border: none;
            background-color: #EAF5F6;
            border-radius: 5px;
            text-align: center;
            text-transform: uppercase;
            color: #093030;
            margin-bottom: 25px;
        }

        .wrapper input.field:focus {
            outline: none;
        }

        .verifyOtp {
            background-color: red;
            border: none;
            font-weight: 600;
            color: white;
            cursor: pointer;
            font-size: 20px;
            padding: 12px 12px;
            margin-top: 10px;
            border-radius: 25px;
            text-align: center;
        }

        .centerbtn {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .sendAgn {
            border: none;
            color: red;
            background: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="title">OTP Verification</h3>
        <p class="sub-title">
            Enter the OTP sent to your email
        </p>
        <form method="POST" action="{{ route('auth.verify') }}">
            @csrf
            <input type="hidden" name="email" value="{{ request('email') }}">
            <div class="wrapper">
                <input type="text" name="otp1" maxlength="1" class="field 1" required>
                <input type="text" name="otp2" maxlength="1" class="field 2" required>
                <input type="text" name="otp3" maxlength="1" class="field 3" required>
                <input type="text" name="otp4" maxlength="1" class="field 4" required>
                <input type="text" name="otp5" maxlength="1" class="field 5" required>
                <input type="text" name="otp6" maxlength="1" class="field 6" required>
            </div>
            <button id="resend-btn" class="sendAgn" type="button" disabled>
                Send again in <span id="countdown">60</span>s..
            </button>
            <div class="centerbtn">
                <button class="verifyOtp" type="submit">Verify OTP</button>
            </div>
        </form>
    </div>
</body>
<script>
    const inputFields = document.querySelectorAll("input.field");

    inputFields.forEach((field, index) => {
        field.addEventListener("input", (e) => handleInput(e, index));
        field.addEventListener("keydown", (e) => handleKeyDown(e, index));
    });

    function handleInput(e, index) {
        let inputField = e.target;
        if (inputField.value.length >= 1) {
            let nextField = inputFields[index + 1];
            return nextField && nextField.focus();
        }
    }

    function handleKeyDown(e, index) {
        let inputField = e.target;
        if ((e.key === "Backspace" || e.key === "Delete") && inputField.value.length === 0 && index > 0) {
            let previousField = inputFields[index - 1];
            previousField.value = '';
            previousField.focus();
        }
    }

    const countdownElement = document.getElementById('countdown');
    const resendBtn = document.getElementById('resend-btn');
    let countdown = 60;

    const interval = setInterval(() => {
        countdown--;
        countdownElement.innerText = countdown;

        if (countdown === 0) {
            clearInterval(interval);
            resendBtn.innerText = "Resend OTP";
            resendBtn.disabled = false;
        }
    }, 1000);

    resendBtn.addEventListener('click', function() {
        resendBtn.innerText = 'Sending...';
        resendBtn.disabled = true;
        fetch('{{ url('resend-otp') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                        'content')
                },
                body: JSON.stringify({
                    email: '{{ request('email') }}'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    countdown = 60;
                    resendBtn.innerText = `Send again in ${countdown}s..`;
                    resendBtn.disabled = true;

                    const newInterval = setInterval(() => {
                        countdown--;
                        countdownElement.innerText = countdown;

                        if (countdown === 0) {
                            clearInterval(newInterval);
                            resendBtn.innerText = "Resend OTP";
                            resendBtn.disabled = false;
                        }
                    }, 1000);
                } else {
                    resendBtn.innerText = 'Resend OTP';
                    resendBtn.disabled = false;
                    alert('Failed to resend OTP. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                resendBtn.innerText = 'Resend OTP';
                resendBtn.disabled = false;
            });
    });
</script>

</html>
