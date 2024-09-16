@extends('admin.layout.main')

@section('title', 'Customer Support')

@section('css')
<link href="{{ asset('css/chat_room.css') }}" rel="stylesheet">
@endsection


@section('page_title', 'Support Chat')
@section('page_gm', 'Be kind and help our customer')

@section('content')
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
@endsection

@section('js')
<script>
    $(document).ready(function() {

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
</script>
@endsection