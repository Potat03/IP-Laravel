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

        </ul>
        <div class="title"><span class="static_light green_light"></span>Active Chat</div>
        <ul class="active_chat">

        </ul>
    </div>
    <div class="chat_room">
        <div class="chat_room_wrap">
            <div class="user_info">
                <div class="user_name chat_hide" id="user_name"></div>
                <div class="action_bar chat_hide" title="View Their Cart">
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
                <div class="empty_message">Please select a chat.</div>
                <!-- <div class="chat_msg admin_msg">
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
                </div> -->
                <div class="chat_error_msg hide">
                    <div class="chat_error_msg_icon">
                        <i class="fa-sharp fa-regular fa-circle-xmark"></i>
                    </div>
                    <p>You can only upload 3 Image at a time</p>
                </div>
            </div>
            <div class="paste_area">

                <p class="paste_area_txt">Upload Image</p>

                <p class="paste_area_txt">Max (3)</p>
            </div>
            <div class="chat_input">
                <textarea type="text" class="chat_input_txt chat_hide" placeholder="Type your message..." rows="1"></textarea>
                <div class="chat_input_send chat_hide">
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

        $.ajax({
            method: 'GET',
            url: '{{ route("getAdmChatList") }}',
            success: function(response) {
                const chats = response['chat_list'];
                console.log(chats);
                chats.forEach(element => {
                    if (element['status'] === 'pending') {
                        $('.new_chat').append('<li chat-id="' + element['chat_id'] + '" chat-status="' + element['status'] + '" ><div class="chat_info">' + element['customer_name'] + '<span class="notice_light"></span></div><div class="recent_msg">' + element['latest_message'] + '</div></li>');
                    } else {
                        $('.active_chat').append('<li chat-id="' + element['chat_id'] + '" chat-status="' + element['status'] + '" ><div class="chat_info">' + element['customer_name'] + '</div><div class="recent_msg">' + element['latest_message'] + '</div></li>');
                    }
                });
            },
            error: function(xhr) {
                console.log(xhr.responseText);
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

        $('.chat_error_msg').on('click', function() {
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

        registerImgPreview();


        $('.chat_list').on('click', 'li', function() {
            changeChatRoom($(this).attr('chat-id'));
        });

        $('.end_chat').on('click', function() {
            const chat_id = $('.chat_list li.active').attr('chat-id');
            resetChatRoom();

        });

        $('.chat_input_send').on('click', function() {
            const message = $('.chat_input_txt').val();
            const images = [];
            $('.paste_area img').each(function() {
                images.push($(this).attr('src'));
            });

            if (message === '' && images.length === 0) {
                return;
            }

            const chat_id = $('.chat_list li.active').attr('chat-id');


        });
    });

    function fixTextarea() {
        const ele = $('.chat_input textarea');
        ele.css('height', 'auto');
        ele.css('height', this.scrollHeight - 20 + 'px');
        if (ele.height() > 80) {
            ele.css('height', '80px');
        }
        ele.scrollTop(ele[0].scrollHeight);
    }

    function changeChatRoom(id) {
        const clicked_li = $('.chat_list li[chat-id="' + id + '"]')[0];
        if ($(clicked_li).hasClass('active')) {
            return;
        }
        resetChatRoom();
        $('.chat_list li').removeClass('active');
        $('.chat_list li[chat-id="' + id + '"]').addClass('active');
        $('#user_name').text($('.chat_list li[chat-id="' + id + '"] .chat_info').text());
        $('.empty_message').hide();
        $('.chat_hide').removeClass('chat_hide');
        $('.chat_msg').remove();

        if ($(clicked_li).attr('chat-status') == 'pending') {
            $('.take_chat').addClass('action_show');
        } else {
            $('.end_chat').addClass('action_show');
        }
        showChat(id);
    }

    function resetChatRoom() {
        $('.chat_list li').removeClass('active');
        $('#user_name').val('')
        $('.empty_message').show();
        fixTextarea();
        $('.chat_input_txt').val('');
        $('.chat_input_txt').addClass('chat_hide');
        $('.chat_input_send').addClass('chat_hide');
        $('#user_name').addClass('chat_hide');
        $('.action_show').removeClass('action_show');
        $('.action_bar').addClass('chat_hide');
        $('.paste_area img').remove();
        $('.paste_area').removeClass('show');
    }

    var errorMsgTimeout = null;
    function showErrorMsg(err_msg) {
    if ($('.chat_error_msg').hasClass('show')){
        $('.chat_error_msg').removeClass('show');
    }

    $('.chat_error_msg p').text(err_msg);
    $('.chat_error_msg').removeClass('hide').addClass('show');

    if (errorMsgTimeout) {
        clearTimeout(errorMsgTimeout);
    }

    errorMsgTimeout = setTimeout(function() {
        $('.chat_error_msg').removeClass('show').addClass('hide');
    }, 6000);
}

    function registerImgPreview() {
        $('.chat_room img').on('click', function(event) {
            $('.image_big_preview').addClass('show');
            $('.big_preview_element').attr('src', event.target.src);
        });
    }

    function showChat(chat_id) {
        $.ajax({
            method: 'GET',
            url: '{{ route("getChatMessage") }}',
            data: {
                chat_id: chat_id
            },
            success: function(response) {

                if (response.success == true) {

                    const messages = response['messages'];
                    messages.forEach(element => {
                        if (element['type'] === 'TEXT') {
                            if (element['by_customer']) {
                                $('.chat_content').append('<div class="chat_msg user_msg"><div class="chat_msg_txt">' + element['text'] + '</div></div>');
                            } else {
                                $('.chat_content').append('<div class="chat_msg admin_msg"><div class="chat_msg_txt">' + element['text'] + '</div></div>');
                            }
                        } else if (element['type'] === 'IMAGE') {
                            if (element['by_customer']) {
                                $('.chat_content').append('<div class="chat_msg chat_msg_img_box user_msg"><div class="chat_msg_img"><img src="' + element['image_url'] + '" alt="User Image"></div></div>');
                            } else {
                                $('.chat_content').append('<div class="chat_msg chat_msg_img_box admin_msg"><div class="chat_msg_img"><img src="' + element['image_url'] + '" alt="User Image"></div></div>');
                            }
                        } else if (element['type'] === 'PRODUCT') {
                            if (element['by_customer']) {
                                $('.chat_content').append('<div class="chat_msg admin_msg product_msg"><div class="product_msg_header"><img src="' + element['image'] + '" alt="Product Image"><div class="product_msg_title">' + element['name'] + '(' + element['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="#">Click to View</a></div></div>');
                            } else {
                                $('.chat_content').append('<div class="chat_msg user_msg product_msg"><div class="product_msg_header"><img src="' + element['image'] + '" alt="Product Image"><div class="product_msg_title">' + element['name'] + '(' + element['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="#">Click to View</a></div></div>');
                            }
                        }
                    });
                    registerImgPreview();
                } else {
                    showErrorMsg(response.info);
                }
            },
            error: function(xhr) {
                const response = JSON.parse(xhr.responseText);
                showErrorMsg(response.info);
            }
        });
    }
</script>
@endsection