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
            <p>You can only upload 3 Image at a time</p>
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
                <div class="popup_box_body_chat_msg_select">
                    <div class="popup_box_body_chat_msg_select_item">How can I track my order ?</div>
                    <div class="popup_box_body_chat_msg_select_item">What payment methods do you accept ?</div>
                    <div class="popup_box_body_chat_msg_select_item">Can I change or cancel my order ?</div>
                    <div class="popup_box_body_chat_msg_select_item">What is your shipping policy ?</div>
                </div>

                <div class="popup_box_body_chat_msg admin">
                    <div class="popup_box_body_chat_msg_txt">Hi, How can I help you?</div>
                    <div class="popup_box_body_chat_msg_auto">Auto-Generated Message</div>
                </div>


                <div class="popup_box_body_chat_msg user">
                    <div class="popup_box_body_chat_msg_txt">Hello<br>HelloHelloHelloHelloHelloHelloHelloHelloHelloHello</div>
                </div>

                <div class="popup_box_body_chat_msg admin">
                    <div class="popup_box_body_chat_msg_txt">Hi, How can I help you?</div>
                </div>

                <div class="popup_box_body_chat_msg admin">
                    <div class="popup_box_body_chat_msg_img">
                        <img src="https://via.placeholder.com/48" alt="User Image">
                    </div>
                </div>

                <div class="popup_box_body_chat_msg admin product_msg">
                    <div class="product_msg_header">
                        <img src="https://via.placeholder.com/48" alt="Product Image">
                        <div class="popup_box_body_chat_msg_txt product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                    </div>
                    <div class="product_msg_link">
                        <hr>
                        <a class="product_msg_footer" href="#">Click to View</a>
                    </div>
                </div>

                <div class="popup_box_body_chat_msg user product_msg">
                    <div class="product_msg_header">
                        <img src="https://via.placeholder.com/48" alt="Product Image">
                        <div class="popup_box_body_chat_msg_txt product_msg_title">Product nam(123333) This ggodd This ggoddThis ggoddThis ggoddThis ggoddThis ggodd</div>
                    </div>
                    <div class="product_msg_link">
                        <hr>
                        <a class="product_msg_footer" href="#">Click to View</a>
                    </div>
                </div>

            </div>
            <div class="paste_area">
                <p class="paste_area_txt">Upload Image</p>

                <p class="paste_area_txt">Max (3)</p>
            </div>
            <div class="popup_box_body_input">
                <textarea type="text" class="popup_box_body_input_txt" placeholder="Type your message..." rows="1"></textarea>
                <div class="popup_box_body_input_send">
                    <i class="fa-solid fa-paper-plane"></i>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            $('.popup_btn_icon, .popup_btn_txt').click(function() {
                var popupBox = $('.popup_box');
                var popupTxt = $('.popup_btn_txt');

                if (popupBox.hasClass('show')) {
                    popupBox.removeClass('show').addClass('hide');
                    popupTxt.removeClass('hide').addClass('show');
                    $('.popup_box_body_chat_msg').removeClass('show');
                } else {
                    popupBox.removeClass('hide').addClass('show');
                    popupTxt.removeClass('show').addClass('hide');
                    $('.popup_box_body_chat_msg').each(function(index) {
                        $(this).delay(index * 100).queue(function(next) {
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
                $(this).css('height', this.scrollHeight  + 'px');
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

            $('.big_preview_bg').on('click', function() {
                $('.popup_image_big_preview').removeClass('show');
            });


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
            registerImgPreview();
        });
    </script>

</body>

</html>