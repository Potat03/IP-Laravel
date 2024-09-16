<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Customer Support</title>

    @include('partials.fontawesome')
    <link href="{{ asset('css/admin_nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/chat_room.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
                    <p class="cur_date">12/12/2021</p>
                    <p class="cur_time">12:00 AM</p>
                </div>
            </div>
            <div class="top_right">
                <div class="bell">
                    <i class="fa-solid fa-bell"></i>
                </div>
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
                        <li><a href="#">
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
                    <li><a href="#">
                        <i class="fa-solid fa-square-poll-vertical"></i>
                        DashBoard</a>
                    </li>
                    <li><a href="#">
                        <i class="fa-regular fa-teddy-bear"></i>
                        Product</a>
                    </li><a href="#">
                    <li class="active">
                        <i class="fa-brands fa-rocketchat"></i>
                        Support Chat</a>
                    </li>
                    <li><a href="#">
                        <i class="fa-regular fa-box"></i>
                        Order</a>
                    </li>
                    <li><a href="#">
                        <i class="fa-regular fa-user"></i>
                        Customer</a>
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
                        <h1>Support Chat</h1>
                        <p>Be kind and help our customer</p>
                    </div>
                </div>
                <div class="lower_content">
                    <div class="content_wrap">
                        <div class="chat_list">
                            <div class="title"><span class="static_light yellow_light"></span>New Chat Request</div>
                            <ul class="new_chat">
                                <li>
                                    <div class="chat_info">
                                        User1 <span class="notice_light"></span>
                                    </div>
                                    <div class="recent_msg">
                                        Hello
                                    </div>
                                </li>
                                <li class="active">
                                    <div class="chat_info">
                                        User1
                                    </div>
                                    <div class="recent_msg">
                                        Hello
                                    </div>
                                </li>
                                <li>
                                    <div class="chat_info">
                                        User1
                                    </div>
                                    <div class="recent_msg">
                                        Hello you are happu i am happy very very happiu
                                    </div>
                                </li>
                            </ul>
                            <div class="title"><span class="static_light green_light"></span>Active Chat</div>
                            <ul class="active_chat">
                                <li>
                                    <div class="chat_info">
                                        User1 <span class="notice_light"></span>
                                    </div>
                                    <div class="recent_msg">
                                        Hello
                                    </div>
                                </li>
                                <li class="active">
                                    <div class="chat_info">
                                        User1
                                    </div>
                                    <div class="recent_msg">
                                        Hello
                                    </div>
                                </li>
                                <li>
                                    <div class="chat_info">
                                        User1
                                    </div>
                                    <div class="recent_msg">
                                        Hello you are happu i am happy very very happiu
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="chat_room">
                            <div class="chat_room_wrap">
                                <div class="user_info">
                                    <div class="user_name">HuskyBoiz</div>
                                    <div class="action_bar" title="View Their Cart">
                                        <div class="view_order icon_action">
                                            <i class="fa-regular fa-cart-shopping"></i>
                                        </div>
                                        <div class="view_order icon_action">
                                            <i class="fa-regular fa-box"></i>
                                        </div>
                                        <div class="view_pre_chat icon_action" title="View Their Chat History">
                                            <i class="fa-regular fa-comments-question"></i>
                                        </div>

                                        <div class="main_action">
                                            <div class="take_chat">
                                                Accept
                                            </div>
                                            <div class="end_chat">
                                                End
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="chat_content">
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg user_msg">
                                        <div class="chat_msg_txt">Hello</div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg chat_msg_img_box admin_msg">
                                        <div class="chat_msg_img">
                                            <img src="https://via.placeholder.com/48" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg product_msg">
                                        <div class="product_msg_header">
                                            <img src="https://via.placeholder.com/48" alt="Product Image">
                                            <div class="product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                                        </div>
                                        <div class="product_msg_link">
                                            <hr>
                                            <a class="product_msg_footer" href="#">Click to View</a>
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg user_msg">
                                        <div class="chat_msg_txt">Hello</div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg chat_msg_img_box admin_msg">
                                        <div class="chat_msg_img">
                                            <img src="https://via.placeholder.com/48" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg product_msg">
                                        <div class="product_msg_header">
                                            <img src="https://via.placeholder.com/48" alt="Product Image">
                                            <div class="product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                                        </div>
                                        <div class="product_msg_link">
                                            <hr>
                                            <a class="product_msg_footer" href="#">Click to View</a>
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg user_msg">
                                        <div class="chat_msg_txt">Hello</div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg chat_msg_img_box admin_msg">
                                        <div class="chat_msg_img">
                                            <img src="https://via.placeholder.com/48" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg product_msg">
                                        <div class="product_msg_header">
                                            <img src="https://via.placeholder.com/48" alt="Product Image">
                                            <div class="product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                                        </div>
                                        <div class="product_msg_link">
                                            <hr>
                                            <a class="product_msg_footer" href="#">Click to View</a>
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg user_msg">
                                        <div class="chat_msg_txt">Hello</div>
                                    </div>
                                    <div class="chat_msg admin_msg">
                                        <div class="chat_msg_txt">Hi, How can I help you?</div>
                                    </div>
                                    <div class="chat_msg chat_msg_img_box admin_msg">
                                        <div class="chat_msg_img">
                                            <img src="https://via.placeholder.com/48" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="chat_msg admin_msg product_msg">
                                        <div class="product_msg_header">
                                            <img src="https://via.placeholder.com/48" alt="Product Image">
                                            <div class="product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                                        </div>
                                        <div class="product_msg_link">
                                            <hr>
                                            <a class="product_msg_footer" href="#">Click to View</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="paste_area">
                                    <div class="chat_error_msg hide">
                                        <div class="chat_error_msg_icon">
                                            <i class="fa-sharp fa-regular fa-circle-xmark"></i>
                                        </div>
                                        <p>You can only upload 3 Image at a time</p>
                                    </div>
                                    <p class="paste_area_txt">Upload Image</p>

                                    <p class="paste_area_txt">Max (3)</p>
                                </div>
                                <div class="chat_input">
                                    <textarea type="text" class="chat_input_txt" placeholder="Type your message..." rows="1"></textarea>
                                    <div class="chat_input_send">
                                        <div class="input_send_icon">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </div>
                                        Send
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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

                $('.chat_input textarea').on('paste', function(event) {
                    event.preventDefault();
                    const items = event.originalEvent.clipboardData.items;
                    const text = event.originalEvent.clipboardData.getData('text');

                    if (text) {
                        document.execCommand('insertText', false, text);
                    }

                    for (let i = 0; i < items.length; i++) {
                        const item = items[i];

                        if (item.kind === 'file' && item.type.startsWith('image/')) {
                            const blob = item.getAsFile();
                            const reader = new FileReader();

                            reader.onload = function(event) {

                                if ($('.paste_area img').length >= 3) {
                                    showErrorMsg('You can only upload 3 Image at a time');
                                    return;
                                }

                                const imgContainer = $('<div class="paste_area_container"></div>');
                                const img = $('<img>').attr('src', event.target.result);
                                const deleteButton = $('<button class="paste_area_remove"><i class="fa-solid fa-trash"></i></button>');
                                imgContainer.append(img).append(deleteButton);
                                $('.paste_area > p:first').after(imgContainer);
                                $('.paste_area').addClass('show');

                                deleteButton.on('click', function() {
                                    imgContainer.remove();
                                    if ($('.paste_area img').length === 0) {
                                        $('.paste_area').removeClass('show');
                                    }
                                });

                                registerImgPreview();
                            };

                            reader.readAsDataURL(blob);
                        }
                    }
                });


                function showErrorMsg(err_msg) {
                    if ($('.chat_error_msg').hasClass('show')) {
                        return;
                    }

                    $('.chat_error_msg p').text(err_msg);
                    $('.chat_error_msg').removeClass('hide').addClass('show');

                    setTimeout(function() {
                        $('.chat_error_msg').removeClass('show').addClass('hide');
                    }, 6000);
                }

                $('.chat_error_msg_icon').on('click', function() {
                    $('.chat_error_msg').removeClass('show').addClass('hide');
                });

                $('.chat_input textarea').on('input change', function() {
                    $(this).css('height', 'auto');
                    $(this).css('height', this.scrollHeight - 20 + 'px');
                    if ($(this).height() > 80) {
                        $(this).css('height', '80px');
                    }
                    $(this).scrollTop($(this)[0].scrollHeight);
                });

                $('.big_preview_bg').on('click', function() {
                    $('.image_big_preview').removeClass('show');
                });


                function registerImgPreview() {
                    $('.chat_room img').on('click', function(event) {
                        $('.image_big_preview').addClass('show');
                        $('.big_preview_element').attr('src', event.target.src);
                    });
                }
                registerImgPreview();

                setInterval(function() {
                    updateTime();
                }, 1000);
            });

            updateTime();

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
                hours = hours ? hours : 12; // the hour '0' should be '12'
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
</body>

</html>