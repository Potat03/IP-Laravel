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

<body>
    <div class="popup_btn">
        <div class="popup_btn_txt show">Need Some Help ? <br> <strong>Click Here</strong></div>
        <div class="popup_btn_icon shadow">
            <i class="fa-solid fa-comments-question"></i>
        </div>
    </div>


    <div class="popup_box hide">
        <div class="popup_box_header">
            <div class="popup_box_header_txt">Customer Support</div>
            <div class="popup_box_header_icon">
                <i class="fa-sharp fa-regular fa-circle-xmark"></i>
            </div>
        </div>
        <div class="popup_box_body">
            <div class="popup_box_body_chat">
                <div class="popup_box_body_chat_msg user">
                    <div class="popup_box_body_chat_msg_txt">Hello</div>
                </div>
                <div class="popup_box_body_chat_msg admin">
                    <div class="popup_box_body_chat_msg_txt">Hi, How can I help you?</div>
                </div>
            </div>
            <div class="popup_box_body_input">
                <input type="text" class="popup_box_body_input_txt" placeholder="Type your message...">
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
                } else {
                    popupBox.removeClass('hide').addClass('show');
                    popupTxt.removeClass('show').addClass('hide');
                }
            });

            $('.popup_box_header_icon').click(function() {
                $('.popup_box').removeClass('show').addClass('hide');
                $('.popup_btn_txt').removeClass('hide').addClass('show');
            });
        });
    </script>

</body>

</html>