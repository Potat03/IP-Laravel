<!DOCTYPE html>
<html>
<head>
    <title>Chat Test Page</title>
</head>
<body>
    <h1>Chat Message Test</h1>

    <form action="{{ route('send.message') }}" method="POST">
        @csrf
        <h2>Send Message</h2>
        <label for="chat_id">Chat ID:</label>
        <input type="text" id="chat_id" name="chat_id" required>
        <br>
        <label for="by_customer">By Customer:</label>
        <input type="checkbox" id="by_customer" name="by_customer" value="1">
        <br>
        <label for="message_content">Message Content:</label>
        <textarea id="message_content" name="message_content" required></textarea>
        <br>
        <label for="message_type">Message Type:</label>
        <select id="message_type" name="message_type" required>
            <option value="text">Text</option>
            <option value="image">Image</option>
            <option value="product">Product</option>
        </select>
        <br>
        <button type="submit">Send Message</button>
    </form>

    <form action="{{ route('get.messages') }}" method="GET">
        <h2>Get Messages</h2>
        <label for="chat_id">Chat ID:</label>
        <input type="text" id="chat_id" name="chat_id" required>
        <br>
        <label for="admin_id">Admin ID:</label>
        <input type="text" id="admin_id" name="admin_id" required>
        <br>
        <button type="submit">Get Messages</button>
    </form>
</body>
</html>
