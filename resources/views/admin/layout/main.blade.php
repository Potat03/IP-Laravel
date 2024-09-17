<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    @include('partials.fontawesome')
    <link href="{{ asset('css/admin_nav.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    @yield('vite')
    @yield('css')
</head>

<body>
    <div class="admin_content">

        <div class="image_big_preview">
            <div class="image_big_preview_wrap">
                <div class="big_preview_bg"></div>
                <div class="big_preview_wrap">
                    <div class="big_preview_container">
                        <img class="big_preview_element" src="https://via.placeholder.com/42" alt="Image Preview">
                    </div>
                </div>
            </div>
        </div>

        <div class="top_content">
            <div class="top_left">
                <h1>Futatabi</h1>
            </div>
            <div class="top_middle">
                <div class="current_time">
                    <p class="cur_date m-0">12/12/2021</p>
                    <p class="cur_time m-0">12:00 AM</p>
                </div>
            </div>
            <div class="top_right">
                <img src="https://www.w3schools.com/howto/img_avatar.png" alt="profile picture">
                <div class="top_right_drop_down_menu">
                    <ul>
                        <li><a href="#">
                                <div class="li_icon_wrap">
                                    <i class="fa-regular fa-address-card"></i>
                                </div>
                                Profile
                            </a>
                        </li>
                        <li><a href="{{ route('admin.logout') }}">
                                <div class="li_icon_wrap">
                                    <i class="fa-regular fa-person-from-portal"></i>
                                </div>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="bottom_content">
            <div class="left_bar">
                <ul>
                    <li @stack('main')>
                        <a href="{{ route('admin.main') }}">
                            <i class="fa-regular fa-square-poll-vertical"></i>
                            DashBoard
                        </a>
                    </li>
                    <li @stack('product')>
                        <a href="{{ route('admin.product') }}">
                            <i class="fa-regular fa-teddy-bear"></i>
                            Product
                        </a>

                    </li>
                    <li @stack('promotion')>
                        <a href="{{ route('admin.promotion') }}">
                            <i class="fa-regular fa-megaphone"></i>
                            Promotion
                        </a>
                    </li>
                    <li @stack('chat')>
                        <a href="{{ url('adminChat2') }}">
                            <i class="fa-brands fa-rocketchat"></i>
                            Support Chat
                        </a>
                    </li>
                    <li @stack('order')>
                        <a href="#">
                            <i class="fa-regular fa-box"></i>
                            Order
                        </a>
                    </li>
                    <li @stack('customer')>
                        <a href="#">
                            <i class="fa-regular fa-user"></i>
                            Customer
                        </a>
                    </li>
                    <li @stack('report')>
                        <a type="button" data-bs-toggle="collapse" href="#collapseReport" role="button" aria-expanded="false" aria-controls="collapseReport">
                            <i class="fa-regular fa-chart-bar"></i>
                            Report
                        </a>
                        <div class="collapse" id="collapseReport">
                            <ul>
                                <li><a href="">Sales Report</a></li>
                                <li><a href="">Product Report</a></li>
                                <li><a href="">Customer Report</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="right_content">
                <div class="upper_content">
                    <div class="back_btn">
                        <a href="#">
                            <i class="fa-solid fa-arrow-left"></i></a>
                    </div>
                    <div class="title">
                        <h1>@yield('page_title')</h1>
                        <p>@yield('page_gm')</p>
                    </div>
                </div>
                <div class="lower_content overflow-auto">
                    @yield('content')
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                fixHeight();

                $('.top_right').on('click', function() {
                    $('.top_right_drop_down_menu').toggleClass('show');
                });

                $('.admin_content').on('click', function(event) {
                    if (!$(event.target).closest('.top_right').length) {
                        $('.top_right_drop_down_menu').removeClass('show');
                    }
                });
                updateTime();
            });

            $(window).resize(function() {
                fixHeight();
            });

            function fixHeight() {
                $('.lower_content').css('max-height', $('.admin_content').height() - 200);
            }

            function updateTime() {
                var date = new Date();
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12;
                hours = hours ? hours : 12;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                $('.cur_time').text(strTime);

                var monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                var month = monthNames[date.getMonth()];
                var day = date.getDate();
                var year = date.getFullYear();
                var strDate = day + ' ' + month + ' ' + year;
                $('.cur_date').text(strDate);

            }
        </script>

        @yield('js')
</body>

</html>