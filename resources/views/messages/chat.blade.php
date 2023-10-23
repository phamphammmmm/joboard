<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4;
    }

    .chat-container {
        display: flex;
        flex-direction: column;
        height: 100vh;
    }

    .chat-messages {
        flex-grow: 1;
        overflow-y: scroll;
        padding: 20px;
        background-color: #fff;
    }

    .message {
        margin-bottom: 10px;
        padding: 10px;
        border-radius: 10px;
        max-width: 70%;
    }

    .message.sent {
        align-self: flex-end;
        background-color: #4caf50;
        color: #fff;
    }

    .message.received {
        align-self: flex-start;
        background-color: #e0e0e0;
        color: #000;
    }

    .message input {
        width: calc(100% - 20px);
        border: none;
        outline: none;
        padding: 10px;
        border-radius: 5px;
    }

    .message button {
        margin-top: 10px;
        padding: 10px;
        border: none;
        background-color: #4caf50;
        color: #fff;
        cursor: pointer;
        border-radius: 5px;
    }
    </style>
</head>

<body>
    <div class="chat-container">
        <div class="chat-messages" id="chat-messages">
            <!-- Tin nhắn sẽ được hiển thị ở đây -->
        </div>



        <div class="message">
            <input type="text" id="message-input" placeholder="Nhập tin nhắn...">
            <button id="send-button">Gửi</button>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pusher/7.0.3/pusher.min.js"></script>
    <script>
    const pusher = new Pusher('84edbb8be57c52b1a11b', {
        cluster: 'ap1',
        encrypted: true
    });

    const channel = pusher.subscribe('chat-channel');
    const chatMessages = document.getElementById('chat-messages');
    const messageInput = document.getElementById('message-input');

    document.getElementById('send-button').addEventListener('click', function() {
        const messageText = messageInput.value.trim();
        if (messageText) {
            sendMessage(messageText);
            messageInput.value = '';
        }
    });

    messageInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            const messageText = messageInput.value.trim();
            if (messageText) {
                sendMessage(messageText);
                messageInput.value = '';
            }
        }
    });

    function sendMessage(messageText) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', 'sent');
        messageDiv.textContent = messageText;
        chatMessages.appendChild(messageDiv);

        // Gửi tin nhắn lên server
        axios.post('/send-message', {
            message: messageText
        }).then(response => {
            console.log(response.data);
        }).catch(error => {
            console.error(error);
        });
    }

    channel.bind('new-message', function(data) {
        const messageDiv = document.createElement('div');
        messageDiv.classList.add('message', 'received');
        messageDiv.textContent = data.message;
        chatMessages.appendChild(messageDiv);
    });
    </script>
</body>

</html>