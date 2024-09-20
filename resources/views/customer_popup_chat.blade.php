<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CustomerChatDemo</title>

    @include('partials.fontawesome')
    <link href="{{ asset('css/support_popup.css') }}" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body style="background-color: transparent;">
    <div class="popup_btn">
        <div class="popup_btn_txt show">Need Some Help ? <br> <strong>Click Here</strong></div>
        <div class="popup_error_msg hide">
            <div class="popup_error_msg_icon">
                <i class="fa-sharp fa-regular fa-circle-xmark"></i>
            </div>
            <p></p>
        </div>
        <div class="popup_btn_icon shadow">
            <i class="fa-solid fa-comments-question"></i>
        </div>
    </div>

    <div class="popup_image_big_preview">
        <div class="popup_image_big_preview_wrap">
            <div class="big_preview_bg"></div>
            <div class="big_preview_wrap">
                <div class="big_preview_container">
                    <img class="big_preview_element" src="https://via.placeholder.com/42" alt="Image Preview">
                </div>
            </div>
        </div>
    </div>

    <div class="popup_box hide">
        <div class="popup_image_preview hide">
            <div class="popup_image_preview_container">
                <img class="popup_image_preview_element" src="https://via.placeholder.com/48" alt="Image Preview">
            </div>
        </div>
        <div class="popup_box_header">
            <div class="popup_box_header_txt">Customer Support</div>
            <div class="popup_box_header_icon">
                <i class="fa-sharp fa-regular fa-circle-xmark"></i>
            </div>
        </div>
        <div class="popup_box_body">
            <div class="popup_box_body_chat">
                <div class="start_message">Enter message to start</div>
                <div class="chat_ended_message hide">Chat is ended<br>Rate your experience
                    <div class="rate_btn_holder">
                        <button class="rate_btn" data-rate="1">Bad</button>
                        <button class="rate_btn" data-rate="2">Not Bad</button>
                        <button class="rate_btn" data-rate="3">Ok</button>
                        <button class="rate_btn" data-rate="4">Nice</button>
                        <button class="rate_btn" data-rate="5">Excellent</button>
                    </div>
                </div>
            </div>
            <div class="paste_area">
                <p class="paste_area_txt">Upload Image</p>

                <p class="paste_area_txt">Max (1)</p>
            </div>
            <form action="{{ route('sendMsg') }}" method="POST" id="msg_form" class="popup_box_body_input">
                @csrf
                <textarea type="text" class="popup_box_body_input_txt" placeholder="Type your message..." rows="1"></textarea>
                <button class="popup_box_body_input_send" type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                </button>
            </form>
        </div>
    </div>

    <script>
        var last_msg_id = 0;
        let intervalId = null;
        $(document).ready(function() {
            //init chat
            $.ajax({
                method: 'GET',
                url: '{{ route("getCustomerChat") }}',
                success: function(response) {
                    if (response['success']) {
                        const messages = response['messages'];
                        messages.forEach(element => {
                            if (element['type'] === 'TEXT') {
                                if (element['by_customer']) {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg user"><div class="popup_box_body_chat_msg_txt">' + element['text'] + '</div></div>');
                                } else {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg admin"><div class="popup_box_body_chat_msg_txt">' + element['text'] + '</div></div>');
                                }
                            } else if (element['type'] === 'IMAGE') {
                                if (element['by_customer']) {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg user"><div class="popup_box_body_chat_msg_img"><img src="' + element['image_url'] + '" alt="User Image"></div></div>');
                                } else {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg admin"><div class="popup_box_body_chat_msg_img"><img src="' + element['image_url'] + '" alt="User Image"></div></div>');
                                }
                            } else if (element['type'] === 'PRODUCT') {
                                if (element['by_customer']) {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg admin product_msg"><div class="product_msg_header"><img src="' + element['image'] + '" alt="Product Image"><div class="product_msg_title">' + element['name'] + '(' + element['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="#">Click to View</a></div></div>');
                                } else {
                                    $('.popup_box_body_chat').append('<div class="popup_box_body_chat_msg user product_msg"><div class="product_msg_header"><img src="' + element['image'] + '" alt="Product Image"><div class="product_msg_title">' + element['name'] + '(' + element['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="#">Click to View</a></div></div>');
                                }
                            }
                        });

                        $('.start_message').hide();

                        last_msg_id = response['last_msg_id'];
                        $('.popup_box_body_chat').attr('chat-id', response['chat_id']);

                        registerImgPreview();
                        $('.popup_box_body_chat').scrollTop($('.popup_box_body_chat')[0].scrollHeight);

                        //wait all iamge load then scroll to most bot
                        waitImageLoad();
                        intervalId = setInterval(fetchNewMessages, 2000);
                    } else {
                        $('.start_message').show();
                    }
                },
                error: function(xhr) {
                    return;
                }
            });


            $('.popup_btn_icon, .popup_btn_txt').click(function() {
                var popupBox = $('.popup_box');
                var popupTxt = $('.popup_btn_txt');
                var allMsgs = $('.popup_box_body_chat_msg');
                var totalMsgs = allMsgs.length;

                if (popupBox.hasClass('show')) {
                    popupBox.removeClass('show').addClass('hide');
                    popupTxt.removeClass('hide').addClass('show');
                    allMsgs.removeClass('show');
                } else {
                    popupBox.removeClass('hide').addClass('show');
                    popupTxt.removeClass('show').addClass('hide');


                    // terus show all without delay until last 10
                    allMsgs.each(function(index) {
                        if (index < totalMsgs - 10) {
                            $(this).addClass('show');
                        }
                    });


                    // apply delay for last 10
                    allMsgs.slice(-10).each(function(index) {
                        $(this).delay(index * 50).queue(function(next) {
                            $(this).addClass('show');
                            next();
                        });
                    });
                }
            });

            $('.popup_box_header_icon').click(function() {
                $('.popup_box').removeClass('show').addClass('hide');
                $('.popup_btn_txt').removeClass('hide').addClass('show');
            });

            $('.popup_box_body_input textarea').on('input change', function() {
                $(this).css('height', 'auto');
                $(this).css('height', this.scrollHeight + 'px');
                if ($(this).height() > 50) {
                    $(this).css('height', '50px');
                }
                $(this).scrollTop($(this)[0].scrollHeight);
            });

            $('.popup_box_body_input textarea').on('paste', function(event) {
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

            $('.big_preview_bg').on('click', function() {
                $('.popup_image_big_preview').removeClass('show');
            });

            //Enter to submit in textarea
            $('.popup_box_body_input_txt').on('keydown', function(event) {
                if (event.keyCode === 13 && !event.shiftKey) {
                    event.preventDefault();
                    $('#msg_form').submit();
                }
            });

            // Send message
            $('#msg_form').submit(async function(e) {
                e.preventDefault();

                var message = $('.popup_box_body_input_txt').val();
                // if in newline of text area add <br> to the message
                var images = $('.paste_area img');
                var imageSrc = images.length > 0 ? images.first().attr('src') : null;

                // if no input ignore
                if (message === '' && !imageSrc) {
                    return;
                }

                $('.popup_box_body_input_txt').val('');
                $('.paste_area img').remove();
                $('.paste_area_remove').remove();
                $('.paste_area').removeClass('show');
                fixTextarea();

                if (message.includes('\n')) {
                    message = message.replace(/\n/g, '<br>');
                }

                var chat_id = $('.popup_box_body_chat').attr('chat-id');

                if (!chat_id) {
                    chat_id = await createChat()
                };

                if (!chat_id) {
                    showErrorMsg('Failed to create chat');
                    return;
                };


                clearInterval(intervalId);
                if (imageSrc) {

                    const formData = new FormData();
                    formData.append('chat_id', chat_id);
                    formData.append('message_type', 'image');
                    formData.append('message_content', dataURLToBlob(imageSrc), 'image.png'); // Append Blob with a filename
                    formData.append('by_customer', 1);
                    formData.append('_token', "{{ csrf_token() }}");

                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('action'),
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.success == true) {
                                fetchNewMessages();
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

                if (message !== '') {
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('action'),
                        data: {
                            chat_id: chat_id,
                            message_type: "text",
                            message_content: message,
                            by_customer: 1,
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success == true) {
                                fetchNewMessages();
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
                intervalId = setInterval(fetchNewMessages, 2000);
            });


            $('.rate_btn').on('click', function() {
                const rate = $(this).attr('data-rate');
                const chat_id = $('.rate_btn_holder').attr('chat-id');

                if (!chat_id || !rate) {
                    return;
                }

                $.ajax({
                    method: 'POST',
                    url: '{{ route("rateChat") }}',
                    data: {
                        chat_id: chat_id,
                        rate: rate,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.chat_ended_message').addClass('hide');
                            $('.rate_btn_holder').attr('chat-id', '');
                            $('.start_message').show();
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

        });

        function createChat() {
            return new Promise((resolve, reject) => {
                const formData = new FormData();
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    method: 'POST',
                    url: '{{ route("createChat") }}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response['success']) {
                            $('.popup_box_body_chat').attr('chat-id', response['chat_id']);
                            $('.start_message').hide();
                            $('.chat_ended_message').addClass('hide');
                            resolve(response['chat_id']);
                        } else {
                            showErrorMsg(response.info);
                            reject('Failed to create chat');
                        }
                    },
                    error: function(xhr) {
                        const response = JSON.parse(xhr.responseText);
                        showErrorMsg(response.info);
                        reject('Failed to create chat');
                    }
                });
            });
        }


        function fixTextarea() {
            const ele = $('.popup_box_body_input_txt');
            ele.css('height', 'auto');
            ele.css('height', this.scrollHeight - 20 + 'px');
            if (ele.height() > 80) {
                ele.css('height', '80px');
            }
            ele.scrollTop(ele[0].scrollHeight);
        }

        function showErrorMsg(err_msg) {
            if ($('.popup_error_msg').hasClass('show')) {
                return;
            }

            $('.popup_error_msg p').text(err_msg);
            $('.popup_error_msg').removeClass('hide').addClass('show');

            setTimeout(function() {
                $('.popup_error_msg').removeClass('show').addClass('hide');
            }, 6000);
        }

        $('.popup_error_msg_icon').on('click', function() {
            $('.popup_error_msg').removeClass('show').addClass('hide');
        });


        function registerImgPreview() {
            $('.popup_box img').mouseenter(function() {
                $('.popup_image_preview').removeClass('hide').addClass('show');
                $('.popup_image_preview_element').attr('src', $(this).attr('src'));
            });

            $('.popup_box img').mouseleave(function() {
                $('.popup_image_preview').removeClass('show').addClass('hide');
            });

            $('.popup_box img').on('click', function(event) {
                $('.popup_image_big_preview').addClass('show');
                $('.big_preview_element').attr('src', event.target.src);
            });
        }

        function waitImageLoad() {
            const images = $('.popup_box_body_chat img');

            let imagesLoaded = 0;
            $('.popup_box_body_chat img').on('load', function() {
                imagesLoaded++;
                if (imagesLoaded === images.length) {
                    $('.popup_box_body_chat').scrollTop($('.popup_box_body_chat')[0].scrollHeight);
                }
            });
        }

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



        function fetchNewMessages() {
            const chat_id = $('.popup_box_body_chat').attr('chat-id');

            $.ajax({
                method: 'GET',
                url: '{{ route("getNewMessages") }}',
                data: {
                    chat_id: chat_id,
                    last_msg_id: last_msg_id,
                    by_customer: 1,
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
                            if (element['type'] === 'TEXT') {
                                messageHtml = '<div class="popup_box_body_chat_msg ' + (element['by_customer'] ? 'user' : 'admin') + ' show"><div class="popup_box_body_chat_msg_txt">' + element['text'] + '</div></div>';
                            } else if (element['type'] === 'IMAGE') {
                                messageHtml = '<div class="popup_box_body_chat_msg ' + (element['by_customer'] ? 'user' : 'admin') + ' show"><div class="popup_box_body_chat_msg_img"><img src="' + element['image_url'] + '" alt="User Image"></div></div>';

                                const img = $('<img>').attr('src', element['image_url']);
                                const deferred = $.Deferred();

                                img.on('load', function() {
                                    deferred.resolve();
                                }).on('error', function() {
                                    deferred.reject();
                                });

                                image_load.push(deferred.promise());
                            } else if (element['type'] === 'PRODUCT') {
                                messageHtml = '<div class="popup_box_body_chat_msg ' + (element['by_customer'] ? 'admin product_msg' : 'user product_msg') + ' show"><div class="product_msg_header"><img src="' + element['image'] + '" alt="Product Image"><div class="product_msg_title">' + element['name'] + '(' + element['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="#">Click to View</a></div></div>';
                            }

                            $('.popup_box_body_chat').append(messageHtml);
                        });

                        $.when.apply($, image_load).done(function() {
                            registerImgPreview();
                            $('.popup_box_body_chat').scrollTop($('.popup_box_body_chat')[0].scrollHeight);

                        })
                        last_msg_id = response['last_msg_id'];

                    } else if (response.info === 'Chat is ended'){
                        $('.start_message').hide();
                        $('.popup_box_body_chat_msg').remove();
                        $('.chat_ended_message').removeClass('hide');
                        $('.rate_btn_holder').attr('chat-id', chat_id);
                        $('.popup_box_body_chat').attr('chat-id', '');
                        last_msg_id = 0;
                        clearInterval(intervalId);
                    }
                },
                error: function(xhr) {
                    const response = JSON.parse(xhr.responseText);
                    showErrorMsg(response.info);
                    clearInterval(intervalId);
                }
            });
        }
        

    </script>

</body>

</html>