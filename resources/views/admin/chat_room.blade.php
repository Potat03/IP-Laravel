@extends('admin.layout.main')

@section('title', 'Customer Support')

@section('css')
<link href="{{ asset('css/chat_room.css') }}" rel="stylesheet">
@endsection

@section('prev_page', route('admin.main'))
@section('page_title', 'Support Chat')
@section('page_gm', 'Be kind and help our customer')

@section('content')
<div class="content_wrap">
    <div class="chat_list">
        <div class="title"><span class="static_light yellow_light"></span>New Chat Request</div>
        <ul class="new_chat">
            <div class="empty">No Pending Chat</div>
        </ul>
        <div class="title"><span class="static_light green_light"></span>Active Chat</div>
        <ul class="active_chat">
            <div class="empty">No Active Chat</div>
        </ul>
    </div>
    <div class="chat_room">
        <div class="chat_room_wrap">
            <div class="user_info">
                <div class="user_name chat_hide" id="user_name"></div>
                <div class="action_bar chat_hide" title="View Their Cart">
                    <div class="main_action">
                        <div class="take_chat">
                            Accept
                        </div>
                        <div class="end_chat">
                            End
                        </div>
                    </div>
                </div>
                <div class="chat_error_msg hide">
                    <div class="chat_error_msg_icon">
                        <i class="fa-sharp fa-regular fa-circle-xmark"></i>
                    </div>
                    <p></p>
                </div>
            </div>
            <div class="chat_content">
                <div class="empty_message">Please select a chat.</div>

            </div>
            <div class="paste_area">

                <p class="paste_area_txt">Upload Image</p>

                <p class="paste_area_txt">Max (1)</p>
            </div>
            <form action="{{ route('sendMsg') }}" method="POST" id="msg_form" class="chat_input">
                @csrf
                <textarea type="text" class="chat_input_txt chat_hide" placeholder="Type your message..." rows="1"></textarea>
                <button class="chat_input_send chat_hide" type="submit">
                    <div class="input_send_icon">
                        <i class="fa-solid fa-paper-plane"></i>
                    </div>
                    Send
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    var last_msg_id = 0;
    var errorMsgTimeout = null;
    let live_update_interval = null;
    let live_chat_list_interval = null;
    var selected_chat_id = 0;
    var productRoute = "{{ url('admin/product/view') }}";
    $(document).ready(function() {

        // init chat list
        getChatList();

        // set interval to update chat list in close real-time
        live_chat_list_interval = setInterval(function() {
            getChatList();
        }, 2000);

        // Detect image paste, create image preview
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

                        if ($('.paste_area img').length >= 1) {
                            showErrorMsg('You can only upload 1 Image at a time');
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

        // Change textare height based on input
        $('.chat_input textarea').on('input change', function() {
            $(this).css('height', 'auto');
            $(this).css('height', this.scrollHeight - 20 + 'px');
            if ($(this).height() > 80) {
                $(this).css('height', '80px');
            }
            $(this).scrollTop($(this)[0].scrollHeight);
        });

        //Enter to submit in textarea
        $('.chat_input textarea').on('keydown', function(event) {
            if (event.keyCode === 13 && !event.shiftKey) {
                event.preventDefault();
                $('#msg_form').submit();
            }
        });

        // Close the error msg if on click
        $('.chat_error_msg').on('click', function() {
            $('.chat_error_msg').removeClass('show').addClass('hide');
        });

        // Register function for big preview to be close on click
        $('.big_preview_bg').on('click', function() {
            $('.image_big_preview').removeClass('show');
        });

        // Change to diff chat
        $('.chat_list').on('click', 'li', function() {
            changeChatRoom($(this).attr('chat-id'));
        });

        // Accept a chat
        $('.take_chat').on('click', function() {

            const chat_id = $('.chat_list li.active').attr('chat-id');

            const formData = new FormData();
            formData.append('chat_id', chat_id);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                method: 'POST',
                url: '{{ route("acceptChat") }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        resetChatRoom();
                        getChatList();
                        $('.chat_list li[chat-id="' + chat_id + '"]').attr('chat-status', 'active').detach().prependTo('.active_chat');

                    } else {
                        showErrorMsg(response.info);
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    showErrorMsg(response.info);
                }
            });
        });

        // End a chat
        $('.end_chat').on('click', function() {

            const chat_id = $('.chat_list li.active').attr('chat-id');

            const formData = new FormData();
            formData.append('chat_id', chat_id);
            formData.append('_token', "{{ csrf_token() }}");

            $.ajax({
                method: 'POST',
                url: '{{ route("endChat") }}',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.success) {
                        resetChatRoom();
                        getChatList();
                        selected_chat_id = 0;
                        $('.chat_list li[chat-id="' + chat_id + '"]').remove();

                    } else {
                        showErrorMsg(response.info);
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    showErrorMsg(response.info);
                }
            });
        });

        // Send message
        $('#msg_form').submit(function(e) {
            e.preventDefault();

            var message = $('.chat_input_txt').val();
            var images = $('.paste_area img');
            var imageSrc = images.length > 0 ? images.first().attr('src') : null;

            // if no input ignore
            if (message === '' && !imageSrc) {
                return;
            }

            // Clear the textarea and paste area
            $('.chat_input_txt').val('');
            $('.paste_area img').remove();
            $('.paste_area_remove').remove();
            $('.paste_area').removeClass('show');
            fixTextarea();

            // if in newline of text area add <br> to the message
            if (message.includes('\n')) {
                message = message.replace(/\n/g, '<br>');
            }

            // To stop the auto fetch , prevent display duplicate message


            if (imageSrc) {
                sendMessage('image', imageSrc);
            }

            if (message !== '') {
                sendMessage('text', message);
            }

        });
    });


    // API functions
    function getChatList() {

        // Get Chat List
        $.ajax({
            method: 'GET',
            url: '{{ route("getAdmChatList") }}',
            success: function(response) {
                const chats = response['chat_list'];

                //if the selected chat is not in return data (mean is ended) then remove the chat room
                $('.chat_list li').each(function() {
                    if (chats.findIndex(x => x['chat_id'] == $(this).attr('chat-id')) == -1) {
                        if ($(this).hasClass('active')) {
                            selected_chat_id = 0;
                            resetChatRoom();
                        }
                        $(this).remove();
                    }
                });

                chats.forEach(element => {

                    // check is chat change from pending to active, if so remove from pending
                    const is_change = $('.chat_list li[chat-id="' + element['chat_id'] + '"]').attr('chat-status') != element['status'];
                    if (is_change) {
                        $('.chat_list li[chat-id="' + element['chat_id'] + '"]').remove();
                    }

                    // check if exist in respective chat list,  
                    // if not append the chat to respective chat list accodring to status
                    if ($('.chat_list li[chat-id="' + element['chat_id'] + '"]').length == 0 || is_change) {
                        if (element['status'] === 'pending') {
                            $('.new_chat').append('<li chat-id="' + element['chat_id'] + '" chat-status="' + element['status'] + '" ><div class="chat_info">' + element['customer_name'] + '<span class="notice_light"></span></div><div class="recent_msg">' + element['latest_message'] + '</div></li>');
                        } else {
                            $('.active_chat').append('<li chat-id="' + element['chat_id'] + '" chat-status="' + element['status'] + '" ><div class="chat_info">' + element['customer_name'] + '<span class="notice_light"></span></div><div class="recent_msg">' + element['latest_message'] + '</div></li>');
                        }
                    }

                    //if latest msg change update in chat list
                    if ($('.chat_list li[chat-id="' + element['chat_id'] + '"] .recent_msg').text() != element['latest_message']) {
                        $('.chat_list li[chat-id="' + element['chat_id'] + '"] .recent_msg').text(element['latest_message']);
                        if (!$('.chat_list li[chat-id="' + element['chat_id'] + '"]').hasClass('active')) {
                            $('.chat_list li[chat-id="' + element['chat_id'] + '"] .notice_light').show();
                        }
                    }
                });

                // if previous selected chat change status, this will keep it focus
                if (selected_chat_id != 0) {
                    changeChatRoom(selected_chat_id);
                }

                // check if chat list is empty, if empty show empty message
                checkChatListEmpty();
            },
            error: function(xhr) {
                console.log(xhr.responseText);
            }
        });
    }

    function sendMessage(type, content) {

        const chat_id = $('.chat_list li.active').attr('chat-id');

        const formData = new FormData();
        formData.append('chat_id', chat_id);
        formData.append('message_type', type);

        if (type === 'text') {
            formData.append('message_content', content);
        } else {
            formData.append('message_content', dataURLToBlob(content), 'image.png');
        }

        formData.append('by_customer', 0);
        formData.append('_token', "{{ csrf_token() }}");

        clearInterval(live_update_interval);
        $.ajax({
            method: 'POST',
            url: '{{ route("sendMsg") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == true) {
                    fetchNewMessages();
                } else {
                    showErrorMsg(response.info);
                }
                live_update_interval = setInterval(fetchNewMessages, 2000);
            },
            error: function(xhr) {
                const response = JSON.parse(xhr.responseText);
                showErrorMsg(response.info);
                if (response.status != 500) {
                    live_update_interval = setInterval(fetchNewMessages, 2000);
                }
            }
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

                if (response.success) {

                    const messages = response['messages'];
                    messages.forEach(element => {
                        let html = generateMsgHtml(element);
                        $('.chat_content').append(html);
                    });

                    last_msg_id = response['last_msg_id'];

                    registerImgPreview();
                    $('.chat_content').scrollTop($('.chat_content')[0].scrollHeight);

                    //wait all iamge load then scroll to most bot
                    waitImageLoad();

                    live_update_interval = setInterval(fetchNewMessages, 2000);
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

    function fetchNewMessages() {

        //find chat_id from active li
        const chat_id = $('.chat_list li.active').attr('chat-id');

        $.ajax({
            method: 'GET',
            url: '{{ route("getNewMessages") }}',
            data: {
                chat_id: chat_id,
                last_msg_id: last_msg_id,
                by_customer: 0,
                _token: "{{ csrf_token() }}"
            },
            success: function(response) {
                if (response['success']) {
                    const messages = response['messages'];

                    if (messages.length === 0) {
                        return;
                    }

                    const image_load = [];

                    messages.forEach(element => {

                        //if exist ignore
                        if ($('.chat_content .chat_msg[msg-id="' + element['message_id'] + '"]').length > 0) {
                            return;
                        }

                        if (element['type'] === 'IMAGE') {
                            const img = $('<img>').attr('src', element['image_url']);
                            const deferred = $.Deferred();

                            img.on('load', function() {
                                deferred.resolve();
                            }).on('error', function() {
                                deferred.reject();
                            });
                            image_load.push(deferred.promise());
                        }

                        let html = generateMsgHtml(element);
                        $('.chat_content').append(html);
                    });

                    $.when.apply($, image_load).done(function() {
                        registerImgPreview();
                        $('.chat_content').scrollTop($('.chat_content')[0].scrollHeight);

                    })
                    last_msg_id = response['last_msg_id'];
                }
            },
            error: function(xhr) {
                const response = JSON.parse(xhr.responseText);
                showErrorMsg(response.info);
                clearInterval(live_update_interval);
            }
        });
    }

    // Utility functions

    function dataURLToBlob(dataURL) {
        const byteString = atob(dataURL.split(',')[1]);
        const mimeString = dataURL.split(',')[0].split(':')[1].split(';')[0];

        const ab = new ArrayBuffer(byteString.length);
        const ia = new Uint8Array(ab);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ab], {
            type: mimeString
        });
    }

    function generateMsgHtml(msg) {
        messageHtml = '';
        if (msg['type'] === 'TEXT') {
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="chat_msg ' + (msg['by_customer'] ? 'user_msg' : 'admin_msg') + ' show"><div class="chat_msg_txt">' + msg['text'] + '</div></div>';
        } else if (msg['type'] === 'IMAGE') {
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="chat_msg chat_msg_img_box ' + (msg['by_customer'] ? 'user_msg' : 'admin_msg') + ' show"><div class="chat_msg_img"><img src="' + msg['image_url'] + '" alt="User Image"></div></div>';
        } else if (msg['type'] === 'PRODUCT') {
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="chat_msg product_msg ' + (msg['by_customer'] ? 'user_msg' : 'admin_msg') + ' product_msg show"><div class="product_msg_header"><img src="' + msg['image'] + '" alt="Product Image"><div class="product_msg_title">' + msg['name'] + '(' + msg['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="' + productRoute + '/' + msg['id'] + '" target="_blank">Click to View</a></div></div>';
        }
        return messageHtml;
    }

    // UI functions
    function changeChatRoom(id) {
        const clicked_li = $('.chat_list li[chat-id="' + id + '"]')[0];
        const parent = $(clicked_li).parent();
        if ($(clicked_li).hasClass('active')) {
            return;
        }
        selected_chat_id = id;
        resetChatRoom();
        $('.chat_list li[chat-id="' + id + '"]').addClass('active');
        $('#user_name').text($('.chat_list li[chat-id="' + id + '"] .chat_info').text());
        $('.empty_message').hide();
        $('.chat_hide').removeClass('chat_hide');
        $(clicked_li).detach();
        $(parent).prepend(clicked_li);
        $(clicked_li).find('.notice_light').hide();

        if ($(clicked_li).attr('chat-status') == 'pending') {
            $('.take_chat').addClass('action_show');
            $('.chat_input_txt').addClass('chat_hide');
            $('.chat_input_send').addClass('chat_hide');
        } else {
            $('.end_chat').addClass('action_show');
        }
        showChat(id);
    }

    function fixTextarea() {
        const ele = $('.chat_input textarea');
        ele.css('height', 'auto');
        ele.css('height', this.scrollHeight - 20 + 'px');
        if (ele.height() > 80) {
            ele.css('height', '80px');
        }
        ele.scrollTop(ele[0].scrollHeight);
    }

    function resetChatRoom() {
        $('.chat_list li').removeClass('active');
        $('#user_name').val('');
        $('.empty_message').show();
        $('.chat_input_txt').val('');
        $('.chat_input_txt').addClass('chat_hide');
        $('.chat_input_send').addClass('chat_hide');
        $('#user_name').addClass('chat_hide');
        $('.action_bar').addClass('chat_hide');
        $('.action_show').removeClass('action_show');
        $('.paste_area img').remove();
        $('.paste_area').removeClass('show');
        $('.paste_area_remove').remove();
        $('.chat_msg').remove();
        fixTextarea();
        last_msg_id = 0;
        clearInterval(live_update_interval);
    }

    function showErrorMsg(err_msg) {
        if ($('.chat_error_msg').hasClass('show')) {
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

    function waitImageLoad() {
        const images = $('.chat_content img');
        let imagesLoaded = 0;

        $('.chat_content img').on('load', function() {
            imagesLoaded++;
            if (imagesLoaded === images.length) {
                $('.chat_content').scrollTop($('.chat_content')[0].scrollHeight);
            }
        });
    }

    function checkChatListEmpty() {
        if ($('.new_chat li').length === 0) {
            $('.new_chat .empty').addClass('show');
        } else {
            $('.new_chat .empty').removeClass('show');
        }

        if ($('.active_chat li').length === 0) {
            $('.active_chat .empty').addClass('show');
        } else {
            $('.active_chat .empty').removeClass('show');
        }
    }

</script>
@endsection