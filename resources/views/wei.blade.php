<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Wei Main Testing Page</title>
    <style>
        #chat-box {
            border: 1px solid #ccc;
            padding: 10px;
            max-height: 800px;
            overflow-y: scroll;
        }
        .message {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<h1>Chat</h1>
    <div id="chat-box">
        <!-- Messages will be displayed here -->
    </div>
    <form id="message-form">
        <input type="text" id="message" placeholder="Type your message...">
        <button type="submit">Send</button>
    </form>

    <script>
        const chatBox = document.getElementById('chat-box');
        const messageForm = document.getElementById('message-form');
        const messageInput = document.getElementById('message');
        const userId = 1; // Example user ID

        // Function to fetch messages from the server
        function fetchMessages() {
            fetch(`/chat/${userId}`)
                .then(response => response.json())
                .then(data => {
                    chatBox.innerHTML = ''; // Clear the chat box
                    data.messages.forEach(message => {
                        const messageElement = document.createElement('div');
                        messageElement.className = 'message';
                        console.log(message);
                        messageElement.textContent = '[' + message.created_at + ']  ' + message.message; // Adjust according to your message structure
                        chatBox.appendChild(messageElement);
                    });
                });
        }

        // Function to send a new message
        function sendMessage(message) {
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message: message, user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                console.log('Message sent:', data.message);
                messageInput.value = ''; // Clear the input field
                fetchMessages(); // Refresh the messages after sending
            });
        }

        // Event listener for the message form
        messageForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = messageInput.value;
            if (message.trim() !== '') {
                sendMessage(message);
            }
        });

        // Initial fetch of messages
        fetchMessages();

        // Periodically fetch messages every 5 seconds
        setInterval(fetchMessages, 5000);
    </script>
</body>
</html>