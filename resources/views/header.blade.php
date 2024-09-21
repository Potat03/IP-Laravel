<!-- Template for customer side  -->
<!-- Author: Loo Wee Kiat & Loh Thiam Wei -->

<!-- Header nav bar  -->
<!-- Author: Loo Wee Kiat -->
<nav class="navbar navbar-expand-lg sticky-top px-5 navbar-light bg-light" style="z-index:999;">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}"><img src="{{ asset('images/logo.png') }}" width="60" height="60">Futatabi</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4 gap-3">
            <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">Shop</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="{{ url('/shop') }}">All Products</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="{{ url('/shop/new-arrivals') }}">New Arrivals</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('promotion')}}">Promotion</a>
            </li>
        </ul>

        <form class="d-flex m-0">
            <button class="btn btn-outline-dark" type="button" onclick="window.location.href=`{{ url('/cart') }}`">
                <i class="fa-solid fa-cart-shopping"></i>
                Cart
                <span class="badge bg-dark text-white ms-1 rounded-pill">0</span>
            </button>
        </form>

        <ul class="navbar-nav mb-lg-0">
            @auth('customer')
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" role="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-solid fa-user"></i> Profile
                </a>
                <ul class="dropdown-menu" aria-labelledby="profileDropdown">
                    <li><a class="dropdown-item" href="{{ url('/profileSec') }}">User Profile</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('auth.logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">Logout</button>
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <a href="{{ url('/userlogin') }}">
                <button class="btn btn-outline-dark mx-lg-2">
                    <i class="fa-solid fa-sign-in"></i> Sign in
                </button>
            </a>
            @endauth

        </ul>
    </div>
</nav>

<!-- Customer Service Chat Part -->
<!-- Author: Loh Thiam Wei -->
@include('partials.fontawesome')
<link href="{{ asset('css/support_popup.css') }}" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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
    var last_msg_id = 0; // to keep try of last message id (use when fetch new message)
    let intervalId = null; // to keep track of interval id for fetch new message (use to clear loop and set loop for fetch new msg)
    var productRoute = "{{ url('product') }}"; // a url to product page (use to redirect to product page when click on product message)
    $(document).ready(function() {

        //init chat
        // if got active/pending chat before, use that
        // else show msg to enter to start
         $.ajax({
            method: 'GET',
            url: '{{ route("getCustomerChat") }}',
            success: function(response) {
                if (response['success']) {
                    const messages = response['messages'];
                    messages.forEach(element => {
                        messageHtml = generateMsgHtml(element);
                        console.log(messageHtml);
                        $('.popup_box_body_chat').append(messageHtml);
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

        // show popup
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

        // close popup
        $('.popup_box_header_icon').click(function() {
            $('.popup_box').removeClass('show').addClass('hide');
            $('.popup_btn_txt').removeClass('hide').addClass('show');
        });

        // add event lister to close error box when click
        $('.popup_error_msg').on('click', function() {
            $(this).removeClass('show').addClass('hide');
        });

        // auto resize textarea
        $('.popup_box_body_input textarea').on('input change', function() {
            $(this).css('height', 'auto');
            $(this).css('height', this.scrollHeight + 'px');
            if ($(this).height() > 50) {
                $(this).css('height', '50px');
            }
            $(this).scrollTop($(this)[0].scrollHeight);
        });

        // detect pasting image on textarea
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

        // to leave big preview on click
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

            //get msg in input
            var message = $('.popup_box_body_input_txt').val();

            // get image pasted in
            var images = $('.paste_area img');
            var imageSrc = images.length > 0 ? images.first().attr('src') : null;

            // if no input ignore
            if (message === '' && !imageSrc) {
                return;
            }

            // clear input box and image paste area
            $('.popup_box_body_input_txt').val('');
            $('.paste_area img').remove();
            $('.paste_area_remove').remove();
            $('.paste_area').removeClass('show');
            fixTextarea();

            // if in newline of text area add <br> to the message
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

            // Form data that is same for all types of message
            const formData = new FormData();
            formData.append('chat_id', chat_id);
            formData.append('by_customer', 1);
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('message_type', null);
            formData.append('message_content', null);

            if (imageSrc) {
                formData.set('message_type', 'image');
                formData.set('message_content', dataURLToBlob(imageSrc), 'image.png');
                sendMsgAjax(formData);
            }

            if (message !== '') {
                //replace message type and content
                formData.set('message_type', 'text');
                formData.set('message_content', message);
                sendMsgAjax(formData);
            }

        });

        // send product to chat using button
        $('#btn-send-to-chat').on('click', async function() {
            //send msg ajax
            var product_id = $(this).attr('data-product-id');
            if (product_id == null || product_id == 0) {
                return;
            }

            var chat_id = $('.popup_box_body_chat').attr('chat-id');

            if (!chat_id) {
                chat_id = await createChat()
            };

            if (!chat_id) {
                showErrorMsg('Failed to create chat');
                return;
            };

            // Form data that is same for all types of message
            const formData = new FormData();
            formData.append('chat_id', chat_id);
            formData.append('by_customer', 1);
            formData.append('_token', "{{ csrf_token() }}");
            formData.append('message_type', "product");
            formData.append('message_content', product_id);

            sendMsgAjax(formData);
        });

        // Rate chat
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


    // API functions
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
    
    function sendMsgAjax(formData) {
        clearInterval(intervalId);
        $.ajax({
            method: 'POST',
            url: $('#msg_form').attr('action'),
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.success == true) {
                    fetchNewMessages();
                } else {
                    showErrorMsg(response.info);
                }
                intervalId = setInterval(fetchNewMessages, 2000);
            },
            error: function(xhr) {
                const response = JSON.parse(xhr.responseText);

                showErrorMsg(response.info);
                if (response.status != 500) {
                    intervalId = setInterval(fetchNewMessages, 2000);
                }
            }
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

                        if ($('.popup_box_body_chat_msg[msg-id="' + element['message_id'] + '"]').length > 0) {
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

                        messageHtml = generateMsgHtml(element);

                        $('.popup_box_body_chat').append(messageHtml);
                    });

                    $.when.apply($, image_load).done(function() {
                        registerImgPreview();
                        $('.popup_box_body_chat').scrollTop($('.popup_box_body_chat')[0].scrollHeight);

                    })
                    last_msg_id = response['last_msg_id'];

                } else if (response.info === 'Chat is ended') {
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
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="popup_box_body_chat_msg ' + (msg['by_customer'] ? 'user' : 'admin') + ' show"><div class="popup_box_body_chat_msg_txt">' + msg['text'] + '</div></div>';
        } else if (msg['type'] === 'IMAGE') {
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="popup_box_body_chat_msg ' + (msg['by_customer'] ? 'user' : 'admin') + ' show"><div class="popup_box_body_chat_msg_img"><img src="' + msg['image_url'] + '" alt="User Image"></div></div>';
        } else if (msg['type'] === 'PRODUCT') {
            messageHtml = '<div msg-id="' + msg['message_id'] + '" class="popup_box_body_chat_msg ' + (msg['by_customer'] ? 'user' : 'admin') + ' product_msg show"><div class="product_msg_header"><img src="' + msg['image'] + '" alt="Product Image"><div class="product_msg_title">' + msg['name'] + '(' + msg['id'] + ')</div></div><div class="product_msg_link"><hr><a class="product_msg_footer" href="' + productRoute + '/' + msg['id'] + '">Click to View</a></div></div>';
        }
        return messageHtml;
    }


    // UI functions
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

    function fixTextarea() {
        const ele = $('.popup_box_body_input_txt');
        ele.css('height', 'auto');
        ele.css('height', this.scrollHeight - 20 + 'px');
        if (ele.height() > 80) {
            ele.css('height', '80px');
        }
        ele.scrollTop(ele[0].scrollHeight);
    }

</script>