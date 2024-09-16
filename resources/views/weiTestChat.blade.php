<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Message</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <h1>Send Message</h1>
    <form id="messageForm" enctype="multipart/form-data">
        @csrf
        <label for="message_type">Message Type:</label>
        <select name="message_type" id="message_type" required>
            <option value="text">Text</option>
            <option value="image">Image</option>
            <option value="product">Product</option>
        </select>
        <br><br>

        <div id="textContent">
            <label for="message_content">Message Content:</label>
            <input type="text" name="message_content" id="message_content_text">
        </div>

        <div id="imageContent" style="display: none;">
            <label for="message_content">Upload Image:</label>
            <input type="file" name="message_content" id="message_content_image">
        </div>

        <div id="productContent" style="display: none;">
            <label for="message_content">Product ID:</label>
            <input type="number" name="message_content" id="message_content_product">
        </div>

        <br>
        <button type="submit">Send Message</button>
    </form>

    <script>
        document.getElementById('message_type').addEventListener('change', function() {
            var type = this.value;
            document.getElementById('textContent').style.display = type === 'text' ? 'block' : 'none';
            document.getElementById('imageContent').style.display = type === 'image' ? 'block' : 'none';
            document.getElementById('productContent').style.display = type === 'product' ? 'block' : 'none';
        });

        $(document).ready(function() {
            $('#messageForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('message_type', $('#message_type').val());

                var message_type = $('#message_type').val();
                var message_content = null;

                if (message_type === 'text') {
                    message_content = $('#message_content_text').val();
                } else if (message_type === 'image') {
                    message_content = $('#message_content_image').prop('files')[0];
                } else if (message_type === 'product') {
                    message_content = $('#message_content_product').val();
                }

                formData.append('message_content', message_content);

                $.ajax({
                    method: 'POST',
                    url: '{{ route("sendMsg") }}',
                    data: formData,
                    contentType: false, 
                    processData: false, 
                    success: function(response) {
                        console.log(response);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>

</html>