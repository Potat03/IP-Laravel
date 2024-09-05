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

        p span.phone-number {
            display: block;
            color: #093030;
            font-weight: 600;
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

        button.resend {
            background-color: transparent;
            border: none;
            font-weight: 600;
            color: #c0392b;
            cursor: pointer;
        }

        button.resend i {
            margin-left: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h3 class="title">OTP Verification</h3>
        <p class="sub-title">
            Enter the OTP you received to
            <span class="phone-number">sittisak@hotmail.com</span>
        </p>
        <div class="wrapper">
            <input type="text" class="field 1" maxlength="1">
            <input type="text" class="field 2" maxlength="1">
            <input type="text" class="field 3" maxlength="1">
            <input type="text" class="field 4" maxlength="1">
            <input type="text" class="field 5" maxlength="1">
            <input type="text" class="field 6" maxlength="1">
        </div>
        <button class="resend">
            Resend OTP
            <i class="fa fa-caret-right"></i>
        </button>
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

        if (e.key === "Backspace" || e.key === "Delete") {
            if (inputField.value.length === 0 && index > 0) {
                let previousField = inputFields[index - 1];
                previousField.value = ''; // clear the previous field
                previousField.focus();
            }
        }
    }
</script>

</html>
