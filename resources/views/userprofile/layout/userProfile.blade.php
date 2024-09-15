<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @vite(['resources/css/app.css', 'resources/sass/app.scss', 'resources/js/app.js', 'resources/js/bootstrap.js'])
    @include('partials.fontawesome')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .profile_content {
            display: flex;
            flex-direction: column;
            height: 100vh;
            overflow: hidden;
            min-height: 500px;
        }

        .content {
            display: flex;
            height: 100%;
            flex-grow: 1;
        }

        .left_bar {
            display: flex;
            flex-direction: column;
            width: 250px;
            background-color: #800000;
            color: white;
            padding: 20px;
            gap: 20px;
            box-shadow: 0px 2px 10px 0px rgba(0, 0, 0, 0.60);
        }

        .left_bar ul {
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 10px;
            display: flex;
            flex-direction: column;
        }


        .left_bar li {
            list-style: none;
            padding: 10px;
            cursor: pointer;
            transition: all 0.1s;
            font-weight: 600;
            border-radius: 5px;
        }

        .left_bar a {
            color: white;
            text-decoration: none;
            transition: all 0.1s;
        }

        .left_bar i {
            font-size: 20px;
            width: 25px;
            text-align: center;
        }

        .left_bar li:hover {
            background-color: black;
        }

        .left_bar li:active {
            scale: 0.9;
        }

        .left_bar li.active {
            background-color: white;
        }

        .left_bar li.active a {
            color: #800000;
        }

        .right_content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
            font-family: "Open Sans", Helvetica, Arial, sans-serif;
            background: #f0f0f0;
            overflow-y: hidden;
        }
    </style>
</head>

<body>
    @include('header')
    <div class="profile_content">
        <div class="content">
            <div class="left_bar">
                <ul>
                    <li>
                        <a href="javascript:void(0);" class="load-content" data-url="{{ route('profile.profileSec') }}">
                            <i class="fa-solid fa-square-poll-vertical"></i>
                            Profile
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="load-content"
                            data-url="{{ route('profile.orderHistorySec') }}">
                            <i class="fa-regular fa-teddy-bear"></i>
                            Order History
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="load-content"
                            data-url="{{ route('profile.shippingSec') }}">
                            <i class="fa-regular fa-box"></i>
                            Shipping
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="load-content"
                            data-url="{{ route('profile.supportChatSec') }}">
                            <i class="fa-brands fa-rocketchat"></i>
                            Support Chat
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="load-content" data-url="{{ route('profile.settingSec') }}">
                            <i class="fa-regular fa-user"></i>
                            Settings
                        </a>
                    </li>
                </ul>
            </div>

            <div class="right_content">
                <div class="lower_content overflow-auto">
                    @yield('content')
                </div>
            </div>
        </div>
</body>
<script>
    $(document).ready(function() {
        $('.load-content').on('click', function(e) {
            e.preventDefault();

            var url = $(this).data('url');
            console.log('Requesting URL:', url);

            $.ajax({
                url: url,
                method: 'GET',
                success: function(response) {
                    console.log('Response received:', response);
                    $('.right_content').html(response);
                },
                error: function(xhr, status, error) {
                    console.error('Error loading content:', error, xhr
                        .responseText);
                }
            });
        });
    });
</script>

</html>
